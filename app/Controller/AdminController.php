<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Equipment;
use Model\Employee;

class AdminController
{
    // управление оборудованием
    public function manage(Request $request): string
    {
        if ($request->method === 'POST') {
            Equipment::create($request->all());
        }
        $equipment = Equipment::all();
        return (new View())->render('admin.manage', ['equipment' => $equipment]);
    }
}
