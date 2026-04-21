<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Equipment;
use Model\Repair;
use Model\Department;

class LabController
{
    // просмотр оборудования
    public function index(): string
    {
        $equipment = Equipment::all();
        return (new View())->render('equipment.index', ['equipment' => $equipment]);
    }

    // история ремонтов
    public function repair(Request $request): string
    {
        if ($request->method === 'POST') {
            Repair::create($request->all());
        }
        $repairs = Repair::all();
        return (new View())->render('lab.repair', ['repairs' => $repairs]);
    }

    //подсчет стоимости
    public function report(Request $request): string
    {
        $query = Equipment::query();

        if ($request->department_id) {
            $query->where('ID_department', $request->department_id);
        }

        $totalCost = $query->sum('Price');

        //список кафедр
        $departments = Department::all();

        return (new View())->render('report.index', [
            'total' => $totalCost,
            'departments' => $departments,
            'selectedDepartment' => $request->department_id ?? null
        ]);
    }

    public function createRepair($id, Request $request): string
    {
        $inventoryNumber = $id;

        if ($request->method === 'POST') {
            Repair::create($request->all());

            if (!empty($request->Repair_date)) {
                $eq = \Model\Equipment::find($inventoryNumber);
                if ($eq) {
                    $eq->ID_status_code = 1;
                    $eq->save();
                }
            } else {
                $eq = \Model\Equipment::find($inventoryNumber);
                if ($eq) {
                    $eq->ID_status_code = 2;
                    $eq->save();
                }
            }

            app()->route->redirect('/equipment/show/' . urlencode($inventoryNumber));
        }

        return (new View())->render('repair.create', [
            'inventory_number' => $inventoryNumber
        ]);
    }
}
