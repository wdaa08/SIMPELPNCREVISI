<!DOCTYPE html>
<html>
<head>
    <title>Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* CSS untuk tampilan kotak seperti aplikasi SMS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .chat-container {
            width: 400px; /* Lebarkan kotak chatbot */
            height: 500px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex; /* Gunakan flexbox untuk mengatur tata letak */
            flex-direction: column; /* Atur tata letak elemen ke dalam kolom */
        }

        .chat-header {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            font-weight: bold;
        }

        .chatbox {
    flex: 1;
    overflow-y: auto;
    padding: 10px;
    display: flex;
    flex-direction: column; /* Ubah ke arah kolom */
}


        .message {
            padding: 8px 12px;
            border-radius: 8px;
            margin: 5px;
            max-width: 70%;
            word-wrap: break-word; /* Agar pesan yang panjang akan dibungkus ke baris berikutnya */
        }

        .user-message {
            align-self: flex-end; /* Pesan pengguna sekarang akan muncul di sebelah kanan */
            background-color: #cce5ff;
        }

        .bot-message {
            align-self: flex-start; /* Pesan bot sekarang akan muncul di sebelah kiri */
            background-color: #e6f2ff; /* Bedakan warna latar belakang pesan bot */
        }

        .chat-input-container {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .chat-input {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 20px;
            outline: none;
        }

        .send-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 8px 20px;
            margin-left: 10px;
            cursor: pointer;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">Chatbot Satgas PPKS PNC</div>
        <div class="chatbox" id="chatbox">
            <!-- Percakapan akan muncul di sini -->
        </div>
        <div class="chat-input-container">
            <input type="text" id="userInput" class="chat-input" placeholder="Ketik pesan..." onkeydown="if (event.keyCode == 13) sendMessage()">
            <button onclick="sendMessage()" class="send-button">Kirim</button>
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
                    url: '{{ route("chatbot.query") }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        question: userInput
                    },
                    success: function(response) {
                        $('#chatbox').append('<div class="message bot-message">' + response.answer + '</div>');
                        scrollToBottom(); // Panggil fungsi scrollToBottom setelah menambahkan pesan bot
                    }
                });
            }
        }

        function scrollToBottom() {
            $('#chatbox').scrollTop($('#chatbox')[0].scrollHeight);
        }
    </script>
    
</body>
</html>
