<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Equipment;
use Model\Employee;
use Model\Department;
use Model\EmployeeRole;
use Model\Role;
use Src\Validator\Validator;

class AdminController
{
    public function manageUsers(Request $request): string
    {
        $employees = Employee::all();
        return (new View())->render('admin.users', ['employees' => $employees]);
    }

    public function addUser(Request $request): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = trim($_POST['login'] ?? '');
            $password = $_POST['password'] ?? '';
            $roleId = $_POST['ID_role_name'] ?? null;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Equipment::create($_POST);
        }
        $equipment = Equipment::all();
        return (new View())->render('admin.manage', ['equipment' => $equipment]);
    }

    public function create(Request $request): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $files = $_FILES;
            $dataToValidate = $data;
            if (!empty($files['image'])) {
                $dataToValidate['image'] = $files['image'];
            }

            $rules = [
                'Name' => ['required'],
                'Model' => [],
                'Price' => ['required', 'positiveNumber'],
                'Commissioning_date' => ['required', 'date'],
            ];

            if (!empty($files['image']['name'])) {
                $rules['image'] = ['image'];
            }

            $validator = new Validator($dataToValidate, $rules);

            if (!$validator->validate()) {
                return (new View())->render('equipment.create', [
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                    'request' => $request,
                    'departments' => Department::all(),
                    'employees' => EmployeeRole::with(['employee', 'role'])->get()
                ]);
            }

            $imageName = null;
            if (!empty($files['image']['name'])) {
                $file = $files['image'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $imageName = time() . '_' . uniqid() . '.' . $ext;

                $destination = __DIR__ . '/../../public/uploads/equipment/' . $imageName;

                if (!move_uploaded_file($file['tmp_name'], $destination)) {
                    return (new View())->render('equipment.create', [
                        'message' => json_encode(['image' => 'Ошибка загрузки файла на сервер'], JSON_UNESCAPED_UNICODE),
                        'request' => $request,
                    ]);
                }
            }

            Equipment::create([
                'Name' => $data['Name'],
                'Model' => $data['Model'] ?? null,
                'Price' => $data['Price'],
                'Commissioning_date' => $data['Commissioning_date'],
                'ID_status_code' => 1,
                'ID_department' => $data['ID_department'] ?? null,
                'ID_employee_role' => $data['ID_employee_role'] ?? null,
                'image' => $imageName
            ]);

            app()->route->redirect('/equipment');
        }

        return (new View())->render('equipment.create', [
            'request' => $request,
            'departments' => Department::all(),
            'employees' => EmployeeRole::with(['employee', 'role'])->get()
        ]);
    }
}