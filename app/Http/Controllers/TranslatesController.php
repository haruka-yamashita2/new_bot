<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslatesController extends Controller
{
    public function askReason()
    {
        $bot->reply('Hello World');
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
