import { $ } from "./elements.js";

// Funcionalidad para mostrar/ocultar el filtro
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

  $.addEventListener("click", (e) => {
    if (!e.target.closest(".filter-button") && !e.target.closest("aside")) {
      filterAside.classList.remove("active");
    }
  });
});

// Funcionalidad para seleccionar categorías y marcas
$.addEventListener("DOMContentLoaded", () => {
  const listItemsCategory = $.querySelectorAll(".filter-item-category");
  const listItemsBrand = $.querySelectorAll(".filter-item-brand");

  listItemsCategory.forEach((item) => {
    item.addEventListener("click", () => {
      if (item.classList.contains("active")) {
        item.classList.remove("active");
      } else {
        item.classList.toggle("active");
      }
    });
  });

  listItemsBrand.forEach((item) => {
    item.addEventListener("click", () => {
      if (item.classList.contains("active")) {
        item.classList.remove("active");
      } else {
        item.classList.toggle("active");
      }
    });
  });
});
