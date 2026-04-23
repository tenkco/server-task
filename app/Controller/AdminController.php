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
            $login = trim($request->login ?? '');
            $password = $request->password ?? '';
            $roleId = $request->ID_role_name ?? null;

            if ($login === '' || $password === '') {
                return (new View())->render('admin.add_user', [
                    'message' => 'Заполните логин и пароль',
                    'request' => $request,
                    'roles' => Role::all()
                ]);
            }

            if (Employee::where('login', $login)->exists()) {
                return (new View())->render('admin.add_user', [
                    'message' => 'Логин "' . htmlspecialchars($login) . '" уже занят',
                    'request' => $request,
                    'roles' => Role::all()
                ]);
            }

            if (!$roleId) {
                return (new View())->render('admin.add_user', [
                    'message' => 'Выберите роль пользователя',
                    'request' => $request,
                    'roles' => Role::all()
                ]);
            }

            $employee = Employee::create([
                'login' => $login,
                'password' => $password
            ]);

            if ($employee && $roleId) {
                EmployeeRole::create([
                    'ID_employee' => $employee->ID_employee,
                    'ID_role_name' => $roleId
                ]);
            }

            return (new View())->render('admin.add_user', [
                'message' => 'Пользователь успешно добавлен',
                'request' => new \Src\Request(),
                'roles' => Role::all()
            ]);
        }

        return (new View())->render('admin.add_user', [
            'request' => $request,
            'roles' => Role::all()
        ]);
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
            $files = $request->files();

            if (!empty($files['image']['name'])) {
                $file = $files['image'];
                $fileName = time() . '_' . $file['name'];
                $destination = __DIR__ . '/../../public/uploads/equipment/' . $fileName;
                move_uploaded_file($file['tmp_name'], $destination);
                $data['image'] = $fileName;
            }

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