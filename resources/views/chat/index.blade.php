<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Chat - {{ config('app.name', 'Laravel') }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased h-screen overflow-hidden bg-gray-100">
    <div class="h-full flex overflow-hidden">

        <!-- Sidebar Room List -->
        <div class="md:w-80 w-full bg-white border-r border-gray-200 flex flex-col {{ $selectedRoom ? 'hidden md:flex' : 'flex' }}">
            <!-- Header -->
            <div class="p-4 border-b border-gray-100 flex justify-between items-center bg-white h-[65px]">
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-gray-600 transition-colors" title="Back to Dashboard">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <h2 class="font-semibold text-gray-800">Messages</h2>
                </div>
                <div class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                    {{ $chatRooms->count() }} Chats
                </div>
            </div>

            <!-- Room List -->
            <div class="flex-1 overflow-y-auto p-2 space-y-1">
                @forelse($chatRooms as $room)
                <a href="{{ route('chat.index', ['room' => $room->id]) }}"
                    class="block p-3 rounded-lg transition-colors {{ $selectedRoom && $selectedRoom->id === $room->id ? 'bg-blue-50 border-blue-100 border' : 'hover:bg-gray-50' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shrink-0">
                            {{ strtoupper(substr($room->user->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $room->user->name }}</h3>
                                <span class="text-xs text-gray-400 shrink-0">
                                    {{ $room->latestMessage ? $room->latestMessage->created_at->format('H:i') : '' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">
                                {{ $room->latestMessage ? $room->latestMessage->message : 'No messages yet' }}
                            </p>
                        </div>
                    </div>
                </a>
                @empty
                <div class="p-8 text-center text-gray-400 text-sm">
                    No active chats found.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col bg-gray-50 min-w-0 h-full {{ $selectedRoom ? 'flex' : 'hidden md:flex' }}">
            @if($selectedRoom)
            <!-- Chat Header -->
            <div class="flex items-center p-4 bg-white border-b border-gray-200 shadow-sm z-10 h-[65px]">
                <!-- Mobile Back Button -->
                <a href="{{ route('chat.index') }}" class="md:hidden mr-3 text-gray-500 hover:text-gray-700">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm shrink-0 mr-3">
                    {{ strtoupper(substr($selectedRoom->user->name, 0, 2)) }}
                </div>
                <div class="flex-1">
                    <h3 class="font-semibold text-gray-800">{{ $selectedRoom->user->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $selectedRoom->user->email }}</p>
                </div>

                <!-- Desktop Back to Dashboard (Optional) -->
                <a href="{{ route('dashboard') }}" class="hidden md:flex text-gray-400 hover:text-gray-600 transition-colors text-sm items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Exit
                </a>
            </div>

            <!-- Messages -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-4">
                @forelse($selectedRoom->messages as $message)
                @php
                $isSentByMe = $message->is_admin_message;
                @endphp
                <div class="flex {{ $isSentByMe ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $message->id }}">
                    <div class="flex items-end max-w-[85%] md:max-w-[70%] gap-2 {{ $isSentByMe ? 'flex-row-reverse' : 'flex-row' }}">
                        <!-- Avatar -->
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 {{ $isSentByMe ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600' }}">
                            {{ $isSentByMe ? 'AD' : strtoupper(substr($selectedRoom->user->name, 0, 2)) }}
                        </div>

                        <!-- Cloud Bubble -->
                        <div class="px-4 py-2 rounded-2xl shadow-sm text-sm {{ $isSentByMe ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 border border-gray-200' }}">
                            <p class="break-words">{{ $message->message }}</p>
                            <div class="text-[10px] mt-1 {{ $isSentByMe ? 'text-blue-200 text-right' : 'text-gray-400' }}">
                                {{ $message->created_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div id="emptyState" class="flex flex-col items-center justify-center h-full text-gray-400 opacity-60">
                    <i class="fas fa-comments text-6xl mb-4"></i>
                    <p>No messages yet. Start conversation!</p>
                </div>
                @endforelse
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-gray-200">
                <div class="flex items-center gap-2">
                    <input type="text"
                        id="messageInput"
                        class="flex-1 border-gray-300 rounded-full focus:border-blue-500 focus:ring-blue-500 shadow-sm"
                        placeholder="Type your message..."
                        autocomplete="off">
                    <button id="sendBtn" onclick="sendMessage()" class="bg-blue-600 hover:bg-blue-700 text-white rounded-full w-10 h-10 flex items-center justify-center shadow-lg transition-transform active:scale-95">
                        <i id="sendIcon" class="fas fa-paper-plane text-sm"></i>
                        <i id="loadingIcon" class="fas fa-spinner fa-spin hidden"></i>
                    </button>
                </div>
            </div>
            @else
            <div class="flex-1 flex flex-col items-center justify-center text-gray-400 bg-gray-50 relative">
                <!-- Back button for empty state -->
                <a href="{{ route('dashboard') }}" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">
                    <i class="fas fa-times"></i>
                </a>

                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-comments text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-600">Select a chat to start messaging</h3>
            </div>
            @endif
        </div>
    </div>

    @php
    $chatConfig = [
    'roomId' => $selectedRoom ? $selectedRoom->id : null,
    'isAdmin' => true,
    'lastMessageId' => ($selectedRoom && $selectedRoom->messages->count() > 0) ? $selectedRoom->messages->last()->id : 0,
    'sendUrl' => route('chat.send'),
    'pollUrl' => route('chat.messages', ['room' => 'ROOM_ID']),
    ];
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var config = JSON.parse('{!! json_encode($chatConfig) !!}');
            var currentRoomId = config.roomId;
            var lastMessageId = config.lastMessageId;

            const chatMessages = document.getElementById('chatMessages');
            const messageInput = document.getElementById('messageInput');
            const sendBtn = document.getElementById('sendBtn');
            const sendIcon = document.getElementById('sendIcon');
            const loadingIcon = document.getElementById('loadingIcon');

            function scrollToBottom() {
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }
            scrollToBottom();

            window.sendMessage = function() {
                const message = messageInput.value.trim();
                if (!message || !currentRoomId) return;

                messageInput.disabled = true;
                sendIcon.classList.add('hidden');
                loadingIcon.classList.remove('hidden');

                fetch(config.sendUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: message,
                            room_id: currentRoomId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            messageInput.value = '';
                            appendMessage(data.message, true);
                            lastMessageId = data.message.id;
                        }
                    })
                    .catch(error => console.error('Error:', error))
                    .finally(() => {
                        messageInput.disabled = false;
                        messageInput.focus();
                        sendIcon.classList.remove('hidden');
                        loadingIcon.classList.add('hidden');
                    });
            };

            function appendMessage(msg, isMe) {
                // Prevent duplicate messages
                if (document.querySelector(`div[data-message-id="${msg.id}"]`)) {
                    return;
                }

                // Remove empty state if exists
                const emptyState = document.getElementById('emptyState');
                if (emptyState) {
                    emptyState.remove();
                }

                const div = document.createElement('div');
                div.className = `flex ${isMe ? 'justify-end' : 'justify-start'}`;
                div.setAttribute('data-message-id', msg.id);

                const initials = isMe ? 'AD' : msg.sender_name.substring(0, 2).toUpperCase();
                const avatarColor = isMe ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600';
                const bubbleColor = isMe ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 border border-gray-200';
                const timeColor = isMe ? 'text-blue-200 text-right' : 'text-gray-400';

                div.innerHTML = `
                    <div class="flex items-end max-w-[85%] md:max-w-[70%] gap-2 ${isMe ? 'flex-row-reverse' : 'flex-row'}">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold shrink-0 ${avatarColor}">
                            ${initials}
                        </div>
                        <div class="px-4 py-2 rounded-2xl shadow-sm text-sm ${bubbleColor}">
                            <p class="break-words">${escapeHtml(msg.message)}</p>
                            <div class="text-[10px] mt-1 ${timeColor}">
                                ${msg.created_at}
                            </div>
                        </div>
                    </div>
                `;
                chatMessages.appendChild(div);
                scrollToBottom();
            }

            function escapeHtml(text) {
                var div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            if (messageInput) {
                messageInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        sendMessage();
                    }
                });
            }

            if (currentRoomId) {
                setInterval(() => {
                    const url = config.pollUrl.replace('ROOM_ID', currentRoomId) + '?last_id=' + lastMessageId;
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.messages && data.messages.length > 0) {
                                data.messages.forEach(msg => {
                                    const isMe = msg.is_admin_message;
                                    appendMessage(msg, isMe);
                                    lastMessageId = msg.id;
                                });
                            }
                        })
                        .catch(err => console.error(err));
                }, 3000);
            }
        });
    </script>
</body>

</html>