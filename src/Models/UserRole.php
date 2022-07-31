<?php

namespace Navel\LaravelRoles\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
		'id',
	];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'role',
    ];

	/**
	 * The accessors to append to the model's array.
	 *
	 * @var array
	 */
	protected $appends = [
		'data',
		'order',
	];

    /**
     * Return the accociated roles
     *
     * @return UserRole
     */
    public function getDataAttribute()
    {
        return $this->role()->first();
    }

	/**
     * Return the `order` value for the role
     *
     * @return UserRole
     */
	public function getOrderAttribute()
	{
        return $this->getDataAttribute() != null ? $this->getDataAttribute()->override : 0;
	}

    /**
     * Get the accociated role
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'tag', 'role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
