<?php

use App\Post;

class PostsListTest extends FeatureTestCase
{

    public function test_a_user_can_see_the_posts_list_and_go_to_the_details()
    {
        $post = $this->createPost([
            'title' => '¿Debo usar laravel 5.3 o 5.1 LTS?'
        ]);

        $this->visit('/')
            ->seeInElement('h1','Posts')
            ->see($post->title)
            ->click($post->title)
            ->seePageIs($post->url);
    }

    function test_the_posts_are_paginate()
    {
        $first = factory(\App\Post::class)->create([
            'title' => 'Post mas antiguo'
        ]);
        factory(Post::class)->times(15)->create();

        $last = factory(Post::class)->create([
            'title' => 'Post mas reciente'
        ]);

        $this->visit('/')
            ->see($last->title)
            ->dontSee($first->title)
            ->click('2')
            ->see($first->title)
            ->dontSee($last->title);
    }
}
