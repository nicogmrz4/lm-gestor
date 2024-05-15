import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    DEFAULT_TITLE = '¿Seguro que queres proceder?';
    DEFAULT_MESSAGE = 'Una vez eliminado, no se podra revertir la acción.';
    static targets = ['form', 'title', 'message'];

    onDelete({ detail: { formAction, title, message } }) {
        this.formTarget.action = formAction;
        this.titleTarget.innerHTML = title ?? this.DEFAULT_TITLE;
        this.messageTarget.innerHTML = message ?? this.DEFAULT_MESSAGE;
    }
}