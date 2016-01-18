<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amazo extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amazos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'notes', 'enabled'];

}
