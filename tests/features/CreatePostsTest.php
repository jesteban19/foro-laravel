<?php

use App\Post;

class CreatePostsTest extends FeatureTestCase
{
    public function test_a_user_create_a_post()
    {
        // Having - teniendo
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';
        $this->actingAs($user = $this->defaultUser());

        //When -cuando
        $this->visit(route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');
        //Then - entonces
        $this->seeInDatabase('posts',[
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id,
        ]);

        $post = Post::first();
        $this->seeInDatabase('subscriptions',[
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        //Deberiamos ver el resultado del titulo
        //$this->seeInElement('h1',$title);
        $this->seePageIs($post->url);
    }

    public function test_creating_a_post_requires_authentication()
    {
        //When -cuando
        $this->visit(route('posts.create'))
            ->seePageIs(route('token'));
    }

    public function test_create_post_form_validation()
    {
        $this->actingAs($this->defaultUser())
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio'
            ]);
    }
}