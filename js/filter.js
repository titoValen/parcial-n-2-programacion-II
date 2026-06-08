import { $ } from "./elements.js";

$.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = $.querySelector(".filter-toggle-button");
  const panel = $.querySelector(".filter-panel");
  const itemsCategory = $.querySelectorAll(".filter-item-category");
  const itemsBrand = $.querySelectorAll(".filter-item-brand");
  const cards = $.querySelectorAll(".card");

  if (!toggleBtn || !panel) return;

  // Estado activo de los filtros
  let filtroCategoria = "todos";
  let filtroBrand = "todos";

  //Abrir / cerrar panel
  toggleBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    panel.classList.toggle("active");
  });

  $.addEventListener("click", (e) => {
    if (
      !e.target.closest(".filter-toggle-button") &&
      !e.target.closest(".filter-panel")
    ) {
      panel.classList.remove("active");
    }
  });

  $.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      panel.classList.remove("active");
      toggleBtn.focus();
    }
  });

  //Lógica de filtrado
  function aplicarFiltros() {
    cards.forEach((card) => {
      const categoria = card.dataset.category;
      const marca = card.dataset.brand;

      const coincideCategoria =
        filtroCategoria === "todos" || categoria === filtroCategoria;
      const coincideMarca = filtroBrand === "todos" || marca === filtroBrand;

      card.style.display = coincideCategoria && coincideMarca ? "" : "none";
    });
  }

  //Selección de categoría
  itemsCategory.forEach((item) => {
    item.addEventListener("click", () => {
      // Quitar active de todos los items de categoría
      itemsCategory.forEach((i) => i.classList.remove("active"));
      // Poner active en el clickeado
      item.classList.add("active");

      filtroCategoria = item.dataset.value;
      aplicarFiltros();
    });
  });

  //Selección de marca
  itemsBrand.forEach((item) => {
    item.addEventListener("click", () => {
      itemsBrand.forEach((i) => i.classList.remove("active"));
      item.classList.add("active");

      filtroBrand = item.dataset.value;
      aplicarFiltros();
    });
  });
});
