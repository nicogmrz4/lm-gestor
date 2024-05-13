import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    edit(e) {
        const data = {
            cardType: e.target.dataset.cardType,
            price: e.target.dataset.price,
            onceTime: e.target.dataset.onceTime
        };
        this.dispatch('onEdit', { detail: { formAction: e.target.dataset.formAction, data } });
    }
    
    new() {
        this.dispatch('onNew');
    }

    delete(e) {
        const formAction = e.target.dataset.formAction;
        this.dispatch('onDelete', { detail: { formAction } });
    }
}
