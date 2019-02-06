<?php

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Class UsersSeeder
 */
class UsersSeeder extends Seeder
{
    /**
     * @var int
     */
    protected $limit = 0;

    /**
     * @var array
     */
    protected $users = [
        [
            'email'    => 'test@email.com',
            'password' => 'd3125f4c27f4342fb8f05f38c625cf7e', //md5 from everestmx@gmail.com
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $user) {
            User::create($user);
        }
    }
}
