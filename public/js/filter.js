const tombol = document.querySelectorAll('[data-filter]');
const baris = document.querySelectorAll('tbody tr[data-status]');

tombol.forEach((btn) => {
    btn.addEventListener('click', () => {
        const pilihan = btn.dataset.filter;

        tombol.forEach((b) => b.setAttribute('aria-pressed', String(b === btn)));
        baris.forEach((tr) => {
            tr.hidden = pilihan !== 'semua' && tr.dataset.status !== pilihan;
        });
    });
});
