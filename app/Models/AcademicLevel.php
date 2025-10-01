<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicLevel extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'duration_years',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(ClassModel::class);
    }
    // use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'code',
    //     'description',
    //     'duration_years',
    //     'is_active'
    // ];

    // protected $casts = [
    //     'is_active' => 'boolean',
    // ];

    // // Relations
    // public function classes()
    // {
    //     return $this->hasMany(ClassModel::class);
    // }
}
