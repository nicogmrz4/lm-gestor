import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['form'];

    onDelete({ detail: { formAction } }) {
        this.formTarget.action = formAction;
    }
}