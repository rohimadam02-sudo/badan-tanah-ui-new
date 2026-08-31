document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('chatbot-toggle');
    const close = document.getElementById('chatbot-close');
    const windowChat = document.getElementById('chatbot-window');

    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');

    if (!toggle || !windowChat) {
        return;
    }


    // ==============================
    // OPEN CHAT
    // ==============================

    toggle.addEventListener('click', function () {

        windowChat.classList.toggle('active');

        if (windowChat.classList.contains('active')) {
            input.focus();
        }

    });


    // ==============================
    // CLOSE CHAT
    // ==============================

    close.addEventListener('click', function () {

        windowChat.classList.remove('active');

    });


    // ==============================
    // QUICK QUESTION
    // ==============================

    document.querySelectorAll(
        '.chatbot-quick button'
    ).forEach(function (button) {

        button.addEventListener('click', function () {

            const question =
                button.dataset.question;

            sendMessage(question);

        });

    });


    // ==============================
    // FORM
    // ==============================

    form.addEventListener('submit', function (event) {

        event.preventDefault();

        const question =
            input.value.trim();

        if (!question) {
            return;
        }

        sendMessage(question);

        input.value = '';

    });


    // ==============================
    // SEND MESSAGE
    // ==============================

    function sendMessage(question) {

        addMessage(
            question,
            'user'
        );

        setTimeout(function () {

            const answer =
                getAnswer(question);

            addMessage(
                answer,
                'bot'
            );

        }, 500);

    }


    // ==============================
    // ADD MESSAGE
    // ==============================

    function addMessage(text, type) {

        const message =
            document.createElement('div');

        message.className =
            `chat-message ${type}`;

        if (type === 'bot') {

            message.innerHTML = `
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>

                <div class="message-content">
                    <div class="message-bubble">
                        ${text}
                    </div>
                </div>
            `;

        } else {

            message.innerHTML = `
                <div class="message-content">
                    <div class="message-bubble">
                        ${text}
                    </div>
                </div>
            `;

        }

        messages.appendChild(message);

        messages.scrollTop =
            messages.scrollHeight;

    }


    // ==============================
    // FAQ ENGINE
    // ==============================

    function getAnswer(question) {

        const q =
            question.toLowerCase();


        if (
            q.includes('apa itu badan bank tanah') ||
            q.includes('bank tanah')
        ) {

            return `
                Badan Bank Tanah merupakan badan yang
                mengelola aset tanah negara untuk mendukung
                pengelolaan dan pemanfaatan tanah secara
                profesional dan berkelanjutan.
            `;

        }


        if (
            q.includes('aset persediaan') ||
            q.includes('persediaan tanah')
        ) {

            return `
                Aset Persediaan Tanah merupakan data aset
                tanah yang tersedia untuk dikelola dan
                dimanfaatkan sesuai dengan ketentuan
                yang berlaku.
                <br><br>

                Anda dapat melihat daftar aset pada menu
                <strong>Aset Persediaan Tanah</strong>.
            `;

        }


        if (
            q.includes('pemanfaatan') ||
            q.includes('manfaat tanah')
        ) {

            return `
                Informasi mengenai skema pemanfaatan aset
                tanah dapat dilihat melalui menu
                <strong>Pemanfaatan & Kerjasama</strong>.
            `;

        }


        if (
            q.includes('kerja sama') ||
            q.includes('kerjasama')
        ) {

            return `
                Informasi mengenai skema kerja sama
                pemanfaatan aset tanah tersedia pada
                halaman <strong>Pemanfaatan & Kerjasama</strong>.
            `;

        }


        if (
            q.includes('kontak') ||
            q.includes('hubungi')
        ) {

            return `
                Silakan gunakan halaman
                <strong>Kontak</strong> untuk mendapatkan
                informasi kontak resmi Badan Bank Tanah.
            `;

        }


        return `
            Maaf, saya belum menemukan jawaban
            untuk pertanyaan tersebut.
            <br><br>

            Silakan pilih salah satu pertanyaan yang
            tersedia atau gunakan halaman terkait
            untuk mendapatkan informasi lebih lengkap.
        `;

    }

});