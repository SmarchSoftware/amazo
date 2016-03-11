<?php

namespace Smarch\Amazo\Models;

use Illuminate\Database\Eloquent\Model;

use Smarch\Amazo\Models\AmazoMods;

class Amazo extends Model
{
    /**
     * Constants
     */
    const ATTR_NAME = 'name';
    const ATTR_SLUG = 'slug';
    const ATTR_NOTES = 'notes';
    const ATTR_ENABLED = 'enabled';

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
    protected $fillable = [
        self::ATTR_NAME,
        self::ATTR_SLUG,
        self::ATTR_NOTES,
        self::ATTR_ENABLED
    ];


    /**
     * Get the mods for the damage type
     * 
     * @return object
     */
    public function modifiers()
    {
        return $this->hasMany('Smarch\Amazo\Models\AmazoMods', 'parent_id');
    }


    /**
     * Get Damage Type Name
     * @return string
     */
    public function getName()
    {
        return $this->{self::ATTR_NAME};
    }

    
    /**
     * Get Damage Type Slug
     * @return string
     */
    public function getSlug()
    {
        return $this->{self::ATTR_SLUG};
    }

}
