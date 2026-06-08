import { $ } from "./elements.js";

$.addEventListener("DOMContentLoaded", () => {
  const filterButton = $.querySelector(".filter-button");
  const filterAside = $.querySelector("aside");

  if (!filterButton || !filterAside) {
    console.error("Elementos de filtro no encontrados");
    return;
  }

  filterButton.addEventListener("click", () => {
    filterAside.classList.toggle("active");
  });

  // Cerrar el filtro al hacer click fuera
  $.addEventListener("click", (e) => {
    if (!e.target.closest(".filter-button") && !e.target.closest("aside")) {
      filterAside.classList.remove("active");
    }
  });
});
