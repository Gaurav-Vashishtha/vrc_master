// Timer for chat session
let timerInterval = null;
let timerSeconds = 0;

function formatTime(s) {
    const mm = String(Math.floor(s / 60)).padStart(2, '0');
    const ss = String(s % 60).padStart(2, '0');
    return `${mm}:${ss}`;
}

function updateTimerDisplay() {
    const el = document.getElementById('chatTimer');
    if (el) el.textContent = formatTime(timerSeconds);
}

function startTimer() {
    // start fresh
    stopTimer();
    timerSeconds = 0;
    updateTimerDisplay();
    timerInterval = setInterval(() => {
        timerSeconds++;
        updateTimerDisplay();
    }, 1000);
}

function stopTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function resetTimer() {
    timerSeconds = 0;
    updateTimerDisplay();
}

document.addEventListener('DOMContentLoaded', () => {
    // Get elements
    const chatToggleBtn = document.getElementById('chatToggleBtn');
    const chatWidget = document.getElementById('chatWidget');
    const closeChatBtn = document.getElementById('closeChatBtn');
    // Toggle Open
    chatToggleBtn.addEventListener('click', () => {
        chatWidget.classList.add('active');
        $('#chatToggleBtn').hide();
        startTimer();
    });
 
    // Toggle Close
    closeChatBtn.addEventListener('click', () => {
        chatWidget.classList.remove('active');
        $('#chatToggleBtn').show();
        stopTimer();
    });
});

$(document).ready(function () {
    let threadId = localStorage.getItem('openai_thread_id');

    $('#newChatBtn').on('click', function () {

        if (!confirm('Start a new chat?')) {
            return;
        }

        localStorage.removeItem('openai_thread_id');
        threadId = null;

        $('#chatMessages').html(`
            <div class="bot-message welcome-message">
                <div class="welcome-logo">
                    <img src="https://vrwebconsulting.com/images/logo/vrc-logo.png" alt="VRC Logo">
                </div>
                <div class="welcome-content">
                    <h4>Welcome to VR Consulting 👋</h4>
                    <p>Ask me about website development, mobile applications, CRM solutions, ERP software, MLM platforms, digital marketing, software products, or any of our business services.</p>
                </div>
            </div>
        `);
        // reset timer when starting a new chat
        resetTimer();
        startTimer();
    });


    $('#chatInput').keypress(function (e) {
        if (e.which === 13) {
            e.preventDefault();
            sendMessage();
        }
    });

    $('#sendBtn').on('click', function () {
        sendMessage();
    });

    async function createThread() {
        const response = await $.ajax({
            url: chatbotConfig.createThreadUrl,
            method: 'POST',
        });

        threadId = response.thread_id;
        localStorage.setItem(
            'openai_thread_id',
            response.thread_id
        );
        return response.thread_id;
    }


    async function sendMessage() {
        let message = $('#chatInput').val().trim();
        if (!message) { return;}

        addUserMessage(message);
        $('#chatInput').val('');
        scrollBottom();
        try {
            if (!threadId) {
                await createThread();
            }

            showTyping();
            const response = await $.ajax({
                url: chatbotConfig.sendMessageUrl,
                method: 'POST',
                data: {
                    thread_id: threadId,
                    message: message
                }

            });

            hideTyping();
            if (response.success) {
                addBotMessage(response.reply);
            } else {
                addBotMessage('Sorry, something went wrong.');
            }
        } catch (error) {
            hideTyping();
            addBotMessage('Server error. Please try again.');
            console.error(error);
        }
        scrollBottom();
    }


    function addUserMessage(message) {

        $('#chatMessages').append(`
            <div class="user-message">
                ${escapeHtml(message)}
            </div>
        `);
    }

    function addBotMessage(message) {
        let html = marked.parse(message);
        $('#chatMessages').append(`
            <div class="bot-message">
                ${html}
            </div>
        `);
        scrollBottom();
    }

    function showTyping() {
        $('#typingIndicator').show();
        scrollBottom();
    }

    function hideTyping() {
        $('#typingIndicator').hide();
    }


    function scrollBottom() {
        let box = $('#chatMessages');
        box.scrollTop(
            box[0].scrollHeight
        );
    }

    function escapeHtml(text) {
        return $('<div>').text(text).html();
    }

    function nl2br(text) {
        return text.replace(/\n/g, '<br>');
    }
});