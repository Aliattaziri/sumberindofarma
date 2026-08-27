

<?php echo $__env->make('partials.cart', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
<?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\partials\cart_pbf.blade.php ENDPATH**/ ?>