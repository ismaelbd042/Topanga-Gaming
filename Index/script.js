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
