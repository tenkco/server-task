<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;
use Tenkco\Auth\IdentityInterface;

class Employee extends Model implements IdentityInterface
{
    public $timestamps = false;
    protected $table = 'employees';
    protected $primaryKey = 'ID_employee';

    protected $fillable = [
        'login',
        'password',
        'api_token'
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->password = md5($employee->password);
        });
    }

    public function findIdentity(int $id)
    {
        return self::select('*')->where('ID_employee', $id)->first();
    }

    public function getId(): int
    {
        return $this->ID_employee;
    }

    public function attemptIdentity(array $credentials)
    {
        return self::select('*')->where([
            'login' => $credentials['login'],
            'password' => md5($credentials['password'])
        ])->first();
    }

    public function isAdmin(): bool
    {
        return \Illuminate\Database\Capsule\Manager::table('employee_role')
            ->where('ID_employee', $this->ID_employee)
            ->where('ID_role_name', 1)
            ->exists();
    }
    public function getFullNameAttribute(): string
    {
        return $this->login ?? '';
    }
}