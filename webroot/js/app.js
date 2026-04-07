/**
 * app.js — Online Paint Shop
 * Minimal vanilla JS for UI enhancements.
 */

document.addEventListener('DOMContentLoaded', () => {

    // Auto-hide flash messages after 4 seconds
    document.querySelectorAll('.message').forEach(msg => {
        setTimeout(() => {
            msg.style.transition = 'opacity .5s';
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        }, 4000);
    });

    // Quantity input: prevent exceeding max
    document.querySelectorAll('input[type="number"][max]').forEach(input => {
        input.addEventListener('change', () => {
            const max = parseInt(input.getAttribute('max'), 10);
            const min = parseInt(input.getAttribute('min') || '1', 10);
            if (parseInt(input.value, 10) > max) {
                input.value = max;
                alert(`Maximum available quantity is ${max}.`);
            }
            if (parseInt(input.value, 10) < min) {
                input.value = min;
            }
        });
    });

    // Payment method toggle: show account/card number field
    const paymentRadios = document.querySelectorAll('input[name="payment_type"]');
    const acctField = document.getElementById('acct-field');
    if (paymentRadios.length && acctField) {
        paymentRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                acctField.style.display = radio.value !== 'cash' ? 'block' : 'none';
            });
        });
    }

    // Confirm dialogs for destructive actions
    document.querySelectorAll('[data-confirm]').forEach(el => {
        el.addEventListener('click', e => {
            if (!confirm(el.dataset.confirm)) e.preventDefault();
        });
    });

});
