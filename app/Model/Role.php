<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $table = 'roles';
    protected $primaryKey = 'ID_role_name';
}