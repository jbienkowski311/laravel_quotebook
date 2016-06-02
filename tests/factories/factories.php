<?php
/**
 * Created by PhpStorm.
 * User: Jakub
 * Date: 2016-06-02
 * Time: 19:09
 */

$factory('App\User', [
    'name' => $faker->name,
    'password' => bcrypt('password'),
    'email' => $faker->email,
    'api_token' => $faker->shuffleString(str_random(60))
]);

$factory('App\Author', [
    'name' => $faker->name,
    'country' => $faker->country,
    'date_of_birth' => $faker->dateTimeBetween('-70 years', '-16 years')
]);

$factory('App\Quote', [
    'text' => $faker->sentence(20),
    'author_id' => 0
]);