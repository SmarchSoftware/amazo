<?php

namespace Smarch\Amazo\Models;

use Illuminate\Database\Eloquent\Model;

use Smarch\Amazo\Models\Amazo;

class AmazoMods extends Model
{
    /**
     * Constants
     */
    const ATTR_AMOUNT = 'amount';
    const ATTR_MOD_TYPE = 'mod_type';
    const ATTR_DAMAGE_TYPE_ID = 'damage_type_id';
    const ATTR_PARENT_ID = 'parent_id';
    const ATTR_CUMULATIVE = 'cumulative';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amazo_mods';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::ATTR_AMOUNT,
        self::ATTR_MOD_TYPE,
        self::ATTR_DAMAGE_TYPE_ID,
        self::ATTR_PARENT_ID,
        self::ATTR_CUMULATIVE
    ];

    /**
     * Type cast booleans from db
     * @var [type]
     */
    protected $casts = [
        self::ATTR_CUMULATIVE => 'boolean',
    ];


    /**
     * Get the mods for the damage type
     * 
     * @return object
     */
    public function damageType()
    {
        return $this->belongsTo('Smarch\Amazo\Models\Amazo','damage_type_id');
    }


    /**
     * Set the cumulative text.
     *
     * @param  string  $value
     * @return string
     */
    public function getCumulativeStringAttribute($value)
    {
        return ( $this->{self::ATTR_CUMULATIVE} ) ? 'Total' : 'Base';
    }
}
