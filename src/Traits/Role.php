<?php

namespace Navel\LaravelRoles\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Navel\LaravelRoles\Models\UserRole;

trait Role
{
    /**
     * @var array
     */
    protected $roles;

    /**
     * @var array
     */
    protected $permissions;

    /**
     * Retrieve the roles
     *
     * @return  array
     */
    public function getRoles()
    {
        if (!$this->roles) {
		    $this->roles = $this->roles()->get()->toArray();

            usort($this->roles, function($a, $b) {
                return $a['order'] <=> $b['order'];
            });
        }

		return $this->roles;
    }

    /**
     * Retrieve and parse the permissions
     *
     * @return  array
     */
	public function getPermissions()
	{
        if (!$this->permissions) {
            $roles = $this->getRoles();

            foreach ($roles as $role) {
                if (isset($role['data']) && is_array($role['data']['permissions'])) {
                    $this->permissions = array_merge($this->permissions ?? [], array_filter($role['data']['permissions'], function($v, $k) {
                        return $v !== "undefined";
                    }, ARRAY_FILTER_USE_BOTH));
                }
            }
        }

		return $this->permissions;
	}

	/**
	 * Check if the user has a specific permission
	 *
	 * @param   string  $permission
	 *
	 * @return  boolean
	 */
	public function hasPermission($permission)
	{
        $permissions = $this->getPermissions();

		if (is_array($permission)) {
			$this->hasPermissions($permission);
		}

		if (!isset($permissions[$permission]) || $permissions[$permission] == false) {
			return false;
		}

		return true;
	}

	/**
	 * Loop through the array of permissions, and check if the user has all of them
	 *
	 * @param   array  $permissions
	 *
	 * @return  boolean
	 */
	public function hasPermissions($permissions)
	{
		if (is_array($permissions)) {
			foreach ($permissions as $permission)  {
				if ($this->hasPermission($permission) == false) {
					return false;
				}
			}

			return true;
		}

		return $this->hasPermission($permission);
	}

    /**
     * Get the users' roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
	public function roles()
	{
		return $this->hasMany(UserRole::class, 'user_id', 'id');
	}

    /**
     * Retrieve the roles & permissions before executing certain functions
     *
     * @param   function  $method
     * @param   array     $parameters
     *
     * @return  null
     */
    public function callMagic($method, $parameters)
    {
        if (Str::startsWith($method, 'has')) {
            $this->roles = $this->getRoles();
            $this->permissions = $this->getPermissions();
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Catch the function calls
     *
     * @param   function  $method
     * @param   array     $parameters
     *
     * @return  null
     */
    public function __call($method, $parameters)
    {
        return $this->callMagic($method, $parameters);
    }
}
