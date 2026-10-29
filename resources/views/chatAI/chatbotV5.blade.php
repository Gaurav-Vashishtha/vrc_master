<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VRC Chatbot V5</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('chatbot/chatbotV5.css') }}">
</head>
<body>
    <div id="chatToggleBtn"><img src="{{asset('chatbot/img/Chat_Icon.gif')}}" alt="Chat Icon" style="height: 50px;"></div>
    <div id="chatWidget">
        <div class="chat-header">
            <div class="header-left">
                <div class="bot-avatar">
                    <img src="{{asset('chatbot/img/short-logo.png')}}" alt="logo">
                </div>
                <div>
                    <h3>VRC Assistant</h3>
                    <span>Online</span>
                </div>
            </div>

            <div class="header-actions">
                <div class="chatTimer" id="chatTimer">00:00</div>
                <button id="newChatBtn" title="New Chat">↺</button>
                <button id="closeChatBtn" title="Close">✕</button>
            </div>
        </div>

        <div id="contactSummary" class="contact-summary" hidden>
            <div class="contact-summary-details">
                <strong id="contactSummaryName"></strong>
                <span>·</span>
                <span id="contactSummaryNumber"></span>
            </div>
            <button type="button" id="clearContactIcon" title="Clear details and switch user" aria-label="Clear details and switch user">×</button>
        </div>

        <div id="contactGate" class="contact-gate">
            <div class="contact-gate-icon">
                <img src="{{asset('chatbot/img/Chat_Icon.gif')}}" alt="Chat Icon" style="height: 50px;"></img>
            </div>
            <h4>Before we get started</h4>
            <p>Tell us your name and contact number so we can assist you better.</p>
            <form id="contactForm">
                <label for="contactName">Your name</label>
                <input type="text" id="contactName" name="fullname" placeholder="Enter your name" maxlength="100" required>
                <label for="contactNumber">Contact number</label>
                <input type="tel" id="contactNumber" name="contact" placeholder="Enter your contact number" maxlength="50" required>
                <p id="contactFormError" class="contact-form-error" role="alert"></p>
                <button type="submit" id="contactSubmitBtn">Start chatting <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            </form>
        </div>

        <!-- Messages -->
        <div id="chatMessages">
            <div class="bot-message welcome-message">
                <div class="welcome-logo">
                    <img src="https://vrwebconsulting.com/images/logo/vrc-logo.png" alt="VRC Logo">
                </div>
                <div class="welcome-content">
                    <h4>Welcome to VR Consulting 👋</h4>
                    <p>Ask me about website development, mobile applications, CRM solutions, ERP software, MLM platforms, digital marketing, software products, or any of our business services.</p>
                </div>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div id="typingIndicator">
            <div class="typing-bubble">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <!-- Footer -->
        <div class="chat-footer">
            <input type="text" id="chatInput" placeholder="Type your message..." autocomplete="off">
            <button id="sendBtn">➤</button>
        </div>

        <div class="powered">
            Powered by <strong>VRC</strong> · <a href="https://vrwebconsulting.com/" target="_blank">vrwebconsulting.com</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        window.chatbotConfig = {
            createThreadUrl: "{{ url('api/v5/chatbot/create-thread') }}",
            sendMessageUrl: "{{ url('api/v5/chatbot/send-message') }}",
            contactUrl: "{{ url('api/v5/contact') }}",
        };
    </script>
    <script src="{{ asset('chatbot/chatbotV5.js') }}"></script>
</body>
</html>