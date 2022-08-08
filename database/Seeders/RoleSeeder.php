<?php

namespace Naviisml\Roles\Database\Seeders;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Seeder;
use Naviisml\Roles\Models\Role;

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
		$roles = config('roles.roles');

		foreach ($roles as $key => $role) {
			$name = $role['name'];
			$tag = $role['tag'];
			$permissions = $role['permissions'] ?? [];
			$default = ($role['default'] ?? false);

			$this->createRole($name, $tag, $permissions, ($override = $key + 1), $default);
		}
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
