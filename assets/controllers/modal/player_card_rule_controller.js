import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    EDIT_MODE_TITLE = 'Editar regla';
    NEW_MODE_TITLE = 'Nueva regla';

    static targets = ['modalTitle', 'form', 'cardTypeInput', 'priceInput', 'onceTimeInput', 'submitBtn'];

    onEdit({ detail: { formAction, data } }) {
        this.modalTitleTarget.innerHTML = this.EDIT_MODE_TITLE;
        this.formTarget.action = formAction;
        this.cardTypeInputTarget.value = data.cardType;
        this.priceInputTarget.value = data.price;
        this.onceTimeInputTarget.checked = Boolean(data.onceTime);
    }

    onNew() {
        this.modalTitleTarget.innerHTML = this.NEW_MODE_TITLE;
        this.formTarget.action = this.element.dataset.defaultFormAction;
        this.formTarget.reset();
    }
}
