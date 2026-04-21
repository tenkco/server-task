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
        $equipment = Equipment::find($id);

        if (!$equipment) {
            app()->route->redirect('/equipment');
        }

        if ($request->method === 'POST') {
            \Model\Repair::create([
                'Inventory_number' => $equipment->Inventory_number,
                'Date_of_breakdown' => $request->Date_of_breakdown,
                'Repair_date' => $request->Repair_date,
                'Description_of_work' => $request->Description_of_work,
                'Price' => $request->Price
            ]);

            if (!empty($request->Repair_date) && $request->Repair_date <= date('Y-m-d')) {
                $equipment->ID_status_code = 1;
                $equipment->save();
            } else {
                $equipment->ID_status_code = 2;
                $equipment->save();
            }

            app()->route->redirect('/equipment/show/' . urlencode($equipment->Inventory_number));
        }

        return (new View())->render('repair.create', [
            'inventory_number' => $equipment->Inventory_number,
            'equipmentName' => $equipment->Name,
            'request' => $request
        ]);
    }
}
