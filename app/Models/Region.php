<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function communes(){
        return $this->hasMany(Commune::class, 'id');
    }

    public function customers(){
        return $this->hasMany(Customer::class, 'id_reg', 'dni');
    }
}
