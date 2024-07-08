document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting the default way

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('error-message');

    if (!email || !password) {
        errorMessage.textContent = 'Por favor, rellena todos los campos.';
        errorMessage.style.display = 'block';
        return;
    }

    // AJAX request to send form data to the server for validation
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                window.location.href = 'index.php'; // Redirigir a la página deseada
            } else {
                errorMessage.textContent = response.message;
                errorMessage.style.display = 'block';
            }
        } else {
            errorMessage.textContent = 'Hubo un problema con la solicitud. Inténtalo de nuevo más tarde.';
            errorMessage.style.display = 'block';
        }
    };
    xhr.send('email=' + encodeURIComponent(email) + '&password=' + encodeURIComponent(password));
});
