import { Controller } from '@hotwired/stimulus';
import { ON_NEW, ON_EDIT, ON_DELETE } from './../events_types.js';

export default class extends Controller {
    DELETE_TITLE_FORMAT = '¿Seguro que queres eliminar la regla entre el rango <span class="text-primary">:ratingFrom</span> y <span class="text-primary">:ratingTo</span>?';
    DELETE_MESSAGE = 'Una vez eliminada, no se podra revertir la acción.';
    edit(e) {
        const data = {
            ratingFrom: e.target.dataset.ratingFrom,
            ratingTo: e.target.dataset.ratingTo,
            price: e.target.dataset.price
        }
        const formAction = e.target.dataset.formAction;
        this.dispatch(ON_EDIT, { detail: { formAction, data } });
    }
    
    new() {
        this.dispatch(ON_NEW);
    }
    
    delete(e) {
        const formAction = e.target.dataset.formAction;
        const title = this.DELETE_TITLE_FORMAT
            .replace(':ratingFrom', e.target.dataset.ratingFrom)
            .replace(':ratingTo', e.target.dataset.ratingTo);
        const message = this.DELETE_MESSAGE;
        this.dispatch(ON_DELETE, { detail: { formAction, title, message } });
    }
}
