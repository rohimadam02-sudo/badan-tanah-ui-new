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
