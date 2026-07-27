document.addEventListener("DOMContentLoaded", function() {
  const selectTalle = document.getElementById("talle");
  const inputCantidad = document.getElementById("cantidad");
  const stockInfo = document.getElementById("stock-info");
  const btnAgregar= document.getElementById("btn-agregar");

  if (!selectTalle) return;

  selectTalle.addEventListener("change", function() {
    const selectedOption = selectTalle.options[selectTalle.selectedIndex];
    const stock = parseInt(selectedOption.getAttribute("data-stock"), 10);

    if (!selectTalle.value) {
      stockInfo.textContent = "";
      inputCantidad.disabled = true;
      btnAgregar.disabled = true;
      return;
    }

    stockInfo.textContent = `Stock: ${stock} unidades`;

    inputCantidad.disabled = false;
    inputCantidad.max = stock;
    inputCantidad.value = 1;

    btnAgregar.disabled = false;
  });

  inputCantidad.addEventListener("input", function() {
    const max = parseInt(inputCantidad.max, 10);
    if (max && parseInt(inputCantidad.value, 10) > max) {
      inputCantidad.value = max;
    }
  })
})