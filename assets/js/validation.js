// Form Validation Functions
const validateForm = (formElement) => {
    let isValid = true;
    const inputs = formElement.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            showError(input, 'This field is required');
            isValid = false;
        } else {
            clearError(input);
        }
    });

    return isValid;
};

const showError = (input, message) => {
    const formGroup = input.closest('.form-group');
    const errorDiv = formGroup.querySelector('.error-message') || 
                    document.createElement('div');
    
    errorDiv.className = 'error-message text-danger small mt-1';
    errorDiv.textContent = message;
    
    if (!formGroup.querySelector('.error-message')) {
        formGroup.appendChild(errorDiv);
    }
    
    input.classList.add('is-invalid');
};

const clearError = (input) => {
    const formGroup = input.closest('.form-group');
    const errorDiv = formGroup.querySelector('.error-message');
    
    if (errorDiv) {
        errorDiv.remove();
    }
    
    input.classList.remove('is-invalid');
};

// Number Format Function
const formatCurrency = (number) => {
    return '৳' + number.toLocaleString('en-BD');
};

// Date Format Function
const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-BD', options);
};