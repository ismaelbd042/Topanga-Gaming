document.addEventListener("DOMContentLoaded", function () {
  mostrarVentanaModal();
  validarFormulariosAcceso();
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

function validarFormulariosAcceso() {
  // Obtención de elementos del formulario de inicio de sesión y registro
  let loginForm = document.getElementById("login");
  let registerForm = document.getElementById("registrar");

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
    let email = loginForm.querySelector("input[type='email']").value;
    let password = loginForm.querySelector("input[type='password']").value;
    let errorMessage = loginForm.querySelector(".error-message");

    let emailErrorIcon = document.querySelector(".email-error2");
    let passwordErrorIcon = document.querySelector(".password-error2");

    // If para comprobar si el email esta vacio
    if (email.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      emailErrorIcon.style.display = "block";
      return false;
    } else {
      emailErrorIcon.style.display = "none";
    }
    // if para comprobar si la contraseña esta vacia
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
    let username = registerForm.querySelector("input[type='text']").value;
    let email = registerForm.querySelector("input[type='email']").value;
    let password = registerForm.querySelector("input[type='password']").value;
    let errorMessage = registerForm.querySelector(".error-message-registro");

    let usernameErrorIcon = document.querySelector(".username-error");
    let emailErrorIcon = document.querySelector(".email-error");
    let passwordErrorIcon = document.querySelector(".password-error");

    // If para comprobar si el usuario esta vacio
    if (username.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      usernameErrorIcon.style.display = "block";
      return false;
    } else {
      usernameErrorIcon.style.display = "none";
    }
    // If para comprobar si el email esta vacio
    if (email.trim() === "") {
      errorMessage.textContent = "Por favor, completa todos los campos.";
      errorMessage.style.display = "block";
      emailErrorIcon.style.display = "block";
      return false;
    } else {
      emailErrorIcon.style.display = "none";
    }

    // If para comporbar si la contyraseña esta vacia
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

  // Función para validar la fortaleza de la contraseña
  function validatePassword(password) {
    let minLength = 8;
    let hasUpperCase = /[A-Z]/.test(password);
    let hasLowerCase = /[a-z]/.test(password);
    let hasNumbers = /\d/.test(password);

    return (
      password.length >= minLength && hasUpperCase && hasLowerCase && hasNumbers
    );
  }

  // Función para validar un correo electrónico con un patrón regex
  function validateEmail(email) {
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
  }
}
