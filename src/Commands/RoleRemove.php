<?php

namespace Naviisml\Laravel\Roles\Commands;

use Illuminate\Console\Command;
use Naviisml\Laravel\Roles\Models\UserRole;
use Naviisml\Laravel\Roles\Models\Role;
use App\Models\User;

class RoleRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:unassign {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a role from a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // check if the user class exists
        if (!class_exists('\App\Models\User')) {
            $this->error("Class [App\Models\User] doesn't exist");
            return Command::FAILURE;
        }

        // check if the command has a user_id parameter
        if ($user_id = $this->argument('user_id')) {
		    $user = $this->searchUser($user_id);
        }

        if (!isset($user) || !$user) {
            while (!($user = $this->askUser())) {}
        }

        // retrieve the roles
		$roles = $this->getRoles($user);

        if (!$roles) {
			$this->error('User doesn\'t own any roles');
			$this->newLine();

            // loop back to the user
		    $user = $this->askUser();
        }

        // select the role to remove
		$role = $this->choice('Choose the role', $roles);

		// Assign role
		if ($this->confirm("Do you want to remove [{$role}] from [{$user->username}]?", true)) {
            $role = UserRole::where('role', $role)->first();

            if (!$role) {
			    $this->error("User doesn't own {$role}");
            }

            $role->delete();
		}

        return Command::SUCCESS;
    }

    /**
     * Ask the 'Search for a user' question
     *
     * @return  App\Models\User
     */
	protected function askUser()
	{
        $input = $this->ask('Search user by email, username or id');

        if ($user = $this->searchUser($input)) {
            return $user;
        }
	}

    /**
     * Search for a user by email, username or id
     *
     * @return  App\Models\User
     */
	protected function searchUser($input = null)
	{
        $user = User::where('email', 'like', "%{$input}%")->orWhere('id', 'like', "%{$input}%")->orWhere('username', 'like', "%{$input}%")->first();

		if (!$user) {
            $this->error("Could not find any user by {$input}.");
            $this->newLine();

            return false;
        }

        if ($this->confirm("Do you mean {$user->username}?", true)) {
            return $user;
        }

		return false;
	}

	/**
	 * Parse the roles correctly
	 *
	 * @return  array
	 */
	protected function getRoles($user)
	{
		$roles = $user->roles()->get();
		$role_list = [];

        if (!is_array($roles)) {
            foreach ($roles as $role) {
                $role_list[] = $role->role;
            }
        }

		return $role_list;
	}
}
