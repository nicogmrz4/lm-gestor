import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['modalTitle', 'form', 'cardTypeInput', 'priceInput', 'onceTimeInput', 'submitBtn'];

    onEdit({ detail: { formAction, data } }) {
        this.modalTitleTarget.innerHTML = 'Editar regla';
        this.formTarget.action = formAction;
        this.cardTypeInputTarget.value = data.cardType;
        this.priceInputTarget.value = data.price;
        this.onceTimeInputTarget.checked = Boolean(data.onceTime);
    }

    onNew() {
        this.modalTitleTarget.innerHTML = 'Nueva regla';
        this.formTarget.action = this.element.dataset.defaultFormAction;
        this.formTarget.reset();
    }
}
