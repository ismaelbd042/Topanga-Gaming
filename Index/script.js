document.addEventListener("DOMContentLoaded", function () {
  mostrarVentanaModal();
});

function mostrarVentanaModal() {
  // Obtener la ventana modal y el checkbox
  let modal = document.querySelector(".mainVentanaModal");
  let chkVentanaModal = document.getElementById("chkVentanaModal");
  let overlay = document.querySelector(".overlay");

  // Obtener los botones de inicio de sesión y registro
  let btnIniciarSesion = document.querySelector(".iniciarSesion");
  let btnRegistrarse = document.querySelector(".registrarse");

  // Función para cambiar la ventana modal al estado de inicio de sesión
  function mostrarLogin() {
    modal.style.display = "block";
    overlay.style.display = "block";
    setTimeout(function () {
      modal.style.transform = "translate(-50%, -50%)"; // Cambiar la transformación para deslizarse desde abajo
    }, 100); // Pequeña demora antes de aplicar la transformación
    chkVentanaModal.checked = true;
  }

  // Función para cambiar la ventana modal al estado de registro
  function mostrarSignUp() {
    modal.style.display = "block";
    overlay.style.display = "block";
    setTimeout(function () {
      modal.style.transform = "translate(-50%, -50%)"; // Cambiar la transformación para deslizarse desde abajo
    }, 100); // Pequeña demora antes de aplicar la transformación
    chkVentanaModal.checked = false;
  }

  // Función para cerrar la ventana modal
  function ocultarVentanaModal() {
    modal.style.transform = "translate(-50%, 100%)";
    setTimeout(function () {
      modal.style.display = "none";
    }, 500);
    overlay.style.display = "none";
  }

  // Agregar eventos de clic a los botones
  btnIniciarSesion.addEventListener("click", mostrarLogin);
  btnRegistrarse.addEventListener("click", mostrarSignUp);
  overlay.addEventListener("click", ocultarVentanaModal);
}

// Evento que se dispara cuando el DOM está completamente cargado
document.addEventListener("DOMContentLoaded", function () {
  // Obtención de elementos del formulario de inicio de sesión y registro
  var loginForm = document.getElementById("login");
  var registerForm = document.getElementById("registrar");

  // Validación del formulario de inicio de sesión al enviar
  loginForm.addEventListener("submit", function (event) {
    if (!validateLoginForm()) {
      event.preventDefault();
    }
  });

  // Validación del formulario de registro al enviar
  registerForm.addEventListener("submit", function (event) {
    if (!validateRegisterForm()) {
      event.preventDefault();
    }
  });

  // Función para validar el formulario de inicio de sesión
  function validateLoginForm() {
    var email = loginForm.querySelector("input[type='email']").value;
    var password = loginForm.querySelector("input[type='password']").value;
    var errorMessage = loginForm.querySelector(".error-message");

    var emailErrorIcon = document.querySelector(".email-error2");
    var passwordErrorIcon = document.querySelector(".password-error2");

    if (email.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      emailErrorIcon.style.display = "block";
      return false;
    } else {
      emailErrorIcon.style.display = "none";
    }

    if (password.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      passwordErrorIcon.style.display = "block";
      return false;
    } else {
      passwordErrorIcon.style.display = "none";
    }

    // Verificación por si el email no es valido
    if (!validateEmail(email)) {
      errorMessage.textContent =
        "Por favor, introduce un correo electrónico válido.";
      errorMessage.style.display = "block";
      emailErrorIcon.style.display = "block";
      return false;
    } else {
      emailErrorIcon.style.display = "none";
    }

    // Mensaje de error
    errorMessage.style.display = "none";
    return true;
  }

  // Función para validar el formulario de registro
  function validateRegisterForm() {
    var username = registerForm.querySelector("input[type='text']").value;
    var email = registerForm.querySelector("input[type='email']").value;
    var password = registerForm.querySelector("input[type='password']").value;
    var errorMessage = registerForm.querySelector(".error-message-registro");

    var usernameErrorIcon = document.querySelector(".username-error");
    var emailErrorIcon = document.querySelector(".email-error");
    var passwordErrorIcon = document.querySelector(".password-error");

    if (username.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      usernameErrorIcon.style.display = "block";
      return false;
    } else {
      usernameErrorIcon.style.display = "none";
    }

    if (email.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      emailErrorIcon.style.display = "block";
      return false;
    } else {
      emailErrorIcon.style.display = "none";
    }

    if (password.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      passwordErrorIcon.style.display = "block";
      return false;
    } else {
      passwordErrorIcon.style.display = "none";
    }

    // Verificación por si el email no es valido
    if (!validateEmail(email)) {
      errorMessage.textContent =
        "Por favor, introduce un correo electrónico válido.";
      errorMessage.style.display = "block";
      emailErrorIcon.style.display = "block";
      return false;
    } else {
      emailErrorIcon.style.display = "none";
    }

    // Formulario para validar la contraseña, tiene que tener los requerimientos siguientes en la funcion validate
    if (!validatePassword(password)) {
      errorMessage.textContent =
        "La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número.";
      errorMessage.style.display = "block";
      passwordErrorIcon.style.display = "block";
      return false;
    } else {
      passwordErrorIcon.style.display = "none";
    }

    // Mensaje de error
    errorMessage.style.display = "none";
    return true;
  }
});

// Función para validar la fortaleza de la contraseña
function validatePassword(password) {
  var minLength = 8;
  var hasUpperCase = /[A-Z]/.test(password);
  var hasLowerCase = /[a-z]/.test(password);
  var hasNumbers = /\d/.test(password);

  return (
    password.length >= minLength && hasUpperCase && hasLowerCase && hasNumbers
  );
}

// Función para validar un correo electrónico con un patrón regex
function validateEmail(email) {
  var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  return emailPattern.test(email);
}
