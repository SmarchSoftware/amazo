<?php

namespace Smarch\Amazo\Models;

use Illuminate\Database\Eloquent\Model;

use Smarch\Amazo\Models\Amazo;

class AmazoMods extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amazo_mods';

    /**
     * Get the mods for the damage type
     * 
     * @return object
     */
    public function damageType()
    {
        return $this->belongsTo('Smarch\Amazo\Models\Amazo','damage_type_id');
    }
}
