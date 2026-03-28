<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function projects()
    {
        // Uma empresa tem muitos projetos
        return $this->hasMany(Project::class);
    }
}
