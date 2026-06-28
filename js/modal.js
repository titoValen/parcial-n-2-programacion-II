import { $ } from "./elements.js";

const dialogs = {
	create: $.querySelector("#product-create-modal"),
	edit: $.querySelector("#product-edit-modal"),
	delete: $.querySelector("#product-delete-modal"),
};

const forms = {
	create: dialogs.create?.querySelector('[data-modal-form="create"]'),
	edit: dialogs.edit?.querySelector('[data-modal-form="edit"]'),
	delete: dialogs.delete?.querySelector('[data-modal-form="delete"]'),
};

const fields = {
	create: {
		name: dialogs.create?.querySelector("#create-name"),
		description: dialogs.create?.querySelector("#create-description"),
		price: dialogs.create?.querySelector("#create-price"),
		image: dialogs.create?.querySelector("#create-image"),
		alt: dialogs.create?.querySelector("#create-alt"),
		category: dialogs.create?.querySelector("#create-category"),
		stock: dialogs.create?.querySelector("#create-stock"),
		brand: dialogs.create?.querySelector("#create-brand"),
	},
	edit: {
		id: dialogs.edit?.querySelector("#edit-id"),
		name: dialogs.edit?.querySelector("#edit-name"),
		description: dialogs.edit?.querySelector("#edit-description"),
		price: dialogs.edit?.querySelector("#edit-price"),
		image: dialogs.edit?.querySelector("#edit-image"),
		alt: dialogs.edit?.querySelector("#edit-alt"),
		category: dialogs.edit?.querySelector("#edit-category"),
		stock: dialogs.edit?.querySelector("#edit-stock"),
		brand: dialogs.edit?.querySelector("#edit-brand"),
	},
	delete: {
		id: dialogs.delete?.querySelector("#delete-id"),
		name: dialogs.delete?.querySelector("[data-delete-name]"),
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
	if (fields.edit.name) fields.edit.name.value = trigger.dataset.productName ?? "";
	if (fields.edit.description) fields.edit.description.value = trigger.dataset.productDescription ?? "";
	if (fields.edit.price) fields.edit.price.value = trigger.dataset.productPrice ?? "";
	if (fields.edit.image) fields.edit.image.value = trigger.dataset.productImage ?? "";
	if (fields.edit.alt) fields.edit.alt.value = trigger.dataset.productAlt ?? "";
	if (fields.edit.stock) fields.edit.stock.value = trigger.dataset.productStock ?? "";
	if (fields.edit.category) fields.edit.category.value = trigger.dataset.productCategoryId ?? "";
	if (fields.edit.brand) fields.edit.brand.value = trigger.dataset.productBrandId ?? "";
}

function fillDeleteForm(trigger) {
	if (!trigger) return;

	if (fields.delete.id) fields.delete.id.value = trigger.dataset.productId ?? "";
	if (fields.delete.name) {
		fields.delete.name.textContent = trigger.dataset.productName ?? "este producto";
	}
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

