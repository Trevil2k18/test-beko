<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models
 *
 * @method static Builder|User login(string $email, string $hash)
 *
 * @property string $email
 * @property string $password
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @param Builder $query
     * @param string  $email
     * @param string  $hash
     */
    public function scopeLogin(Builder $query, string $email, string $hash)
    {
        $query->where([
            'email' => $email,
            'password' => $hash
        ]);
    }
}
