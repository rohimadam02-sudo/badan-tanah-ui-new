import Alpine from "alpinejs";

import "./asset-slider";
import "./hero-slider";
import "./chatbot";
import "./assets";
import "./admin-table"; // <-- TAMBAHKAN INI

window.Alpine = Alpine;

Alpine.start();

// =========================================================
// DARK MODE ADMIN
// =========================================================
document.addEventListener("DOMContentLoaded", function () {
  const button = document.getElementById("darkModeButton");
  const icon = document.getElementById("darkModeIcon");

  if (!button) return;

  // Cek status terakhir dari localStorage
  const savedMode = localStorage.getItem("adminDarkMode");

  if (savedMode === "true") {
    document.body.classList.add("dark-mode");
    if (icon) {
      icon.classList.remove("fa-moon");
      icon.classList.add("fa-sun");
    }
  }

  button.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
    const active = document.body.classList.contains("dark-mode");
    localStorage.setItem("adminDarkMode", active);

    if (icon) {
      if (active) {
        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");
      } else {
        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");
      }
    }
  });

});


document.addEventListener('alpine:init', () => {
  Alpine.store('notifications', {
    items: [],
    total: 0,
    pendingNews: 0,
    unreadContacts: 0,
    loading: true,

    async fetch() {
      this.loading = true;

      try {
        const response = await fetch('/admin/notifications?limit=5&ajax=1', {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        });

        if (!response.ok) {
          throw new Error('HTTP ' + response.status);
        }

        const data = await response.json();

        this.items = Array.isArray(data.notifications) ? data.notifications : [];
        this.total = data.total || 0;
        this.pendingNews = data.pending_news || 0;
        this.unreadContacts = data.unread_contacts || 0;
        this.loading = false;

        // Update badge
        const badge = document.querySelector('.notification-pulse');
        if (badge) {
          if (this.total > 0) {
            badge.textContent = this.total > 99 ? '99+' : this.total;
            badge.style.display = 'block';
          } else {
            badge.style.display = 'none';
          }
        }
      } catch (error) {
        console.error('Error fetching notifications:', error);
        this.items = [];
        this.total = 0;
        this.loading = false;
      }
    }
  });
});

// Panggil fetch saat halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
  setTimeout(() => {
    if (Alpine.$store.notifications) {
      Alpine.$store.notifications.fetch();
    }
  }, 1000);
});
