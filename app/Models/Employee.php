<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'department',
        'designation',
        'email',
        'phone',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (empty($employee->employee_id) || $employee->employee_id === '[Auto-generated]') {
                $latestEmployee = Employee::where('employee_id', 'like', 'EMP-%')
                    ->latest('id')
                    ->value('employee_id');

                $nextNumber = 1;
                if ($latestEmployee) {
                    preg_match('/\d+$/', $latestEmployee, $matches);
                    if (!empty($matches)) {
                        $lastNumber = (int) $matches[0];
                        $nextNumber = $lastNumber + 1;
                    }
                }

                $employee->employee_id = 'EMP-' . str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
