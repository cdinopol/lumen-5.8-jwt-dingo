<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$admin_users = [
    		[
	    		'name' => 'admin',
	    		'email' => 'admin@admin.com',
	    		'password' => app('hash')->make('password'),
	    		'role' => 99
	    	]
    	];

    	foreach ($admin_users as $admin_user) {
    		User::create($admin_user);
    	}
    }
}
