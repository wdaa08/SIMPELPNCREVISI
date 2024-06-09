@extends('layouts.tampilansatgas')

@section('container')

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            /* display: flex;
            justify-content: center;
            align-items: center; */
            height: 100vh;
        }

        .container {
            width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 6px;
            color: #666;
        }

        input[type="text"],
        textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container my-4">
        <div class="container">
            <h2>Tambah Pertanyaan</h2>
            @if (session('success'))
                <div>{{ session('success') }}</div>
            @endif
            <form action="{{ route('chatbot.store') }}" method="POST">
                @csrf
                <label for="question">Pertanyaan:</label>
                <input type="text" id="question" name="question" required>
                <label for="answer">Jawaban:</label>
                <textarea id="answer" name="answer" required></textarea>
                <button type="submit">Tambah</button>
            </form>
        </div>
    </div>

@endsection