<?php


use App\Token;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TokenMail;

class RegistrationTest extends FeatureTestCase
{
  function test_a_user_can_create_an_account()
  {
      Mail::fake();
      $this->visitRoute('register')
          ->type('admin@styde.net','email')
          ->type('silence', 'username')
          ->type('Joseph','first_name')
          ->type('Esteban','last_name')
          ->press('Registrate');

      $this->seeInDatabase('users',[
         'email' => 'admin@styde.net',
         'username' => 'silence',
          'first_name' => 'Joseph',
          'last_name' => 'Esteban',
      ]);

      $user = User::first();

      $this->seeInDatabase('tokens',[
          'user_id' => $user->id
      ]);

      $token = Token::where('user_id', $user->id)->first();

      $this->assertNotNull($token);

      Mail::assertSentTo($user, TokenMail::class, function($mail) use($token){
         return $mail->token->id == $token->id;
      });
      return;
      //Todo : tarea
      $this->seeRouteIs('register_confirmation')
          ->see('Gracias por registrarte')
          ->see('Enviamos a tu email un correo para inicar session');
  }
}
