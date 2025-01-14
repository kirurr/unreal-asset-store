document.addEventListener('DOMContentLoaded', (e) => {
    const form = document.querySelector('form');
    const errorMessage = document.querySelector('#errorMessage');

    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => input.addEventListener('keyup', () => {
        const span = input.nextElementSibling;
        input.classList.remove('error');
        span.innerHTML = '';
        errorMessage.innerHTML = '';
    }));
})