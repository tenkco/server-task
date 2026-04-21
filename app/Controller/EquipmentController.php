<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Equipment;

class EquipmentController
{
    public function show($id): string
    {
        $equipment = Equipment::with(['repairs', 'condition', 'department'])->find($id);

        if (!$equipment) {
            app()->route->redirect('/equipment');
        }

        $today = date('Y-m-d');
        foreach ($equipment->repairs as $repair) {
            if ($repair->Repair_date && $repair->Repair_date <= $today && $equipment->ID_status_code != 1) {
                $equipment->ID_status_code = 1;
                $equipment->save();

                $equipment = Equipment::with(['repairs', 'condition', 'department'])->find($id);
                break;
            }
        }

        $responsible = null;
        if ($equipment->ID_employee_role) {
            $responsible = \Model\EmployeeRole::with(['employee', 'role'])
                ->where('ID_employee_role', $equipment->ID_employee_role)
                ->first();
        }

        $employees = \Model\EmployeeRole::with(['employee', 'role'])->get();

        return (new View())->render('equipment.show', [
            'equipment' => $equipment,
            'responsible' => $responsible,
            'employees' => $employees
        ]);
    }

    public function setResponsible($id, Request $request): void
    {
        $equipment = Equipment::find($id);

        if ($equipment) {
            $equipment->ID_employee_role = $request->ID_employee_role ?: null;
            $equipment->save();
        }

        app()->route->redirect('/equipment/show/' . urlencode($id));
    }

    public function setStatus($id, Request $request): void
    {
        $equipment = \Model\Equipment::find($id);
        if ($equipment) {
            $equipment->ID_status_code = $request->ID_status_code;
            $equipment->save();
        }
        app()->route->redirect('/equipment/show/' . urlencode($id));
    }
}