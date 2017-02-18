<?php

use App\Comment;
use App\Notifications\PostCommented;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{
    use DatabaseTransactions;
    /**
     *@test
     */
    function it_builds_a_mail_message()
    {
        $post = new Post([
            'title' => 'Titulo del post',
        ]);
        $author = new User([
            'first_name' => 'Joseph',
            'last_name' => 'Esteban',
        ]);

        $comment = new Comment;
        $comment->post = $post;
        $comment->user = $author;

        $notification = new PostCommented($comment);

        $subscriber = new User();

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            'Nuevo comentario en: Titulo del post',
            $message->subject
        );

        $this->assertSame(
            'Joseph Esteban escribio un comentario en: Titulo del post',
            $message->introLines[0]
        );

        $this->assertSame($post->url,$message->actionUrl);
    }
}
