@extends('layouts.apps')
@section('main')
    <body>
    <h1>Job Interview Chatbot</h1>
    <div id="chat-box">
        <div id="messages"></div>
        <input type="text" id="user-input" placeholder="Type your message here...">
        <button onclick="sendMessage()">Send</button>
    </div>

    <script>
        const sendMessage = async () => {
            const userMessage = document.getElementById('user-input').value;

            if (!userMessage) {
                alert("Please type a message.");
                return;
            }

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch('{{ route('chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ message: userMessage }),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error);
                }

                const data = await response.json();
                const messageBox = document.getElementById('messages');
                messageBox.innerHTML += `<p>User: ${userMessage}</p><p>Bot: ${data.response}</p>`;
                document.getElementById('user-input').value = ''; // Clear input box

            } catch (error) {
                console.error('Error:', error.message);
            }
        };
    </script>
    </body>
@endsection
