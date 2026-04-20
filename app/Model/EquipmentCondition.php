<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;

class EquipmentCondition extends Model
{
    public $timestamps = false;
    protected $table = 'equipment_condition';
    protected $primaryKey = 'ID_status_code';
}