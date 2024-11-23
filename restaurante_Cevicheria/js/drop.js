let navbar = document.querySelector(".navbar");

let usuarioToggle = document.querySelector(".usuario-toggle");
let usuarioDropdown = document.querySelector(".usuario-dropdown");


usuarioToggle.addEventListener("click", function (e) {
    e.preventDefault();
    usuarioDropdown.classList.toggle("show");
    // Ocultar el search box si está visible
    if (navbar.classList.contains("showInput")) {
        navbar.classList.remove("showInput");
        searchBox.classList.replace("bx-x", "bx-search");
    }
});

// Cerrar el dropdown si se hace clic fuera de él
document.addEventListener("click", function (e) {
    if (!usuarioToggle.contains(e.target) && !usuarioDropdown.contains(e.target)) {
        usuarioDropdown.classList.remove("show");
    }
});
