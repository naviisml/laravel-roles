# Laravel Roles

...

## Installation

```composer
composer install naveldev/laravel-roles
```

```cmd
php artisan vendor:publish --tag=laravel-roles-resources --force
```

## FAQ

**Provider**

In `config/app.php`

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

```cmd
php artisan vendor:publish --tag=laravel-roles-migrations --force
```

```cmd
php artisan vendor:publish --tag=laravel-roles-seeders --force
```

```cmd
php artisan vendor:publish --tag=laravel-roles-resources --force
```

**Database**

```cmd
php artisan migrate
```

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
