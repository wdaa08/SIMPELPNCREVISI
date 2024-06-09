<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot');
    }
    public function questionindex()
    {
        return view('add_question');
    }

    public function query(Request $request)
    {
        $question = $request->input('question');
        $keywords = explode(' ', $question); // Memecah pertanyaan menjadi kata kunci

        // Membangun query untuk mencari pertanyaan yang mengandung salah satu kata kunci
        $query = Chatbot::query();
        foreach ($keywords as $keyword) {
            $query->orWhere('question', 'like', '%' . $keyword . '%');
        }

        $response = $query->first();

        if ($response) {
            return response()->json(['answer' => $response->answer]);
        } else {
            return response()->json(['answer' => 'Maaf, saya tidak mengerti pertanyaan Anda.']);
        }
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        Chatbot::create($validatedData);

        return redirect()->back()->with('success', 'Pertanyaan dan jawaban berhasil ditambahkan.');
    }
}
