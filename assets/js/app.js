const inicioBtn = document.querySelector(".navegacion .btn");
const fondo = document.querySelector(".fondo");
const cerrarBtn = document.querySelector(".icono-cerrar");
const registrarLink = document.querySelector(".registrar-link");
const loginLink = document.querySelector(".login-link");

inicioBtn.addEventListener("click", () => {
    fondo.classList.add("active-btn");
});

cerrarBtn.addEventListener("click", () => {
    fondo.classList.remove("active-btn");
});

registrarLink.addEventListener("click", () => {
    fondo.classList.add("active");
});

loginLink.addEventListener("click", () => {
    fondo.classList.remove("active");
});
