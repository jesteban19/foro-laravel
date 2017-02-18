<?php

use App\Comment;
use App\Policies\CommentPolicy;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentPolicityTest extends TestCase
{
    use DatabaseTransactions;
    public function test_the_posts_author_can_select_an_answer()
    {
        $comment = factory(Comment::class)->create();

        $policy = new CommentPolicy;

        $this->assertTrue(
            $policy->accept($comment->post->user, $comment)
        );

    }

    public function test_non_authors_can_a_select_an_answer()
    {
        $comment = factory(Comment::class)->create();

        $policy = new CommentPolicy;

        $this->assertFalse(
            $policy->accept(factory(User::class)->create(), $comment)
        );

    }
}
