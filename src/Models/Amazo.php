<?php

namespace Smarch\Amazo\Models;

use Illuminate\Database\Eloquent\Model;

class Amazo extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'damage_types';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'notes', 'enabled'];

}
