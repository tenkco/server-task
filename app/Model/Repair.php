<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    public $timestamps = false;
    protected $table = 'repairs';
    protected $fillable = ['Date_of_breakdown', 'Repair_date', 'Description_of_work', 'Price', 'Inventory_number'];
}