<?php


use App\Mail\TokenMail;
use App\Token;
use Illuminate\Support\Facades\Mail;

class RequestTokenTest extends FeatureTestCase
{
    function test_a_guest_user_can_request_a_token()
    {
        //havbing
        Mail::fake();
        $user = $this->defaultUser(['email' => 'admin@manchay.com']);

        //when
        $this->visitRoute('token')
            ->type('admin@manchay.com','email')
            ->press('Solicitar token');

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token,'A Token was not generated');

        Mail::assertSentTo($user, TokenMail::class, function($mail) use($token){
           return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();
        $this->seeRouteIs('login_confirmation')
            ->see('Enviamos a tu email un enlace para que inicies sesión');
    }
    function test_a_guest_user_can_request_a_token_without_email()
    {
        //havbing
        Mail::fake();
        //when
        $this->visitRoute('token')
            ->press('Solicitar token');

        $token = Token::first();

        $this->assertNull($token,'A Token was generated');

        Mail::assertNotSent(TokenMail::class);

        $this->dontSeeIsAuthenticated();
        $this->seeErrors([
            'email' => 'El campo correo electrónico es obligatorio.',
        ]);
    }

    function test_a_guest_user_can_reqest_a_token_an_invalid_email()
    {
        //havbing
        Mail::fake();
        //when
        $this->visitRoute('token')
            ->type('Silence','email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'correo electrónico no es un correo válido',
        ]);
    }

    function test_guest_user_cant_request_a_token_with_a_non_exists_email()
    {
        //havbing
        //Mail::fake();
        $user = $this->defaultUser(['email' => 'admin@manchay.com']);

        //when
        $this->visitRoute('token')
            ->type('Silence@hotmail.com','email')
            ->press('Solicitar token');

        $this->seeErrors([
            'email' => 'correo electrónico es inválido.',
        ]);
    }
}
