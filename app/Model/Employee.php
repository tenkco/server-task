<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Auth\IdentityInterface;

class Employee extends Model implements IdentityInterface
{
    use HasFactory;

    protected $table = 'employees';
    public $timestamps = false;

    protected $fillable = ['login', 'password'];

    // Хешируем пароль при создании
    protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->password = md5($employee->password);
        });
    }

    // Связь: один сотрудник — много записей в employee_roles
    public function employeeRoles()
    {
        return $this->hasMany(EmployeeRole::class);
    }

    // Получить роль текущего сотрудника (первую)
    public function getFirstRole()
    {
        return $this->employeeRoles()->with('role')->first();
    }

    // Проверить — администратор ли
    public function isAdmin(): bool
    {
        $er = $this->getFirstRole();
        return $er && $er->role_id === 1;
    }

    // IdentityInterface — найти по id
    public function findIdentity(int $id)
    {
        return self::find($id);
    }

    // IdentityInterface — вернуть id
    public function getId(): int
    {
        return $this->id;
    }

    // IdentityInterface — аутентификация по логину и паролю
    public function attemptIdentity(array $credentials)
    {
        return self::where([
            'login'    => $credentials['login'],
            'password' => md5($credentials['password']),
        ])->first();
    }
}