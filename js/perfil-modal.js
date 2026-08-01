document.addEventListener("DOMContentLoaded", function () {
  const modals = {
    edit: document.getElementById("perfil-edit-modal"),
    delete: document.getElementById("perfil-delete-modal"),
  };

  document
    .querySelectorAll("[data-perfil-modal-open]")
    .forEach(function (trigger) {
      trigger.addEventListener("click", function () {
        const modal = modals[trigger.dataset.perfilModalOpen];
        if (modal && typeof modal.showModal === "function") {
          modal.showModal();
        }
      });
    });

  document
    .querySelectorAll("[data-perfil-modal-close]")
    .forEach(function (button) {
      button.addEventListener("click", function () {
        const dialog = button.closest("dialog");
        if (dialog && typeof dialog.close === "function") {
          dialog.close();
        }
      });
    });

  // Cerrar al hacer click afuera del contenido del modal
  Object.values(modals).forEach(function (dialog) {
    if (!dialog) return;
    dialog.addEventListener("click", function (event) {
      if (event.target === dialog) {
        dialog.close();
      }
    });
  });
});
