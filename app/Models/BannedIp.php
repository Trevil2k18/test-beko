<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BannedIp
 * @package App\Models
 *
 * @method static Builder|BannedIp ipInt(int $ip)
 *
 * @property string $ip_string
 * @property int $ip_int
 * @property int $auth_tries
 */
class BannedIp extends Model
{
    protected $table = 'banned_ips';

    protected $fillable = [
        'ip_string',
        'ip_int',
        'auth_tries'
    ];

    /**
     * @param Builder $query
     * @param int $ip
     */
    public function scopeIpInt(Builder $query, int $ip)
    {
        $query->where(['ip_int' => $ip]);
    }

    /**
     * @return bool
     */
    public function isBanned(): bool
    {
        return $this->getAttribute('auth_tries') >= 5;
    }

    /**
     * @return $this
     */
    public function incrementTries()
    {
        $this->setAttribute('auth_tries', $this->getAttribute('auth_tries') + 1);
        $this->save();

        return $this;
    }

    /**
     * @return $this
     */
    public function dropTriesCounter()
    {
        $this->setAttribute('auth_tries', 0);
        $this->save();

        return $this;
    }
}
