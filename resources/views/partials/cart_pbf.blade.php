{{-- Cart partial khusus halaman PBF --}}
{{-- Hapus opsi "Umum", default ke "Apotek" --}}
@include('partials.cart')

<script>
(function () {
    function initPbfCart() {
        const sel = document.getElementById('f_jenis');
        if (!sel) return;

        // Hapus opsi "Umum"
        for (let i = sel.options.length - 1; i >= 0; i--) {
            if (sel.options[i].value === 'umum') sel.remove(i);
        }

        // Set default ke Apotek
        sel.value = 'apotik';
    }

    // Patch openOrder agar selalu set default Apotek sebelum modal tampil
    const _origOpenOrder = window.openOrder;
    window.openOrder = function () {
        const sel = document.getElementById('f_jenis');
        if (sel && (!sel.value || sel.value === 'umum')) {
            sel.value = 'apotik';
        }
        if (typeof _origOpenOrder === 'function') _origOpenOrder();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPbfCart);
    } else {
        initPbfCart();
    }
})();
</script>
