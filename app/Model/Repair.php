<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Repair extends Model {
    protected $table = 'repairs';
    public $timestamps = false;
    protected $fillable = ['equipment_id','breakdown_date','repair_date','description','price'];
    public function equipment() { return $this->belongsTo(Equipment::class); }
}
