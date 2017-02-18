<?php

use App\User;

class SuscribeToPostsTest extends FeatureTestCase
{

    public function test_a_user_can_suscribe_to_a_post()
    {
        $post = $this->createPost();

        $user = factory(User::class)->create();

        $this->actingAs($user);

        //when
        $this->visit($post->url)
            ->press('Suscribirse al post');

        //then
        $this->seeInDatabase('subscriptions',[
           'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url)
            ->dontSee('Suscribirse al post');
    }
    function test_a_user_can_unsubscribe_from_a_post()
    {
        $post = $this->createPost();

        $user = factory(User::class)->create();
        $user->subscribeTo($post);
        $this->actingAs($user);

        $this->visit($post->url)
            ->dontSee('Suscribirse al post')
            ->press('Desuscribirse del post');

        $this->dontSeeInDatabase('subscriptions',[
           'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url)
            ->See('Suscribirse al post');
    }
}
