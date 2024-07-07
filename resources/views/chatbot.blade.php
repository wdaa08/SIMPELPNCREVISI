@extends('layouts.tampilanpelapor')

@section('container')

<style>
    /* CSS untuk tampilan kotak seperti aplikasi SMS */
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
        height: 100vh;
    }

    .chat-container {
        width: 100%; /* Ubah lebar chat container untuk mengisi lebar kolom */
        height: 400px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        text-align: center;
        font-weight: bold;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .chatbox {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        display: flex;
        flex-direction: column;
    }

    .message {
        padding: 8px 12px;
        border-radius: 8px;
        margin: 5px;
        max-width: 70%;
        word-wrap: break-word;
    }

    .user-message {
        align-self: flex-end;
        background-color: #cce5ff;
    }

    .bot-message {
        align-self: flex-start;
        background-color: #e6f2ff;
    }

    .chat-input-container {
        display: flex;
        padding: 10px;
        border-top: 1px solid #ccc;
        align-items: center;
    }

    .chat-input {
        flex: 1;
        padding: 8px;
        border: none;
        border-radius: 20px;
        outline: none;
        margin-right: 10px;
    }

    .send-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        cursor: pointer;
        outline: none;
    }

    .instructions {
        margin-bottom: 10px;
        text-align: center;
        color: #666;
    }

    /* Additional style for popular questions card */
    .popular-questions {
        width: 100%; /* Mengisi lebar kolom */
        margin-top: 20px;
        max-height: 400px; /* Tambahkan maksimum tinggi untuk scroll */
        overflow-y: auto; /* Aktifkan scroll jika melebihi maksimum tinggi */
    }

    .popular-questions .card {
        height: 100%;
    }

    .popular-questions .card-header {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        border-bottom: none; /* Hapus border-bottom pada header */
    }

    .popular-questions .card-body {
        padding: 10px;
    }

    .popular-questions .link {
        display: block;
        padding: 8px 12px;
        background-color: #f0f0f0;
        color: #333;
        text-decoration: none;
        border-radius: 8px;
        margin-bottom: 5px;
        transition: background-color 0.3s ease;
    }

    .popular-questions .link:hover {
        background-color: #e0e0e0;
    }
</style>

<div class="container-fluid pt-4 px-4">
    <div class="row g-4">



        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <div class="popular-questions">
                    <h4 class="mb-4">Pertanyaan Populer</h4>
                    @foreach($questions->groupBy('babpertanyaan') as $babPertanyaan => $pertanyaans)
                        <div class="accordion mb-3" id="accordion{{ $loop->index }}">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $loop->index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="false" aria-controls="collapse{{ $loop->index }}">
                                        {{ $babPertanyaan }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordion{{ $loop->index }}">
                                    <div class="accordion-body">
                                        <ul class="list-group">
                                            @foreach($pertanyaans as $question)
                                                <li class="list-group-item">
                                                    <a href="#" class="link" onclick="selectQuestion('{{ $question->question }}')">
                                                        {{ $question->question }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        







        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <div class="chat-container">
                    <div class="chat-header">Chatbot Satgas PPKS PNC</div>
                    <div class="chatbox" id="chatbox">
                        <div class="message bot-message instructions" style="text-align: left;">
                            Selamat datang! {{ auth()->user()->nama }} Anda dapat bertanya beberapa pertanyaan populer yang dapat anda lihat di sebelah kanan chatbot ini.
                        </div>
                        <div class="message bot-message instructions" style="text-align: left;">
                            Jangan lupa! {{ auth()->user()->nama }} Untuk memperbarui profil
                        </div>
                    </div>
                    <div class="chat-input-container" >
                        <input type="text" id="userInput" name="question" class="chat-input" placeholder="Ketik pesan..."
                            onkeydown="if (event.keyCode == 13) sendMessage()">
                        <button onclick="sendMessage()" class="send-button">
                            <i class="fas fa-paper-plane"></i> <!-- Icon pesawat kertas -->
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function sendMessage() {
        var userInput = $('#userInput').val();
        if (userInput.trim() !== '') {
            $('#chatbox').append('<div class="message user-message">' + userInput + '</div>');
            $('#userInput').val('');

            $.ajax({
                url: '{{ route('chatbot.query') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    question: userInput
                },
                success: function(response) {
                    $('#chatbox').append('<div class="message bot-message">' + response.answer + '</div>');
                    scrollToBottom();
                }
            });
        }
    }

    function scrollToBottom() {
        $('#chatbox').scrollTop($('#chatbox')[0].scrollHeight);
    }

    function selectQuestion(question) {
        $('#userInput').val(question);
        sendMessage();
    }
</script>

@endsection
