<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Employee extends Model implements IdentityInterface
{
    public $timestamps = false;
    protected $table = 'employees';
    protected $primaryKey = 'ID_employee';

    protected $fillable = ['Login', 'password'];

    protected static function booted()
    {
        static::created(function ($employee) {
            $employee->password = md5($employee->password);
            $employee->save();
        });
    }

    public function findIdentity(int $id)
    {
        return self::where('ID_employee', $id)->first();
    }

    public function getId(): int
    {
        return $this->ID_employee;
    }
    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'Login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }

    public function isAdmin(): bool
    {
        return $this->Login === 'admin';
    }

    public function getFullNameAttribute(): string
    {
        return $this->Login ?? '';
    }

}