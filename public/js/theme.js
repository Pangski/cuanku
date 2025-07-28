function setMetaColor(setting) {
    const metaThemeColor = document.querySelector('meta[name="theme-color"]');
    if (!metaThemeColor) return;

    let color = '#ffffff'; // default light

    if (setting === 'dark') {
        color = '#000000';
    } else if (setting === 'system') {
        color = window.matchMedia('(prefers-color-scheme: dark)').matches ? '#000000' : '#ffffff';
    }

    metaThemeColor.setAttribute('content', color);
}

function updateTheme() {
    const themes = ['light', 'dark', 'system'];
    const currentTheme = localStorage.getItem('current-theme') || 'system';

    // Hapus semua class terkait tema
    document.documentElement.classList.remove(...themes);

    // Tambahkan class sesuai tema
    if (currentTheme === 'system') {
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        document.documentElement.classList.add(systemPrefersDark ? 'dark' : 'light');
    } else {
        document.documentElement.classList.add(currentTheme);
    }

    setMetaColor(currentTheme);
}

// Jalankan saat halaman dimuat
updateTheme();

// Pantau perubahan tema sistem jika menggunakan 'system'
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (localStorage.getItem('current-theme') === 'system') {
        updateTheme(); // cukup panggil ulang
    }
});
