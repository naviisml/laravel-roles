# Laravel Roles

...

## Installation

```composer
composer install naviisml/laravel-roles
```

## Usage

**Add a role to a user**

```
php artisan role:assign <optional:user_id>
```

In `config/roles.php`

```
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Role
    |--------------------------------------------------------------------------
    |
    | ...
    |
    */

	'default' => [
		'name' => 'User',
		'tag' => '@default'
	]
];
```

**Remove a role from a user**

```
php artisan role:unassign <optional:user_id>
```

## Commands

**Provider**

In `config/app.php` add

```php
    'providers' => [
        // ...
        
        /*
         * Package Service Providers...
         */
        Naviisml\Laravel\Roles\ServiceProvider::class,
    ],
```

**Assets**

_Publish the migrations_

```cmd
php artisan vendor:publish --tag=laravel-roles-migrations --force
```

_Publish the seeders_

```cmd
php artisan vendor:publish --tag=laravel-roles-seeders --force
```

_Publish the resources_

```cmd
php artisan vendor:publish --tag=laravel-roles-resources --force
```

**Database**

_Execute the migrations_

```cmd
php artisan migrate
```

_Seed the database with the default `@default`, `@admin` and `@banned` roles_

```cmd
php artisan db:seed --class=\Naviisml\Laravel\Roles\Database\Seeders\RoleSeeder
```

## Development

**Import**

```json
"repositories": [
	# ...
	{
		"type": "path",
		"url": "creator/naveldev/laravel-roles",
		"symlink": true
	}
],
```

**Require**

```json
	"require": {
		# ...
		"naveldev/laravel-roles": "^1.0.0"
	}
```

