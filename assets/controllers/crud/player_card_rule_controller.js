import { Controller } from '@hotwired/stimulus';
import { ON_NEW, ON_EDIT, ON_DELETE } from './../events_types.js';

export default class extends Controller {
    DELETE_TITLE_FORMAT = '¿Seguro que queres eliminar la regla del tipo <span class="text-primary">:cardType</span>?';
    DELETE_MESSAGE = 'Una vez eliminada, no se podra revertir la acción.';

    edit(e) {
        const data = {
            cardType: e.target.dataset.cardType,
            price: e.target.dataset.price,
            onceTime: e.target.dataset.onceTime
        };
        this.dispatch(ON_EDIT, { detail: { formAction: e.target.dataset.formAction, data } });
    }
    
    new() {
        this.dispatch(ON_NEW);
    }

    delete(e) {
        const formAction = e.target.dataset.formAction;
        const title = this.DELETE_TITLE_FORMAT.replace(':cardType', e.target.dataset.cardType);
        const message = this.DELETE_MESSAGE;
        this.dispatch(ON_DELETE, { detail: { formAction, title, message } });
    }
}
