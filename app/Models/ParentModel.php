<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentModel extends Model
{
    //

    use CrudTrait;
    use HasFactory;

    protected $table = 'parents';

    protected $fillable = [
        'first_name',
        'last_name',
        'relationship',
        'phone',
        'phone_2',
        'email',
        'profession',
        'address',
        'is_emergency_contact'
    ];

    protected $casts = [
        'is_emergency_contact' => 'boolean',
    ];

    // Relations
    public function students()
    {
        return $this->belongsToMany(\App\Models\Student::class, 'student_parent', 'parent_id', 'student_id')
            ->withPivot('is_primary_contact')
            ->withTimestamps();
    }

    // Accesseurs
    // public function getFullNameAttribute()
    // {
    //     return $this->first_name . ' ' . $this->last_name;
    // }
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

}
