<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
    ];

    // une personne peut avoir plusieurs enfants
    public function children()
    {
        return $this->belongsToMany(People::class, 'relationships', 'parent_id', 'child_id');
    }

    // une personne peut avoir plusieurs parents
    public function parents()
    {
        return $this->belongsToMany(People::class, 'relationships', 'child_id', 'parent_id');
    }

    // une personne a un utilisateur createur
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
