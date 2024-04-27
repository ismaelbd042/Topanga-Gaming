// Función para procesar el inicio de sesión
function registro(formRegistro) {
  const formData = new FormData(formRegistro);

  fetch("../php_acceso/registro.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.success) {
        window.location.href = "..Indexindex.php"; // Redirecciona si el inicio de sesión fue exitoso
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

// Función para validar que el nombre de usuario que no este vacio
function comprobarInputUsuarioRegistro() {
  let registerForm = document.getElementById("registrar");
  let inputUsername = registerForm.querySelector("input[type='text']").value;
  let usernameErrorIcon = document.querySelector(".username-error");
  let errorMessage = registerForm.querySelector(".error-message-registro");

  // If para comprobar si el usuario está vacío
  if (inputUsername.trim() === "") {
    errorMessage.textContent = "Por favor, completa todos los campos.";
    errorMessage.style.display = "block";
    usernameErrorIcon.style.display = "block";
    return false;
  } else {
    usernameErrorIcon.style.display = "none";
    return true;
  }
}

// Función para validar que el nombre de usuario no existe
async function comprobarUsuarioRegistro() {
  let registerForm = document.getElementById("registrar");
  let username = document.getElementById("usernameRegistro").value;
  let usernameErrorIcon = document.querySelector(".username-error");
  let errorMessage = registerForm.querySelector(".error-message-registro");

  // Realizar la solicitud fetch para verificar el usuario
  return fetch("../php_acceso/verificar_usuario_registro.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ username: username }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.exists) {
        // El nombre de usuario está en uso
        errorMessage.textContent = "Nombre de usuario en uso";
        errorMessage.style.display = "block";
        usernameErrorIcon.style.display = "block";
        return true;
      } else {
        // El nombre de usuario no está en uso
        errorMessage.textContent = "";
        errorMessage.style.display = "none";
        usernameErrorIcon.style.display = "none";
        return false;
      }
    })
    .catch((error) => {
      console.error("Error al verificar el usuario:", error);
      errorMessage.textContent =
        "Error al verificar el usuario. Por favor, inténtalo de nuevo más tarde.";
      errorMessage.style.display = "block";
      return true;
    });
}

// Función para validar que el email que no este vacio
function comprobarInputEmailRegistro() {
  let registerForm = document.getElementById("registrar");
  let emailErrorIcon = registerForm.querySelector(".email-error");
  let errorMessage = registerForm.querySelector(".error-message-registro");
  let emailInput = registerForm.querySelector("input[type='email']");
  let email = emailInput.value;

  // Función para validar un correo electrónico con un patrón regex
  function validateEmail(email) {
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
  }

  // If para comprobar si el email está vacío
  if (email.trim() === "") {
    errorMessage.textContent = "Por favor, completa todos los campos.";
    errorMessage.style.display = "block";
    emailErrorIcon.style.display = "block";
    return false;
  }

  if (!validateEmail(email)) {
    errorMessage.textContent =
      "Por favor, introduce un correo electrónico válido.";
    errorMessage.style.display = "block";
    emailErrorIcon.style.display = "block";
    return false;
  } else {
    emailErrorIcon.style.display = "none";
    return true;
  }
}

// Función para validar que el email no existe
async function comprobarEmailRegistro() {
  let registerForm = document.getElementById("registrar");
  let emailInput = registerForm.querySelector("input[type='email']");
  let email = emailInput.value;
  let emailErrorIcon = registerForm.querySelector(".email-error");
  let errorMessage = registerForm.querySelector(".error-message-registro");

  // Realizar la solicitud fetch para verificar el correo electrónico
  return fetch("../php_acceso/verificar_email_registro.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ email: email }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.exists) {
        // El correo electrónico está en uso
        errorMessage.textContent = "E-mail en uso";
        errorMessage.style.display = "block";
        emailErrorIcon.style.display = "block";
        return true;
      } else {
        // El correo electrónico no está en uso
        errorMessage.textContent = "";
        errorMessage.style.display = "none";
        emailErrorIcon.style.display = "none";
        return false;
      }
    })
    .catch((error) => {
      console.error("Error al verificar el correo:", error);
      errorMessage.textContent =
        "Error al verificar el correo. Por favor, inténtalo de nuevo más tarde.";
      errorMessage.style.display = "block";
      return true;
    });
}

// Función para validar contraseña
function comprobarPasswordRegistro() {
  let registerForm = document.getElementById("registrar");
  let passwordInput = registerForm.querySelector("input[type='password']");
  let password = passwordInput.value;
  let errorMessage = registerForm.querySelector(".error-message-registro");
  let passwordErrorIcon = registerForm.querySelector(".password-error");

  // Función para validar la fortaleza de la contraseña
  function isPasswordStrong(password) {
    let minLength = 8;
    let hasUpperCase = /[A-Z]/.test(password);
    let hasLowerCase = /[a-z]/.test(password);
    let hasNumbers = /\d/.test(password);

    return (
      password.length >= minLength && hasUpperCase && hasLowerCase && hasNumbers
    );
  }

  // If para comporbar si la contraseña esta vacia
  if (password.trim() === "") {
    errorMessage.textContent = "Por favor, completa todos los campos.";
    errorMessage.style.display = "block";
    passwordErrorIcon.style.display = "block";
    return false;
  } else {
    passwordErrorIcon.style.display = "none";
  }

  // Validar la contraseña
  if (!isPasswordStrong(password)) {
    errorMessage.textContent =
      "La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula y un número.";
    errorMessage.style.display = "block";
    passwordErrorIcon.style.display = "block";
    return false;
  } else {
    passwordErrorIcon.style.display = "none";
  }

  // Limpiar el mensaje de error si la contraseña es válida
  errorMessage.style.display = "none";
  return true;
}

// Función para validar registro
async function validarFormularioRegistro() {
  let registerForm = document.getElementById("registrar");
  registerForm.addEventListener("submit", async function (event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    // Comprobar cada campo y detener la validación si alguno falla
    if (
      (await comprobarUsuarioRegistro()) ||
      !comprobarInputUsuarioRegistro() ||
      (await comprobarEmailRegistro()) ||
      !comprobarInputEmailRegistro() ||
      !comprobarPasswordRegistro()
    ) {
      console.log("prevent");
      return false; // Detener la ejecución si algún campo no es válido
    }

    // Si todos los campos son válidos, puedes enviar el formulario aquí
    registerForm.submit();
  });
}

// Función para mostrar la contraseña en el campo de contraseña
function mostrarContraseña() {
  var contraseñaInput = document.getElementById("passwordInput");
  var icono = document.getElementById("ojoVerContraseña");

  if (contraseñaInput.type === "password") {
    contraseñaInput.type = "text";
    icono.classList.remove("fa-eye");
    icono.classList.add("fa-eye-slash");
  } else {
    contraseñaInput.type = "password";
    icono.classList.remove("fa-eye-slash");
    icono.classList.add("fa-eye");
  }
}

// Función para mostrar la contraseña en el campo de contraseña
function mostrarContraseña2() {
  var contraseñaInput = document.getElementById("passwordInput2");
  var icono = document.getElementById("ojoVerContraseña2");

  if (contraseñaInput.type === "password") {
    contraseñaInput.type = "text";
    icono.classList.remove("fa-eye");
    icono.classList.add("fa-eye-slash");
  } else {
    contraseñaInput.type = "password";
    icono.classList.remove("fa-eye-slash");
    icono.classList.add("fa-eye");
  }
}
