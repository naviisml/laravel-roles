<?php

namespace Naviisml\Laravel\Roles\Database\Seeders;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Seeder;
use Naviisml\Laravel\Roles\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultRoles();
    }

	/**
     * Create the default roles
     */
	protected function createDefaultRoles()
	{
		// The default role
		$this->createRole(config('roles.default.name'), config('roles.default.tag'), [
			'interact' => true,
			'user.user-logs' => true,
			'user.edit-profile' => true,
			'user.edit-password' => true
		], 1, true);

		// The admin role
		$this->createRole('Admin', '@admin', [
			'admin' => true,
			'admin.users' => true,
			'admin.user.get' => true,
			'admin.user.edit' => true,
			'admin.user.roles' => true,
			'admin.user.roles.assign' => true,
			'admin.user.roles.delete' => true,
			'admin.user.logs' => true,
			'admin.roles' => true,
			'admin.role.edit' => true,
		], 100);

		// The banned role
		$this->createRole('Banned', '@banned', [
			'interact' => false
		], 1000);
	}

	/**
     * Create a new role
     */
	protected function createRole($name, $tag, array $permissions, $override = 50, $default = false)
	{
		$role = Role::create([
			'tag' => $this->parseRoleTag($tag),
			'displayname' => $name,
			'permissions' => $permissions,
			'override' => $override,
			'default' => $default,
		]);

		return $role;
	}

    /**
     * Parse a role tag
     */
	protected function parseRoleTag($name)
	{
		$name = trim($name, '@');
		$name = strtolower($name);

		$validator = $this->validator(['name' => $name]);
		if ($validator->fails()) {
			throw new \Exception($validator);
		}

		return "@${name}";
	}

    /**
     * Get a validator for an data object.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
        ]);
    }
}
