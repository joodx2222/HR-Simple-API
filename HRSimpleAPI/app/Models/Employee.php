<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    public function manager(){
        return $this->belongsTo(Employee::class, 'managerId', 'id');
    }

    public function subWorkers(){
        return $this->hasMany(Employee::class, 'managerId','id');
    }

    protected $hidden = [
        'id',
        'deleted_at',
        'updated_at',
        'created_at',
    ];
}
