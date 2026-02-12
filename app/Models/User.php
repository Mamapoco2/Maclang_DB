<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens; // 🔥 Sanctum
use Spatie\Permission\Traits\HasRoles; // 🔥 Spatie

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'employee_id',
        'department_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔹 Relationship to Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // 🔹 Relationship to Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
