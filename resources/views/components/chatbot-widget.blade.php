<style>
    .chatbot-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: 'Figtree', sans-serif;
    }

    .chatbot-button {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        background: linear-gradient(135deg, #d1fae5 0%, #bfdbfe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(13, 148, 136, 0.3);
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), background 0.3s ease;
        border: 3px solid white;
        position: relative;
        overflow: hidden;
        animation: pulse-ring 2s infinite;
        padding: 0;
    }

    .chatbot-button:hover {
        transform: scale(1.08);
        background: linear-gradient(135deg, #a7f3d0 0%, #93c5fd 100%);
        box-shadow: 0 12px 30px rgba(13, 148, 136, 0.4);
        animation: none;
    }

    @keyframes pulse-ring {
        0% { box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.5); }
        70% { box-shadow: 0 0 0 15px rgba(13, 148, 136, 0); }
        100% { box-shadow: 0 0 0 0 rgba(13, 148, 136, 0); }
    }

    .bot-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        padding-bottom: 5px;
        transform: scale(0.95);
        animation: float-bot 3s ease-in-out infinite;
    }

    @keyframes float-bot {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    /* Antenna */
    .bot-antenna {
        width: 4px;
        height: 12px;
        background: #0d9488;
        position: absolute;
        top: 8px;
        border-radius: 4px;
        transform-origin: bottom center;
        animation: wag 2s ease-in-out infinite;
    }
    .bot-antenna::before {
        content: '';
        position: absolute;
        top: -4px;
        left: -2px;
        width: 8px;
        height: 8px;
        background: #0d9488;
        border-radius: 50%;
    }

    @keyframes wag {
        0%, 100% { transform: rotate(-15deg); }
        50% { transform: rotate(15deg); }
    }

    /* Head */
    .bot-head {
        width: 48px;
        height: 34px;
        background: linear-gradient(135deg, #34d399 0%, #06b6d4 100%);
        border-radius: 20px 20px 12px 12px;
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2px;
        box-shadow: inset -2px -2px 6px rgba(0,0,0,0.15), inset 2px 2px 6px rgba(255,255,255,0.5);
        transform-origin: bottom center;
        animation: head-bob 4s ease-in-out infinite;
    }

    @keyframes head-bob {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(3deg); }
        75% { transform: rotate(-3deg); }
    }

    /* Visor */
    .bot-visor {
        width: 38px;
        height: 16px;
        background: #0f172a;
        border-radius: 8px;
        margin-top: 6px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    /* Eyes */
    .bot-eye {
        width: 8px;
        height: 10px;
        background: white;
        border-radius: 50%;
        animation: blink 4s infinite;
        position: relative;
        transition: all 0.2s;
    }
    .bot-eye::after {
        content: '';
        position: absolute;
        top: 2px;
        right: 1px;
        width: 3px;
        height: 3px;
        background: #bae6fd;
        border-radius: 50%;
    }

    .chatbot-button:hover .bot-eye {
        animation: none;
        background: transparent;
        border-top: 3px solid white;
        border-radius: 50% 50% 0 0;
        height: 8px;
        width: 10px;
        margin-top: 3px;
    }
    .chatbot-button:hover .bot-eye::after {
        display: none;
    }

    @keyframes blink {
        0%, 3%, 100% { transform: scaleY(1); }
        1.5% { transform: scaleY(0.1); }
    }

    /* Mouth */
    .bot-mouth {
        width: 14px;
        height: 5px;
        background: white;
        border-radius: 0 0 10px 10px;
        margin-top: 4px;
        animation: breath 2s ease-in-out infinite;
    }

    @keyframes breath {
        0%, 100% { transform: scaleX(1) scaleY(1); }
        50% { transform: scaleX(1.2) scaleY(1.3); }
    }

    /* Body */
    .bot-body {
        width: 34px;
        height: 22px;
        background: linear-gradient(135deg, #34d399 0%, #06b6d4 100%);
        border-radius: 12px 12px 0 0;
        position: relative;
        z-index: 1;
        box-shadow: inset -2px -2px 5px rgba(0,0,0,0.15);
    }

    /* Arm */
    .bot-arm {
        width: 12px;
        height: 20px;
        background: #06b6d4;
        border-radius: 8px;
        position: absolute;
        right: -10px;
        top: 4px;
        transform-origin: top center;
        animation: wave 2.5s infinite;
        box-shadow: inset -1px -1px 3px rgba(0,0,0,0.2);
    }

    .chatbot-button:hover .bot-arm {
        animation: wave-fast 0.6s infinite;
    }

    @keyframes wave {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-40deg); }
        50% { transform: rotate(-10deg); }
        75% { transform: rotate(-40deg); }
    }

    @keyframes wave-fast {
        0%, 100% { transform: rotate(-20deg); }
        50% { transform: rotate(-60deg); }
    }

    .chatbot-window {
        display: none;
        position: absolute;
        bottom: 80px;
        right: 0;
        width: 350px;
        height: 500px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        border: 1px solid rgba(255,255,255,0.2);
        flex-direction: column;
        overflow: hidden;
    }

    .chatbot-window.open {
        display: flex;
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .chatbot-header {
        background: #0f766e;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chatbot-header h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .chatbot-header p {
        margin: 0;
        font-size: 12px;
        opacity: 0.8;
    }

    .chatbot-close {
        background: transparent;
        border: none;
        color: white;
        font-size: 20px;
        cursor: pointer;
    }

    .chatbot-body {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #f8fafc;
    }

    .chat-bubble {
        max-width: 80%;
        padding: 10px 15px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.4;
    }

    .chat-bot {
        background: white;
        color: #334155;
        border: 1px solid #e2e8f0;
        align-self: flex-start;
        border-bottom-left-radius: 2px;
    }

    .chat-user {
        background: #0f766e;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 2px;
    }

    .chatbot-footer {
        padding: 15px;
        background: white;
        border-top: 1px solid #e2e8f0;
    }

    .chat-input-group {
        display: flex;
        gap: 10px;
    }

    .chat-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        outline: none;
        font-size: 14px;
    }

    .chat-input:focus {
        border-color: #0f766e;
    }

    .chat-send {
        background: #0f766e;
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .typing-indicator {
        display: none;
        align-self: flex-start;
        background: white;
        padding: 10px 15px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .typing-indicator span {
        height: 6px;
        width: 6px;
        background: #94a3b8;
        border-radius: 50%;
        display: inline-block;
        margin: 0 2px;
        animation: typing 1s infinite;
    }

    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typing {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .chatbot-tooltip {
        position: absolute;
        right: 90px;
        bottom: 20px;
        background: white;
        color: #0f172a;
        padding: 12px 18px;
        border-radius: 16px 16px 0 16px;
        font-size: 13.5px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        white-space: nowrap;
        animation: float-tooltip 3s ease-in-out infinite, pop-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        opacity: 0;
        transform-origin: bottom right;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        z-index: 10;
    }

    .chatbot-tooltip::after {
        content: '';
        position: absolute;
        bottom: -1px;
        right: -8px;
        border-width: 9px 0 0 9px;
        border-style: solid;
        border-color: transparent transparent transparent white;
    }

    .chatbot-tooltip::before {
        content: '';
        position: absolute;
        bottom: -2px;
        right: -10px;
        border-width: 10px 0 0 10px;
        border-style: solid;
        border-color: transparent transparent transparent #e2e8f0;
        z-index: -1;
    }

    @keyframes pop-in {
        0% { opacity: 0; transform: scale(0.5); }
        100% { opacity: 1; transform: scale(1); }
    }

    @keyframes float-tooltip {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-5px) scale(1.1); }
    }

    .chatbot-window.open ~ .chatbot-tooltip {
        display: none !important;
    }
</style>

<div class="chatbot-widget">
    <div class="chatbot-window" id="chatbotWindow">
        <div class="chatbot-header">
            <div>
                <h5>Asisten RSUD</h5>
                <p>Online - AI Powered</p>
            </div>
            <button class="chatbot-close" onclick="toggleChatbot()">&times;</button>
        </div>
        <div class="chatbot-body" id="chatbotBody">
            <div class="chat-bubble chat-bot">
                Halo! Saya Asisten Virtual RSUD. Anda bisa bertanya tentang:
                <ul>
                    <li>Jadwal Dokter hari ini/besok</li>
                    <li>Ketersediaan & Tarif Kamar Inap</li>
                </ul>
                Ada yang bisa saya bantu?
            </div>
            <div class="typing-indicator" id="typingIndicator">
                <span></span><span></span><span></span>
            </div>
        </div>
        <div class="chatbot-footer">
            <form id="chatForm" onsubmit="sendMessage(event)">
                <div class="chat-input-group">
                    <input type="text" id="chatInput" class="chat-input" placeholder="Tulis pesan..." required autocomplete="off">
                    <button type="submit" class="chat-send">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="chatbot-tooltip" onclick="toggleChatbot()">
        Hai! Saya asisten virtual RSUD 👋
    </div>
    <button class="chatbot-button" onclick="toggleChatbot()" aria-label="Buka Chatbot">
        <div class="bot-wrapper">
            <div class="bot-antenna"></div>
            <div class="bot-head">
                <div class="bot-visor">
                    <div class="bot-eye"></div>
                    <div class="bot-eye"></div>
                </div>
                <div class="bot-mouth"></div>
            </div>
            <div class="bot-body">
                <div class="bot-arm"></div>
            </div>
        </div>
    </button>
</div>

<script>
    function toggleChatbot() {
        const window = document.getElementById('chatbotWindow');
        window.classList.toggle('open');
    }

    function appendMessage(text, isUser) {
        const body = document.getElementById('chatbotBody');
        const indicator = document.getElementById('typingIndicator');
        
        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble ' + (isUser ? 'chat-user' : 'chat-bot');
        bubble.textContent = text;
        bubble.innerHTML = bubble.innerHTML.replace(/\n/g, '<br>');
        
        // Insert before typing indicator
        body.insertBefore(bubble, indicator);
        body.scrollTop = body.scrollHeight;
    }

    async function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById('chatInput');
        const message = input.value.trim();
        
        if (!message) return;
        
        // Disable input
        input.value = '';
        input.disabled = true;
        
        // Show user message
        appendMessage(message, true);
        
        // Show typing indicator
        const indicator = document.getElementById('typingIndicator');
        indicator.style.display = 'block';
        document.getElementById('chatbotBody').scrollTop = document.getElementById('chatbotBody').scrollHeight;

        try {
            const response = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            indicator.style.display = 'none';
            
            if (data.success) {
                appendMessage(data.reply, false);
            } else {
                appendMessage('Maaf, saya tidak dapat memproses permintaan Anda saat ini.', false);
            }
        } catch (error) {
            indicator.style.display = 'none';
            appendMessage('Terjadi kesalahan koneksi.', false);
        }

        input.disabled = false;
        input.focus();
    }
</script>
