<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Equipment;
use Model\Employee;
use Model\Department;
use Model\EmployeeRole;
use Model\Role;

class AdminController
{
    public function manageUsers(Request $request): string
    {
        $employees = Employee::all();
        return (new View())->render('admin.users', ['employees' => $employees]);
    }

    public function addUser(Request $request): string
    {
        if ($request->method === 'POST') {
            $login = trim($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($login === '' || $password === '') {
                return (new View())->render('admin.add_user', [
                    'error' => 'Заполните логин и пароль'
                ]);
            }

            \Model\Employee::create([
                'login' => $login,
                'password' => $password
            ]);

            app()->route->redirect('/admin/users');
        }

        return (new View())->render('admin.add_user');
    }

    public function manage(Request $request): string
    {
        if ($request->method === 'POST') {
            Equipment::create($request->all());
        }
        $equipment = Equipment::all();
        return (new View())->render('admin.manage', ['equipment' => $equipment]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();

            if (empty($data['Name'])) {
                return (new View())->render('equipment.create', [
                    'message' => 'Заполните обязательные поля',
                    'request' => $request,
                    'departments' => Department::all(),
                    'employees' => EmployeeRole::with(['employee', 'role'])->get()
                ]);
            }

            unset($data['Inventory_number']);

            Equipment::create($data);
            app()->route->redirect('/equipment');
        }

        return (new View())->render('equipment.create', [
            'request' => $request,
            'departments' => Department::all(),
            'employees' => EmployeeRole::with(['employee', 'role'])->get()
        ]);
    }
}