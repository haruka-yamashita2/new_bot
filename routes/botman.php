<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

//$botman->hears('Hi', function ($bot) {
  //  $bot->reply('Hello!');
    //$bot->ask('Whats your name?', function($answer, $bot){
      //      $bot->say('Welcome '.$answer->getText());
//    });
//});
$botman->hears('hi', BotManController::class.'@startConversation');

$botman->hears('Start translation', BotManController::class.'@startTranslation');
