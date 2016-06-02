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
        TestDummy::times(50)->create('App\User');

        // create authors
        TestDummy::times(10)->create('App\Author');

        // create quote and relate it to some author
        for($i=0; $i<100; $i++) {
            $author_id = App\Author::find($i%10+1)->id;
            TestDummy::create('App\Quote', ['author_id' => $author_id]);
        }
    }
}
