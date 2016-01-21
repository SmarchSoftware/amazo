<?php

namespace Smarch\Amazo\Traits;

trait SmarchACLTrait {

	/**
	 * Will check user access depending on the driver being used.
	 * Defaults to using laravel Auth Guard driver
	 * 
	 * @param  [string] $permission
	 * @return [boolean]
	 */
	protected function checkAccess($permission) {
		if ( $this->acl === false )
			return true;
			
		$driver = "acl" . ucfirst( $this->driver );

		return $this->$driver($permission);
	}


	/**
	 * Using Laravel Authorization Driver
	 * 
	 * @param  string $permission
	 * @package Laravel\Gate
	 * @return boolean
	 */
	protected function aclLaravel($permission) {
		return \Auth::user()->can($permission);
	}


	/**
	 * Using Shinobi Authorization Driver
	 * 
	 * @param  string $permission
	 * @package Caffeinated\Shinobi
	 * @return boolean
	 */
	protected function aclShinobi($permission) {
		return \Shinobi::can($permission);
	}


	/**
	 * Using Sentinel Authorization Driver
	 * 
	 * @param  string $permission
	 * @package Cartalyst\Sentinel
	 * @return boolean
	 */
	protected function aclSentinel($permission) {
		return \Sentinel::hasAccess($permission);
	}


	/**
	 * Using Entrust Authorization Driver
	 * 
	 * @param  string $permission
	 * @package Zizaco\Entrust
	 * @return boolean
	 */
	protected function aclEntrust($permission) {
		return \Entrust::can($permission);
	}
}