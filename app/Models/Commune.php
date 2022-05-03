<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    public function regions(){
        return $this->belongTo(Region::class, 'id');
    }

    public function customers(){
        return $this->hasMany(Customer::class, 'id_com', 'dni');
    }
}
