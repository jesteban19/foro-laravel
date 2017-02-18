<?php
use App\Notifications\PostCommented;
use App\User;
use Illuminate\Support\Facades\Notification;

class NotifyUsersTest extends FeatureTestCase
{

    /**
     *
     */
    public function test_the_subscribers_receive_a_notification_when_post_is_commended()
    {

        Notification::fake();
        $post = $this->createPost();

        $subscriber = factory(User::class)->create();

        $subscriber->subscribeTo($post);

        $writer = factory(User::class)->create();

        $writer->subscribeTo($post);

        $comment = $writer->comment($post, 'Un Comentario cualquiera');

        Notification::assertSentTo(
            $subscriber, PostCommented::class, function($notification) use ($comment){
            return $notification->comment->id == $comment->id;
        });

        //El autor del comen
        Notification::assertNotSentTo($writer, PostCommented::class);
    }
}
