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

    public function addModifierDamage($damage = 0)
    {
        $mods = $this->modifiers->sortBy('cumulative');

        if (count($mods) <= 0) {
            return;
        }

        $object = new \stdClass();
        $object->startingDamage = $damage;
        $object->allModifierDamage = 0;

        foreach($mods as $item) {
            $damageToModify = ($item->cumulative) ? ($object->startingDamage + $object->allModifierDamage) : $object->startingDamage;
            $modifierDamage = $this->doModMath($damageToModify, $item->amount, $item->mod_type);
            $mathText = ($item->mod_type == "+") ? $item->mod_type." ".$item->amount : $damageToModify. " ".$item->mod_type." ".$item->amount;

            $props[] = (object) [ 
                'message' => $item->damageType->name . " generated " . $modifierDamage . " damage (".$mathText.")",
                'parentName' => $this->getName(),
                'modifierName' => $item->damageType->name,
                'modifierAmount' => $item->amount,
                'modifierDamage' => $modifierDamage,
                'modifierCumulative' => $item->cumulative,
                'modifierCumulativeAsString' => $item->CumulativeString,
                'operator' =>  $item->mod_type
            ];

            $object->allModifierDamage += $modifierDamage;
        }

        $object->totalDamage = ($object->startingDamage + $object->allModifierDamage);
        $object->modifiers = (object) $props;

        return $object;
    }

    protected function doModMath($damage=1, $amount=1, $operator="+")
    {
        return ($operator == "+") ? $amount : ($damage * $amount) ;
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
