// =========================================================
// ADMIN TABLE UTILITY
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
  // =========================================================
  // 1. COLUMN SORTING
  // =========================================================
  document.querySelectorAll(".sortable-table").forEach((table) => {
    const headers = table.querySelectorAll("th[data-sort]");

    headers.forEach((header) => {
      header.style.cursor = "pointer";
      header.addEventListener("click", function () {
        const column = this.dataset.sort;
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const currentDir = this.dataset.sortDir || "asc";
        const newDir = currentDir === "asc" ? "desc" : "asc";

        // Reset all headers
        headers.forEach((h) => {
          h.dataset.sortDir = "";
          h.querySelector(".sort-icon")?.remove();
        });

        // Set current header
        this.dataset.sortDir = newDir;

        // Add sort icon
        const icon = document.createElement("span");
        icon.className = "sort-icon ml-1 text-[10px]";
        icon.textContent = newDir === "asc" ? "↑" : "↓";
        this.appendChild(icon);

        // Sort rows
        const sortedRows = rows.sort((a, b) => {
          const aVal =
            a
              .querySelector(`td[data-column="${column}"]`)
              ?.textContent?.trim() || "";
          const bVal =
            b
              .querySelector(`td[data-column="${column}"]`)
              ?.textContent?.trim() || "";

          // Try numeric comparison
          const aNum = parseFloat(aVal.replace(/[^0-9.-]/g, ""));
          const bNum = parseFloat(bVal.replace(/[^0-9.-]/g, ""));

          if (!isNaN(aNum) && !isNaN(bNum)) {
            return newDir === "asc" ? aNum - bNum : bNum - aNum;
          }

          return newDir === "asc"
            ? aVal.localeCompare(bVal, undefined, { sensitivity: "base" })
            : bVal.localeCompare(aVal, undefined, { sensitivity: "base" });
        });

        // Re-append sorted rows
        sortedRows.forEach((row) => tbody.appendChild(row));
      });
    });
  });

  // =========================================================
  // 2. BULK ACTION - SELECT ALL
  // =========================================================
  document.querySelectorAll(".bulk-select-all").forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      const table = this.closest("table");
      const checkboxes = table.querySelectorAll(".bulk-item");
      checkboxes.forEach((cb) => (cb.checked = this.checked));
      updateBulkActions(table);
    });
  });

  document.querySelectorAll(".bulk-item").forEach((checkbox) => {
    checkbox.addEventListener("change", function () {
      const table = this.closest("table");
      updateBulkActions(table);
    });
  });

  function updateBulkActions(table) {
    const checkboxes = table.querySelectorAll(".bulk-item");
    const checked = table.querySelectorAll(".bulk-item:checked");
    const selectAll = table.querySelector(".bulk-select-all");
    const actionBar = table
      .closest(".table-container")
      ?.querySelector(".bulk-action-bar");
    const countEl = table
      .closest(".table-container")
      ?.querySelector(".bulk-count");

    // Update select all
    if (selectAll) {
      const allChecked =
        checkboxes.length > 0 && checkboxes.length === checked.length;
      selectAll.checked = allChecked;
      selectAll.indeterminate =
        checked.length > 0 && checked.length < checkboxes.length;
    }

    // Update action bar
    if (actionBar) {
      if (checked.length > 0) {
        actionBar.style.display = "flex";
        if (countEl) countEl.textContent = checked.length;
      } else {
        actionBar.style.display = "none";
      }
    }
  }

  // =========================================================
  // 3. BULK ACTION - DELETE SELECTED
  // =========================================================
  document.querySelectorAll(".bulk-delete-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const table = this.closest(".table-container")?.querySelector("table");
      if (!table) return;

      const checkboxes = table.querySelectorAll(".bulk-item:checked");
      const ids = Array.from(checkboxes).map((cb) => cb.value);

      if (ids.length === 0) {
        showToast("Pilih minimal 1 item untuk dihapus.", "warning");
        return;
      }

      if (
        !confirm(
          `Apakah Anda yakin ingin menghapus ${ids.length} item yang dipilih?`,
        )
      ) {
        return;
      }

      const url = this.dataset.url || this.closest("form")?.action;
      if (!url) {
        showToast("URL tidak ditemukan.", "error");
        return;
      }

      // Tampilkan loading
      this.disabled = true;
      this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN":
            document.querySelector('meta[name="csrf-token"]')?.content || "",
        },
        body: JSON.stringify({ ids: ids }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            showToast(data.message || "Item berhasil dihapus!", "success");
            // Reload setelah 1.5 detik
            setTimeout(() => location.reload(), 1500);
          } else {
            showToast(data.message || "Gagal menghapus item.", "error");
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-trash"></i> Hapus Terpilih';
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showToast("Terjadi kesalahan saat menghapus.", "error");
          this.disabled = false;
          this.innerHTML = '<i class="fas fa-trash"></i> Hapus Terpilih';
        });
    });
  });

  // =========================================================
  // 4. TOAST NOTIFICATION (Fallback)
  // =========================================================
  function showToast(message, type = "success") {
    let container = document.getElementById("toastContainer");
    if (!container) {
      container = document.createElement("div");
      container.id = "toastContainer";
      container.className =
        "fixed top-20 right-4 z-[99999] space-y-3 max-w-sm w-full";
      document.body.appendChild(container);
    }

    const colors = {
      success: "bg-green-50 border-green-400 text-green-800",
      error: "bg-red-50 border-red-400 text-red-800",
      warning: "bg-yellow-50 border-yellow-400 text-yellow-800",
      info: "bg-blue-50 border-blue-400 text-blue-800",
    };
    const icons = {
      success: "fa-check-circle",
      error: "fa-exclamation-circle",
      warning: "fa-triangle-exclamation",
      info: "fa-circle-info",
    };

    const toast = document.createElement("div");
    toast.className = `flex items-start gap-3 p-4 border rounded-xl shadow-lg ${colors[type] || colors.success} animate-slide-in`;
    toast.innerHTML = `
            <i class="fas ${icons[type] || icons.success} text-lg mt-0.5"></i>
            <div class="flex-1 text-sm font-medium">${message}</div>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        `;
    container.appendChild(toast);

    setTimeout(() => {
      toast.style.opacity = "0";
      toast.style.transform = "translateX(100px)";
      toast.style.transition = "all 0.3s ease";
      setTimeout(() => toast.remove(), 300);
    }, 5000);
  }
});
