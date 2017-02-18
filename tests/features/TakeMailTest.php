<?php

use App\Mail\TokenMail;
use App\Token;
use App\User;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class TakeMailTest extends FeatureTestCase
{
    /**
     * @test
     */
    function it_sends_a_link_with_the_token()
    {
        $user = new User([
           'first_name' => 'Joseph',
            'last_name' => 'Esteban',
            'email' => 'esteban.programador@gmail.com'
        ]);
        $token = new Token([
           'token' => 'this-is-a-token',
            'user' => $user,
        ]);

        // SMTP -> Mailtrap -- mala idea
        // API Mailtrap -> data  --mala idea no debe depender de ningun tercero

        $this->open(new TokenMail($token))
            ->seeLink($token->url, $token->url);
    }


    protected function open(\Illuminate\Mail\Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();

        Mail::send($mailable);
        $message =$transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());
        return $this;
    }
}
