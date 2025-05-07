<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GiftIdeasController extends Controller
{
    //
    public function generate(Request $request)
    {
        $gender = $request->gender;
        $occasion = $request->occasion;
    
        $prompt = "Suggest 5 gift ideas for a". $gender." person on ".$occasion.". Include links where possible.";
    
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);
    
        $content = $response->json();
    
        $text = $content['choices'][0]['message']['content'] ?? '';
    
        $ideas = explode("\n", $text);
        $formattedIdeas = [];
    
        foreach ($ideas as $idea) {
            if (trim($idea)) {
                $parts = explode('-', $idea, 2);
                $formattedIdeas[] = [
                    'name' => trim($parts[1] ?? $idea),
                    'link' => '#'
                ];
            }
        }
    
        return response()->json(['ideas' => $formattedIdeas]);
    }
}


