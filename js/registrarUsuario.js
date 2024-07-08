document.getElementById('registerForm').addEventListener('submit', function(event) {
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        event.preventDefault();
        alert('Las contraseñas no coinciden');
    }
});

// Función para obtener parámetros de la URL
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1].replace(/\+/g, ' '));
        }
    }
    return false;
}

// Mostrar mensajes de error o éxito
document.addEventListener('DOMContentLoaded', function () {
    var error = getUrlParameter('error');
    var success = getUrlParameter('success');

    if (error) {
        alert(error);
        var registerModal = new bootstrap.Modal(document.getElementById('registerModal'), {});
        registerModal.show();
    }

    if (success) {
        alert(success);
    }
});