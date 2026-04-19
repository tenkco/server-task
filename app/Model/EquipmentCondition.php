<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class EquipmentCondition extends Model {
    protected $table = 'equipment_conditions';
    public $timestamps = false;
    protected $fillable = ['name'];
}
