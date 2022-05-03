<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey='dni';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing=false;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType='string';

    protected $fillable = ['id_reg', 'id_com', 'email', 'name','last_name', 'address', 'date_reg', 'status'];

    public function regions(){
        return $this->belongTo(Region::class, 'id');
    }

    public function communes(){
        return $this->belongTo(Commune::class, 'id');
    }
}
