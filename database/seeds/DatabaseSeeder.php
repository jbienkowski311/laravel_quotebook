<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use Laracasts\TestDummy\Factory as TestDummy;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create users
        TestDummy::times(24)->create('App\User');
        TestDummy::create('App\User', [
            'email' => 'test@test.com',
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'api_token' => str_random(60)
        ]);

        // create authors
        TestDummy::times(50)->create('App\Author');

        // create quote and relate it to some author
        for($i=0; $i<400; $i++){
            $author_id = App\Author::find($i%10+1)->id;
            TestDummy::create('App\Quote', ['author_id' => $author_id]);
        }
    }
}
