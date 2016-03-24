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
     * with custom orderby for base
     * before cumulative total and
     * addition before multiplier
     * 
     * 
     * @return object
     */
    public function modifiers()
    {
        return $this->hasMany('Smarch\Amazo\Models\AmazoMods', 'parent_id')->orderByRaw( \DB::raw("cumulative, FIELD(mod_type, '+', '*')") );
    }


    /**
     * Starting with the resource's decided damage
     * determines modifier(s)dammage.
     *
     * Returns early if no modifiers are found
     * 
     * @param integer $damage [description]
     *
     * @return object
     */
    public function addModifierDamage($damage = 0)
    {
        $mods = $this->modifiers;
        if (count($mods) <= 0) {
            return;
        }

        $object = new \stdClass();
        $object->startingDamage = (float) $damage;
        $object->modifiersDamage = 0;
        $object->modifiersDamageMath = '';

        foreach($mods as $item) {
            $damageToModify = ($item->cumulative) ? ($object->startingDamage + $object->modifiersDamage) : $object->startingDamage;
            $modifierDamage = $this->doModMath($damageToModify, $item->amount, $item->mod_type);
            $mathText = ($item->mod_type == "+") ? $item->mod_type." ".$item->amount : $damageToModify. " ".$item->mod_type." ".$item->amount;

            $props[] = (object) [ 
                'message' => $item->damageType->name . " generated " . $modifierDamage . " damage (".$mathText.")",
                'parentName' => $this->getName(),
                'name' => $item->damageType->name,
                'modifierAmount' => (float) $item->amount,
                'damage' => $modifierDamage,
                'cumulative' => $item->cumulative,
                'cumulativeAsString' => $item->CumulativeString,
                'operator' =>  $item->mod_type,
                'bcOperator' =>  ($item->mod_type === "+") ? "bcadd" : "bcmul" ,
            ];

            $object->modifiersDamage += $modifierDamage;
            $object->modifiersDamageMath .= "$modifierDamage + ";
        }

        $object->modifiersDamageMath = substr($object->modifiersDamageMath,0,-3);
        $object->totalDamage = ($object->startingDamage + $object->modifiersDamage);
        $object->totalDamageMath = "$object->startingDamage + ($object->modifiersDamageMath)";
        $object->modifiers = (object) $props;

        return $object;
    }


    /**
     * Do the math (+ or *) for each modifier
     * @param  integer $damage   damage to modify
     * @param  integer $amount   modifier amount
     * @param  string  $operator "+" or "*"
     * @return float
     */
    protected function doModMath($damage=1, $amount=1, $operator="+")
    {
        return (float) ($operator == "+") ? $amount : ($damage * $amount) ;
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
