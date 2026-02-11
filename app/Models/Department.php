<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'division_id',
        'name',
        'description'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
