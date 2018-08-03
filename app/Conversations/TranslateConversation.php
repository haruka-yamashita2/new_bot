<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class TranslateConversation extends Conversation
{
    /**
     * First question
     */
    public function askAnswer()
    {
        $this->ask('What language do you translate?', function(Answer $english){
        $this->say($japanese->getText());
    });
    
    $english = "";
    $japanese = "";
       
    if(isset($_POST["english"])){ //フォームにenがpostされたら 
    $english = $_POST["english"];
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
    $text = $_POST["english"];
    $url = "https://api.microsofttranslator.com/v2/http.svc/Translate";
    $data = "?appid=".$key."&text=".$text."&to=ja";
    $japanese = file_get_contents($url.$data);//翻訳を実行
    $japanese = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/','',$japanese);//タグの除去を正規表現により行う
    };
    }
               // return $this->($japanese function (Answer $answer) {
                    
            //    };


    /**
     * Start the conversation
     */
        public function run()
        {
            $this->askAnswer();
        }
}