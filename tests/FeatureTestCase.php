<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeatureTestCase extends TestCase
{
  use DatabaseTransactions;

  public function seeErrors(array $fields)
  {
      foreach($fields as $name => $errors){
          foreach((array) $errors as $message){
              $this->seeInElement("#field_{$name} .help-block", $message);
          }
      }
  }
}
