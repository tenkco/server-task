<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Department extends Model {
    protected $table = 'departments';
    public $timestamps = false;
    protected $fillable = ['name'];
}
