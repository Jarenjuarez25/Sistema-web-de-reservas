/* JavaScript */
window.addEventListener("DOMContentLoaded", () => {
  showLoader();
});

window.addEventListener("load", () => {
  setTimeout(() => {
    hideLoader();
  }, 1000);
});

const loader = document.getElementById("loaderPagina");
const body = document.body;

const showLoader = () => {
  loader.classList.add("show_loader");
  body.classList.add("body-loading");
}

const hideLoader = () => {
  loader.classList.remove("show_loader");
  body.classList.remove("body-loading");
}
