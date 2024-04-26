// Función para procesar el inicio de sesión
function login(formLogin) {
    const formData = new FormData(formLogin);
  
    fetch("../php/login.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            window.location.href = "../Index/index.php"; // Redirecciona si el inicio de sesión fue exitoso
        } else {
            // Muestra el mensaje de error en el formulario
            const errorMessage = document.getElementById("mensaje-error-login");
            errorMessage.textContent = "Ha ocurrido un error";
            errorMessage.style.display = "block";
        }
    })
    .catch((error) => {
        console.error("Fetch error: ", error);
    });
}

// Función para procesar el inicio de sesión
function registro(formRegistro) {
    const formData = new FormData(formRegistro);
  
    fetch("../php/registro.php", {
        method: "POST",
        body: formData,
    })
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((data) => {
        if (data.success) {
            window.location.href = "../Index/index.php"; // Redirecciona si el inicio de sesión fue exitoso
        } else {
            // Muestra el mensaje de error en el formulario
            const errorMessage = document.getElementById("mensaje-error-registro");
            errorMessage.textContent = "Ha ocurrido un error";
            errorMessage.style.display = "block";
        }
    })
    .catch((error) => {
        console.error("Fetch error: ", error);
    });
}

