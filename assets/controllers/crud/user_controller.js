import { Controller } from '@hotwired/stimulus';
import { ON_NEW, ON_EDIT, ON_DELETE } from './../events_types.js';

export default class extends Controller {
    DELETE_TITLE_FORMAT = '¿Seguro que queres eliminar a :username?';
    edit(e) {
        const data = {
            username: e.target.dataset.username,
            email: e.target.dataset.email,
            password: e.target.dataset.password,
            roleAdmin: e.target.dataset.roleAdmin
        }
        const formAction = e.target.dataset.formAction;
        this.dispatch(ON_EDIT, { detail: { formAction, data } });
    }
    
    new() {
        this.dispatch(ON_NEW);
    }
    
    delete(e) {
        const formAction = e.target.dataset.formAction;
        const username = e.target.dataset.username;
        let title = this.DELETE_TITLE_FORMAT.replace(':username', username);
        this.dispatch(ON_DELETE, { detail: { formAction, title } });
    }
}
