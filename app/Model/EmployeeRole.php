<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    public $timestamps = false;
    protected $table = 'employee_role';
    protected $primaryKey = 'ID_employee_role';

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'ID_employee', 'ID_employee');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'ID_role_name', 'ID_role_name');
    }
}