let searchBox = document.querySelector(".search-box .bx-search");
let searchForm = document.getElementById("search-form");
let searchInput = document.querySelector(".search-box input[name='search']");
let searchContainer = document.querySelector(".search-box");

searchBox.addEventListener("click", () => {
  navbar.classList.toggle("showInput");
  if (navbar.classList.contains("showInput")) {
    searchBox.classList.replace("bx-search", "bx-x");
  } else {
    searchBox.classList.replace("bx-x", "bx-search");
    clearSearchInput();
  }
});


searchInput.addEventListener("keypress", function (e) {
  if (e.key === "Enter") {
    searchForm.submit();
  }
});


function clearSearchInput() {
  searchInput.value = "";
}


document.addEventListener("click", function (e) {
  if (!searchContainer.contains(e.target)) {
    navbar.classList.remove("showInput");
    searchBox.classList.replace("bx-x", "bx-search");
    clearSearchInput();
  }
});
