<div id="chatbot-widget">

{{-- tombol --}}
    <button        
        id="chatbot-toggle"
        type="button"
        aria-label="Buka chatbot">

        <img
            src="{{ asset('images/logo.chatbot.png') }}"
            alt="Chatbot">

    </button>


    <!-- CHAT WINDOW -->
    <div id="chatbot-window" class="chatbot-window">

        <!-- HEADER -->
        <div class="chatbot-header">

            <div class="chatbot-header-info">

                <div class="chatbot-avatar">
                    <i class="fas fa-robot"></i>
                </div>

                <div>
                    <h3>Bantuan Badan Bank Tanah</h3>

                    <div class="chatbot-status">
                        <span></span>
                        <small>Siap membantu</small>
                    </div>
                </div>

            </div>

            <button
                id="chatbot-close"
                type="button"
                class="chatbot-close">

                <i class="fas fa-times"></i>

            </button>

        </div>


        <!-- MESSAGES -->
        <div id="chatbot-messages" class="chatbot-messages">

            <div class="chat-message bot">

                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>

                <div class="message-content">

                    <div class="message-bubble">
                        Halo 👋
                        <br>
                        Saya asisten Badan Bank Tanah.
                        Ada yang bisa saya bantu?
                    </div>

                </div>

            </div>


            <!-- QUICK QUESTIONS -->

            <div class="chatbot-quick">

                <button
                    type="button"
                    data-question="Apa itu Badan Bank Tanah?">
                    Apa itu Badan Bank Tanah?
                </button>

                <button
                    type="button"
                    data-question="Apa itu aset persediaan tanah?">
                    Aset persediaan tanah
                </button>

                <button
                    type="button"
                    data-question="Bagaimana pemanfaatan tanah?">
                    Pemanfaatan tanah
                </button>

                <button
                    type="button"
                    data-question="Bagaimana cara kerja sama dengan Badan Bank Tanah?">
                    Kerja sama
                </button>

                <button
                    type="button"
                    data-question="Bagaimana cara menghubungi Badan Bank Tanah?">
                    Kontak Badan Bank Tanah
                </button>

            </div>

        </div>


        <!-- INPUT -->
        <form
            id="chatbot-form"
            class="chatbot-input-area">

            <input
                type="text"
                id="chatbot-input"
                placeholder="Ketik pertanyaan..."
                autocomplete="off">

            <button
                type="submit"
                aria-label="Kirim">

                <i class="fas fa-paper-plane"></i>

            </button>

        </form>

    </div>

</div>