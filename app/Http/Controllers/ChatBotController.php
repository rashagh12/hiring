<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function chat(Request $request)
    {
        $client = new Client();

        try {
            $response = $client->post(route('chat'), [
                'json' => ['message' => $request->input('message')],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return response()->json(['response' => $data['response']]);
        } catch (GuzzleException $e) {
            return response()->json(['error' => 'Failed to communicate with chatbot server.'], 500);
        }
    }
}
