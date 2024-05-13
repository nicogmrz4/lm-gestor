import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    EDIT_MODE_TITLE = 'Editar regla';
    NEW_MODE_TITLE = 'Nueva regla';
    
    static targets = ['modalTitle', 'form', 'ratingFromInput', 'ratingToInput', 'priceInput', 'submitBtn'];    

    onEdit({ detail: { formAction, data } }) {
        this.modalTitleTarget.innerHTML = this.EDIT_MODE_TITLE;
        this.formTarget.action = formAction;
        this.ratingFromInputTarget.value = data.ratingFrom;
        this.ratingToInputTarget.value = data.ratingTo;
        this.priceInputTarget.value = data.price;
    }

    onNew() {
        this.modalTitleTarget.innerHTML = this.NEW_MODE_TITLE;
        this.formTarget.action = this.element.dataset.defaultFormAction;
        this.formTarget.reset();
    }
}
