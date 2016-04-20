<?php

namespace Smarch\Amazo\Seeds;

use Illuminate\Database\Seeder;

use DB;

use Smarch\Amazo\Models\Amazo;

class AmazoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$table = with(new Amazo)->getTable();

        // add resources to insert here
        $resources = [
        	[
        		'name' => 'Standard',
				'slug' => 'base',
				'notes'=> 'The starting point of all damage types',
				'enabled'=> 1
	        ],
        	[
        		'name' => 'Critical',
				'slug' => 'crit',
				'notes'=> 'Is normally worth extra damage. Maybe add a modifier to this one.',
				'enabled'=> 1
	        ],
        	[
        		'name' => 'Brutal',
				'slug' => 'brutal',
				'notes'=> 'Oh! Brutal damage!',
				'enabled'=> 1
	        ],
        	[
        		'name' => 'Frost',
				'slug' => 'light.cold',
				'notes'=> 'Not enabled. For a bit of extra damage over base damage.',
				'enabled'=> 0
	        ]
        ];
        
        // insert resources
        DB::table($table)->insert($resources);
    }
}
