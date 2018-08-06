<?php

namespace App\Conversations;

use Illuminate\Foundation\Inspiring;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class ExampleConversation extends Conversation
{
    /**
     * First question
     */
    public function askLanguage()
    {
        $this->ask('Hello! Please text!', function(Answer $answer) {
            // Save result

            $this->language = $answer->getText();
            
         $str = mb_convert_kana($this->language, "S");
            

      $url = 'https://api.cognitive.microsoft.com/sts/v1.0/issueToken';
      $header = array( 
            "Content-Type: application/x-www-form-urlencoed", //ファイルの種類
            "Accept: application/jwt",
            "Content-Length: 0",
            'Ocp-Apim-Subscription-Key: 5dfa2fc3bdad421f9e8745a242d55075'//Microsoft Translator Text APIキー
            ); //キー隠す
 
        $context = array( 
            "http" => array(
            "method" => "POST",
            "header" => implode("\r\n", $header)
         ));
 
        $token = file_get_contents($url, false, stream_context_create($context));//アクセストークンを取得
        
        $key = "Bearer%20". $token;
        $text = $str;
        $url = "https://api.microsofttranslator.com/v2/http.svc/Translate";
        $data = "?appid=".$key."&text=".$text."&to=ja";
        $str = file_get_contents($url.$data);
        $str = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/','',$str);//タグの除去を正規表現により行う
    
        
        
     //   $this->say($answer->getText);
            $this->say($str);

        });
    }

    public function run()
    {
        // This will be called immediately
        $this->askLanguage();
    }
}
