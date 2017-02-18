<?php

class ShowPostTest extends FeatureTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_see_the_post_details()
    {
        //Having
        $user = $this->defaultUser([
            'first_name' => 'Joseph',
            'last_name' => 'Esteban'
        ]);

        $post = $this->createPost([
           'title' => 'Como instalar Laravel',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id
        ]);

        $user->posts()->save($post);
        //When
        $this->visit($post->url)
            ->seeInElement('h1',$post->title)
            ->see($post->content)
            ->see($post->name);

    }

    function test_old_urls_are_redirected()
    {

        $post = $this->createPost([
            'title' => 'Old title',
        ]);

        $url = $post->url;

        $post->update(['title' => 'New Title']);

        $this->visit($url)
            ->seePageIs($post->url);
    }

    /*function test_post_url_with_wrong_slugs_still_work()
    {
        $user = $this->defaultUser();

        $post = factory(\App\Post::class)->make([
            'title' => 'Old title',
        ]);
        $user->posts()->save($post);

        $url = $post->url;

        $post->update(['title' => 'New Title']);

        $this->get($url)
            ->assertResponseStatus(404);

    }*/



}
