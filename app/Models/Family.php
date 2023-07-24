<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'father_id',
    ];

    protected $hidden = [
        'id',
        'father_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function children()
    {
        return $this->hasMany(Family::class, 'father_id', 'id');
    }
}
