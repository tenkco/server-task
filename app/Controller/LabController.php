<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Equipment;
use Model\Repair;
use Model\Department;

class LabController
{
    // просмотр и поиск оборудования
    public function index(Request $request): string
    {
        $search = trim(($request->all()['search'] ?? ''));
        $query = Equipment::with(['department', 'condition']);

        if ($search !== '') {
            $query->where('Name', 'like', "%{$search}%");
        }

        $equipment = $query->get();
        return (new View())->render('equipment.index', [
            'equipment' => $equipment,
            'search'    => $search
        ]);
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
            if (empty($request->Date_of_breakdown) || empty($request->Repair_date) || empty($request->Description_of_work)) {
                return (new View())->render('repair.create', [
                    'message' => 'Ремонт добавлен',
                    'request' => $request,
                    'inventory_number' => $equipment->Inventory_number,
                    'equipmentName' => $equipment->Name
                ]);
            }

            \Model\Repair::create([
                'Inventory_number' => $equipment->Inventory_number,
                'Date_of_breakdown' => $request->Date_of_breakdown,
                'Repair_date' => $request->Repair_date,
                'Description_of_work' => $request->Description_of_work,
                'Price' => $request->Price ?? 0
            ]);

            if ($request->Repair_date <= date('Y-m-d')) {
                $equipment->ID_status_code = 1;
            } else {
                $equipment->ID_status_code = 2;
            }
            $equipment->save();

            return (new View())->render('repair.create', [
                'message' => 'Ремонт успешно добавлен!',
                'request' => new \Src\Request(),
                'inventory_number' => $equipment->Inventory_number,
                'equipmentName' => $equipment->Name
            ]);
        }

        return (new View())->render('repair.create', [
            'request' => $request,
            'inventory_number' => $equipment->Inventory_number,
            'equipmentName' => $equipment->Name
        ]);
    }
}
