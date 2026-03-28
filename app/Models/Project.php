<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function company()
    {
        // Um projeto pertence a uma empresa
        return $this->belongsTo(Company::class);
    }
}
