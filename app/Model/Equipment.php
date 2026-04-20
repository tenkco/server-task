<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $timestamps = false;
    protected $table = 'equipment';
    protected $primaryKey = 'Inventory_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Inventory_number', 'Name', 'Model', 'Price',
        'Commissioning_date', 'ID_status_code', 'ID_department', 'ID_employee_role'
    ];

    public function condition()
    {
        return $this->belongsTo(EquipmentCondition::class, 'ID_status_code', 'ID_status_code');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'ID_department', 'ID_department');
    }

    public function responsible()
    {
        return $this->belongsTo(EmployeeRole::class, 'ID_employee_role', 'ID_employee_role');
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class, 'Inventory_number', 'Inventory_number');
    }
}