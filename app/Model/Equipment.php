<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    public $timestamps = false;

    protected $fillable = [
        'inventory_number', 'name', 'model',
        'commissioning_date', 'price',
        'condition_id', 'department_id', 'employee_role_id'
    ];

    public function condition()
    {
        return $this->belongsTo(EquipmentCondition::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Ответственный — через employee_role
    public function employeeRole()
    {
        return $this->belongsTo(EmployeeRole::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class);
    }

    // Амортизация: 10% в год
    public function getDepreciationAttribute(): float
    {
        $years = (int) date('Y') - (int) date('Y', strtotime($this->commissioning_date));
        return round($this->price * 0.1 * $years, 2);
    }
}