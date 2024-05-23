document.addEventListener("DOMContentLoaded", function () {
  mostrarVentanaModal();
  comprobarSesion();
  validarFormulariosAcceso();
  validadSesion();
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
  // Obtención de elementos del formulario de inicio de sesión
  let loginForm = document.getElementById("login");

  // Validación del formulario de inicio de sesión al enviar
  loginForm.addEventListener("submit", function (event) {
    if (!validateLoginForm()) {
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

  // Función para validar un correo electrónico con un patrón regex
  function validateEmail(email) {
    let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
  }
}

function validadSesion() {
  fetch("../php_acceso/verificar_sesion.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.sesion_activa) {
        // Si hay una sesión activa, ocultar botones de inicio de sesión y mostrar el otro menú
        document.getElementById("indexNoIniciadaSesion").style.display = "none";
        document.getElementById("indexSiIniciadaSesion").style.display =
          "block";

        // Cambiar el texto para mostrar el nombre de usuario
        document.getElementById("nombreSesionIniciada").textContent =
          data.nombre_usuario;
      } else {
        // Si no hay sesión activa, mostrar botones de inicio de sesión y ocultar el otro menú
        document.getElementById("indexNoIniciadaSesion").style.display =
          "block";
        document.getElementById("indexSiIniciadaSesion").style.display = "none";
      }
    })
    .catch((error) => console.error("Error:", error));
}

function comprobarSesion() {
  fetch("../php_acceso/verificar_sesion.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.sesion_activa) {
        document.getElementById("enlace_chat").href =
          "../chat_mensajes/chat.php";
      } else {
        document
          .getElementById("enlace_chat")
          .addEventListener("click", function (event) {
            event.preventDefault();
            mostrarVentanaModal();
            mostrarLogin();
          });
      }
    })
    .catch((error) => {
      console.error("Error al verificar la sesión:", error);
    });
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
