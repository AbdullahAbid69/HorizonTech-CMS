document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    const fields = form.querySelectorAll('input, select');

    fields.forEach((field, index) => {
        field.addEventListener('blur', () => {
            validateField(field);
        });

        if (index < fields.length - 1) {
            fields[index + 1].addEventListener('mouseover', () => {
                validateField(field);
            });
        }
    });

    function validateField(field) {
        const errorMessage = document.createElement('div');
        errorMessage.className = 'error-message';
        errorMessage.style.color = 'red';
        errorMessage.style.fontSize = '0.9rem';
        errorMessage.style.marginTop = '5px';

        // Remove existing error message
        const existingError = field.parentElement.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        if (!field.value.trim()) {
            errorMessage.textContent = `${field.name.charAt(0).toUpperCase() + field.name.slice(1)} is required.`;
            field.parentElement.appendChild(errorMessage);
        } else {
            if (field.name === 'email' && !validateEmail(field.value)) {
                errorMessage.textContent = 'Please enter a valid email address.';
                field.parentElement.appendChild(errorMessage);
            }
        }
    }

    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});