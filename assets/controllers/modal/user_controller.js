import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    EDIT_MODE_TITLE = 'Editar usuario';
    NEW_MODE_TITLE = 'Nueva usuario';
    EDIT_MODE_BTN_TEXT = 'Guardar cambios';
    NEW_MODE_BTN_TEXT = 'Crear usuario';

    static targets = [
        'modalTitle', 
        'form', 
        'usernameInput', 
        'emailInput', 
        'passwordInput', 
        'roleAdminInput', 
        'submitBtn'
    ];

    onEdit({ detail: { formAction, data } }) {
        this.modalTitleTarget.innerHTML = this.EDIT_MODE_TITLE;
        this.formTarget.action = formAction;
        this.usernameInputTarget.value = data.username;
        this.emailInputTarget.value = data.email;
        this.passwordInputTarget.disabled = true;
        this.roleAdminInputTarget.checked = Boolean(data.roleAdmin);
        this.submitBtnTarget.innerHTML = this.EDIT_MODE_BTN_TEXT;
    }

    onNew() {
        this.modalTitleTarget.innerHTML = this.NEW_MODE_TITLE;
        this.formTarget.action = this.element.dataset.defaultFormAction;
        this.passwordInputTarget.disabled = false;
        this.submitBtnTarget.innerHTML = this.NEW_MODE_BTN_TEXT;
        this.formTarget.reset();
    }
}
