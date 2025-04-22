// Kapcsolat űrlap validációja
function validateForm() {
    // Formok kiválasztása
    const form = document.getElementById('kapcsolatForm');
    if (!form) return true; // Ha nincs form, nem csinálunk semmit
    
    // Mezők kiválasztása
    const nevInput = document.getElementById('nev');
    const emailInput = document.getElementById('email');
    const uzenetInput = document.getElementById('uzenet');
    
    // Hibaüzenetek törlése
    clearErrors();
    
    // Validáció
    let isValid = true;
    
    // Név ellenőrzése (min. 5 karakter)
    if (nevInput.value.trim().length < 5) {
        showError(nevInput, 'A név legalább 5 karakter hosszú legyen!');
        isValid = false;
    }
    
    // Email ellenőrzése
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(emailInput.value)) {
        showError(emailInput, 'Kérjük, adjon meg egy érvényes email címet!');
        isValid = false;
    }
    
    // Üzenet ellenőrzése (nem lehet üres)
    if (uzenetInput.value.trim() === '') {
        showError(uzenetInput, 'Az üzenet mező nem lehet üres!');
        isValid = false;
    }
    
    return isValid;
}

// Hibaüzenet megjelenítése
function showError(input, message) {
    const formGroup = input.closest('.form-group');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'invalid-feedback';
    errorDiv.textContent = message;
    formGroup.appendChild(errorDiv);
    input.classList.add('is-invalid');
}

// Hibaüzenetek törlése
function clearErrors() {
    const invalidInputs = document.querySelectorAll('.is-invalid');
    const errorMessages = document.querySelectorAll('.invalid-feedback');
    
    invalidInputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    errorMessages.forEach(div => {
        div.remove();
    });
}

// Eseménykezelő inicializálása a dokumentum betöltésekor
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('kapcsolatForm');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!validateForm()) {
                event.preventDefault();
            }
        });
    }
});
