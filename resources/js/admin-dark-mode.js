document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('darkModeButton');
    const icon = document.getElementById('darkModeIcon');

    if (!button) {
        console.log('Tombol dark mode tidak ditemukan');
        return;
    }

    console.log('ADMIN DARK MODE JS BERHASIL DIMUAT');

    // Ambil status terakhir
    const savedMode = localStorage.getItem('adminDarkMode');

    if (savedMode === 'true') {
        document.body.classList.add('dark-mode');

        if (icon) {
            icon.classList.remove('fa-moon');
            icon.classList.add('fa-sun');
        }
    }

    button.addEventListener('click', function () {

        document.body.classList.toggle('dark-mode');

        const active = document.body.classList.contains('dark-mode');

        localStorage.setItem('adminDarkMode', active);

        if (icon) {

            if (active) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }

        }

        console.log('Dark Mode:', active);
        console.log('BODY:', document.body.className);
    });

});