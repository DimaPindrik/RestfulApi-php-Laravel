<?php 

namespace App\Traits;

trait AdminActions 
{
	/**
     * If this method returns true, laravel will allow the access to the action protected by this policy, independently by those methods
     * if it will return false, it will automaticly deny access for this specific actions
     */
    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
}