<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chatbot;

class ChatbotController extends Controller
{
    public function index()
    {
        $questions = Chatbot::select('question')->get(); // Mengambil pertanyaan dari tabel chatbot
        return view('chatbot', compact('questions'));
        
    }
    public function questionindex()
    {
        return view('add_question');
    }

    public function query(Request $request)
    {
        $question = $request->input('question');
        
        // Mencari pertanyaan yang sama persis di database
        $response = Chatbot::where('question', '=', $question)->first();
        
        if ($response) {
            // Menyimpan pertanyaan dari pengguna ke database
            // Tidak perlu membuat baru jika pertanyaan sudah ada di database
            // Chatbot::create([
            //     'question' => $question,
            //     'answer' => $response->answer,
            // ]);
    
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

        return redirect()->back()->with('successaddchatbot', 'Pertanyaan dan jawaban berhasil ditambahkan.');
    }
}
