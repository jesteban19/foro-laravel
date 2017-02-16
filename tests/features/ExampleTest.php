<?php

class ExampleTest extends FeatureTestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */
    function test_basic_example()
    {
      $user = factory(\App\User::class)->create([
        'name' => 'Joseph Esteban',
        'email' => 'esteban.programador@gmail.com'
      ]);

      $this->actingAs($user, 'api');
      $this->visit('api/user')
       ->see('Joseph Esteban esteban.programador@gmail.com');
    }
}
