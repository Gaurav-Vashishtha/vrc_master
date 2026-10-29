// Timer for chat session
let timerInterval = null;
let timerSeconds = 0;
localStorage.removeItem('chatbot_contact_submitted');
localStorage.removeItem('chatbot_contact_name');
localStorage.removeItem('openai_thread_id');

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
    let contactName = localStorage.getItem('chatbot_contact_name');

    function renderWelcome(name) {
        $('#chatMessages').html('');
        addBotMessage({
            text: `Nice to meet you, **${escapeHtml(name)}**! 😊\nHow can I help you today? You can ask me about our services, software products, web & mobile development, portfolio, company information, or contact details.`,
            suggestions: [
                'Our Services',
                'Software Products',
                'SEO Sevices',
                'Web & Mobile Development',
                'Portfolio',
                'Company Information',
                'Contact Details',
            ]
        });
    }

    function showChatAfterContact(name, contact) {
        contactName = name;
        localStorage.setItem('chatbot_contact_name', name);
        localStorage.setItem('chatbot_contact_submitted', contact);
        showContactSummary(name, contact);
        $('#contactGate').hide();
        $('#chatMessages').css('display', 'flex');
        $('.chat-footer').css('display', 'flex');
        // $('.powered').css('display', 'block');
        renderWelcome(name);
        $('#chatInput').trigger('focus');
    }

    function showContactSummary(name, contact) {
        $('#contactSummaryName').text(name);
        $('#contactSummaryNumber').text(contact);
        $('#contactSummary').prop('hidden', false);
    }

    function clearContactDetails() {
        localStorage.removeItem('chatbot_contact_submitted');
        localStorage.removeItem('chatbot_contact_name');
        localStorage.removeItem('openai_thread_id');

        threadId = null;
        contactName = null;
        $('#contactSummary').prop('hidden', true);
        $('#chatMessages, .chat-footer').hide();
        $('#contactGate').show();
        $('#contactFormError').text('');
        $('#contactForm')[0].reset();
    }

    if (localStorage.getItem('chatbot_contact_submitted') && contactName) {
        showContactSummary(contactName, localStorage.getItem('chatbot_contact_submitted'));
        $('#contactGate').hide();
        $('#chatMessages').css('display', 'flex');
        $('.chat-footer').css('display', 'flex');
        // $('.powered').css('display', 'block');
        renderWelcome(contactName);
    } else {
        $('#contactSummary').prop('hidden', true);
        $('#chatMessages, .chat-footer').hide();
    }

    $('#clearContactIcon').on('click', clearContactDetails);

    $('#contactForm').on('submit', async function (event) {
        event.preventDefault();

        const form = this;
        const submitButton = $('#contactSubmitBtn');
        const errorElement = $('#contactFormError');
        const name = $('#contactName').val().trim();
        const contact = $('#contactNumber').val().trim();

        if (!name || !contact) {
            errorElement.text('Please enter your name and contact number.');
            return;
        }

        if (!threadId) {
            await createThread();
        }

        errorElement.text('');
        submitButton.prop('disabled', true).text('Starting...');

        try {
            const response = await $.ajax({
                url: chatbotConfig.contactUrl,
                method: 'POST',
                data: {
                    fullname: name,
                    contact: contact,
                    thread_id: threadId
                }
            });

            if (response.success) {
                showChatAfterContact(name, contact);
                form.reset();
            } else {
                throw new Error(response.message || 'Unable to save your details.');
            }
            submitButton.prop('disabled', false).html('Start chatting <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>');
        } catch (error) {
            errorElement.text(error.responseJSON?.errors || error.message || 'Unable to save your details. Please try again.');
            submitButton.prop('disabled', false).html('Start chatting <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>');
        }
    });

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
        renderWelcome(contactName);
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


    async function sendMessage(val = '') {
        let message = val || $('#chatInput').val().trim();
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
                let replyData = response.reply;
                // reply is JSON string, convert it to object
                if (typeof replyData === 'string') {
                    try {
                        replyData = JSON.parse(replyData);
                    } catch (e) {
                        console.error('Invalid reply JSON:', e);
                        replyData = {
                            text: replyData
                        };
                    }
                }
                addBotMessage(replyData);
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

    function addBotMessage(data) {

        let html = '';

        //TEXT
        if (data.text) {
            html += marked.parse(data.text);
        }

        // LINK
        if (data.link && data.link.label && data.link.url) {
            html += `
                <div class="chat-link-wrapper">
                    <a href="${escapeHtml(data.link.url)}"
                    class="chat-link-btn">
                        ${escapeHtml(data.link.label)} &nbsp;<i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                    </a>
                </div>
            `;
        }

        //  SUGGESTIONS
        if (Array.isArray(data.suggestions) && data.suggestions.length > 0) {
            html += `
                <div class="chat-suggestions">
            `;

            data.suggestions.forEach(function (suggestion) {
                html += `
                    <button
                        type="button"
                        class="chat-suggestion-btn"
                        data-message="${escapeHtml(suggestion)}">
                        ${escapeHtml(suggestion)}
                    </button>
                `;
            });

            html += `
                </div>
            `;
        }

        // APPEND MESSAGE
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


    $(document).on('click', '.chat-suggestion-btn', function () {
        const message = $(this).data('message');
        sendMessage(message);
    });
});