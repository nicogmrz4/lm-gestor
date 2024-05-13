import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    edit(e) {
        const data = {
            ratingFrom: e.target.dataset.ratingFrom,
            ratingTo: e.target.dataset.ratingTo,
            price: e.target.dataset.price
        }
        const formAction = e.target.dataset.formAction;
        this.dispatch('onEdit', { detail: { formAction, data } });
    }
    
    new() {
        this.dispatch('onNew');
    }
    
    delete(e) {
        const formAction = e.target.dataset.formAction;
        this.dispatch('onDelete', { detail: { formAction } });
    }
}
