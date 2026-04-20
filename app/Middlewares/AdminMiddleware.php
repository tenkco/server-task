<?php
namespace Middlewares;

use Src\Request;
use Src\Auth\Auth;
use Model\EmployeeRole;

class AdminMiddleware
{
    public function handle(Request $request)
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
            return;
        }

        $user = Auth::user();
        $isAdmin = \Illuminate\Database\Capsule\Manager::table('employee_role')
            ->where('ID_employee', $user->ID_employee)
            ->where('ID_role_name', 1) // 1 = ID Администратора из таблицы roles
            ->exists();

        if (!$isAdmin) {
            app()->route->redirect('/equipment');
        }
    }
}
