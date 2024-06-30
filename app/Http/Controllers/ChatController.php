<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(){
        return view('chatbot.chatbot');
    }
    public function comparison(Request $request)
{
    
    // $randomNumber = mt_rand(1000, 9999); // ينشئ رقم عشوائي بين 1000 و 9999
    // return view('chatbot.number');

    // $randomNumber = mt_rand(1000, 9999);

    // $userNumber = $request->input('userNumber');
    // // مقارنة الرقم العشوائي مع الرقم المدخل من المستخدم
    // if (isset($_POST['userNumber'])) {
    //     $userNumber = intval($_POST['userNumber']);
    //     if ($userNumber == $randomNumber) {
    //         return view('chatbot.number',[
    //             'randomNumber' => $randomNumber
    //         ]);
    //     } else {
    //         return 'You are not allowed to make the interview';
    //     }
    // }

        $userNumber = $request->input('userNumber');


        if ($userNumber == 157) {
                return view('chatbot.number');
            } else {
                return 'You are not allowed to make the interview';
            }
}
}
