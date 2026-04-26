<?php
namespace Controller\Api;

use Src\Request;
use Src\View;
use Model\Employee;
use Model\Role;
use Model\EmployeeRole;

class UserController
{
    /**
     * POST /api/users
     */
    public function store(Request $request): void
    {
        if (!isset($request->authUser)) {
            http_response_code(401);
            (new View())->toJSON(['error' => 'Unauthorized']);
            return;
        }

        $userRole = EmployeeRole::where('ID_employee', $request->authUser->id)
            ->join('roles', 'roles.ID_role_name', '=', 'employee_role.ID_role_name')
            ->first();

        if (!$userRole || $userRole->Role_name !== 'admin') {
            http_response_code(403);
            (new View())->toJSON(['error' => 'Access denied. Admin role required']);
            return;
        }

        $data = $request->all();

        if (empty($data['login']) || empty($data['password'])) {
            http_response_code(400);
            (new View())->toJSON(['error' => 'Login and password are required']);
            return;
        }

        if (Employee::where('login', $data['login'])->exists()) {
            http_response_code(409);
            (new View())->toJSON(['error' => 'Login already exists']);
            return;
        }

        $employee = Employee::create([
            'login' => $data['login'],
            'password' => md5($data['password']),
            'full_name' => $data['full_name'] ?? '',
        ]);

        if (!empty($data['ID_role_name'])) {
            EmployeeRole::create([
                'ID_employee' => $employee->id,
                'ID_role_name' => $data['ID_role_name'],
            ]);
        }

        (new View())->toJSON([
            'success' => true,
            'message' => 'User created successfully',
            'user' => [
                'id' => $employee->id,
                'login' => $employee->login,
                'full_name' => $employee->full_name,
            ]
        ]);
    }

    /**
     * GET /api/users
     */
    public function index(Request $request): void
    {
        if (!isset($request->authUser)) {
            http_response_code(401);
            (new View())->toJSON(['error' => 'Unauthorized']);
            return;
        }

        $users = Employee::with(['employeeRole.role'])->get()->toArray();
        (new View())->toJSON($users);
    }
}