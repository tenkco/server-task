<?php
namespace Controller;

use Src\View;
use Src\Request;
use Model\Equipment;
use Model\Repair;

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
    public function report(): string
    {
        $totalCost = Equipment::sum('Price');
        return (new View())->render('report.index', ['total' => $totalCost]);
    }
}
