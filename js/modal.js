import { $ } from "./elements.js";

const dialogs = {
  create: $.querySelector("#product-create-modal"),
  edit: $.querySelector("#product-edit-modal"),
  delete: $.querySelector("#product-delete-modal"),
  sizes: $.querySelector("#product-sizes-modal"),
};

const forms = {
  create: dialogs.create?.querySelector('[data-modal-form="create"]'),
  edit: dialogs.edit?.querySelector('[data-modal-form="edit"]'),
  delete: dialogs.delete?.querySelector('[data-modal-form="delete"]'),
  sizes: dialogs.sizes?.querySelector('[data-modal-form="sizes"]'),
};

const fields = {
  create: {
    name: dialogs.create?.querySelector("#create-name"),
    description: dialogs.create?.querySelector("#create-description"),
    price: dialogs.create?.querySelector("#create-price"),
    image: dialogs.create?.querySelector("#create-image"),
    alt: dialogs.create?.querySelector("#create-alt"),
    category: dialogs.create?.querySelector("#create-category"),
    brand: dialogs.create?.querySelector("#create-brand"),
  },
  edit: {
    id: dialogs.edit?.querySelector("#edit-id"),
    name: dialogs.edit?.querySelector("#edit-name"),
    description: dialogs.edit?.querySelector("#edit-description"),
    price: dialogs.edit?.querySelector("#edit-price"),
    image: dialogs.edit?.querySelector("#edit-image"),
    currentImage: dialogs.edit?.querySelector("[data-current-image]"),
    alt: dialogs.edit?.querySelector("#edit-alt"),
    category: dialogs.edit?.querySelector("#edit-category"),
    brand: dialogs.edit?.querySelector("#edit-brand"),
  },
  delete: {
    id: dialogs.delete?.querySelector("#delete-id"),
    name: dialogs.delete?.querySelector("[data-delete-name]"),
  },
  sizes: {
    idProduct: dialogs.sizes?.querySelector("#sizes-id-product"),
    productName: dialogs.sizes?.querySelector("[data-sizes-product-name]"),
    container: dialogs.sizes?.querySelector("[data-sizes-container]"),
  },
};

function openDialog(dialog) {
  if (!dialog) return;

  if (typeof dialog.showModal === "function") {
    dialog.showModal();
    return;
  }

  dialog.setAttribute("open", "");
}

function closeDialog(dialog) {
  if (!dialog) return;

  if (typeof dialog.close === "function") {
    dialog.close();
    return;
  }

  dialog.removeAttribute("open");
}

function resetCreateForm() {
  forms.create?.reset();

  if (fields.create.category) {
    fields.create.category.selectedIndex = 0;
  }

  if (fields.create.brand) {
    fields.create.brand.selectedIndex = 0;
  }
}

function fillEditForm(trigger) {
  if (!trigger) return;

  if (fields.edit.id) fields.edit.id.value = trigger.dataset.productId ?? "";
  if (fields.edit.name)
    fields.edit.name.value = trigger.dataset.productName ?? "";
  if (fields.edit.description)
    fields.edit.description.value = trigger.dataset.productDescription ?? "";
  if (fields.edit.price)
    fields.edit.price.value = trigger.dataset.productPrice ?? "";
  if (fields.edit.currentImage) {
    fields.edit.currentImage.textContent = trigger.dataset.productImage
      ? `Imagen actual: ${trigger.dataset.productImage}`
      : "";
  }
  if (fields.edit.alt) fields.edit.alt.value = trigger.dataset.productAlt ?? "";
  if (fields.edit.category)
    fields.edit.category.value = trigger.dataset.productCategoryId ?? "";
  if (fields.edit.brand)
    fields.edit.brand.value = trigger.dataset.productBrandId ?? "";
}

function fillDeleteForm(trigger) {
  if (!trigger) return;

  if (fields.delete.id)
    fields.delete.id.value = trigger.dataset.productId ?? "";
  if (fields.delete.name) {
    fields.delete.name.textContent =
      trigger.dataset.productName ?? "este producto";
  }
}

function fillSizesForm(trigger) {
  if (!trigger) return;

  if (fields.sizes.idProduct) {
    fields.sizes.idProduct.value = trigger.dataset.productId ?? "";
  }

  if (fields.sizes.productName) {
    fields.sizes.productName.textContent = trigger.dataset.productName ?? "";
  }

  if (!fields.sizes.container) return;

  fields.sizes.container.innerHTML = "";

  let sizes = [];
  try {
    sizes = JSON.parse(trigger.dataset.productSizes ?? "[]");
  } catch (error) {
    sizes = [];
  }

  sizes.forEach((size) => {
    const label = document.createElement("label");
    label.className = "admin-modal__field";
    label.setAttribute("for", `size-${size.id_size}`);

    const span = document.createElement("span");
    span.textContent = `Talle ${size.size}`;

    const input = document.createElement("input");
    input.type = "number";
    input.id = `size-${size.id_size}`;
    input.name = `sizes[${size.id_size}]`;
    input.min = "0";
    input.step = "1";
    input.value = size.stock;

    label.appendChild(span);
    label.appendChild(input);
    fields.sizes.container.appendChild(label);
  });
}

function handleOpenModal(trigger) {
  const modalType = trigger.dataset.modalOpen;

  if (modalType === "create") {
    resetCreateForm();
    openDialog(dialogs.create);
  }

  if (modalType === "edit") {
    fillEditForm(trigger);
    openDialog(dialogs.edit);
  }

  if (modalType === "delete") {
    fillDeleteForm(trigger);
    openDialog(dialogs.delete);
  }

  if (modalType === "sizes") {
    fillSizesForm(trigger);
    openDialog(dialogs.sizes);
  }
}

function bindCloseButtons(dialog) {
  dialog?.querySelectorAll("[data-modal-close]").forEach((button) => {
    button.addEventListener("click", () => closeDialog(dialog));
  });

  dialog?.addEventListener("click", (event) => {
    if (event.target === dialog) {
      closeDialog(dialog);
    }
  });
}

$.addEventListener("DOMContentLoaded", () => {
  $.querySelectorAll("[data-modal-open]").forEach((button) => {
    button.addEventListener("click", () => handleOpenModal(button));
  });

  Object.values(dialogs).forEach((dialog) => bindCloseButtons(dialog));
});
