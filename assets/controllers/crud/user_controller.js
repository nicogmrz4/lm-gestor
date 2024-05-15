import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    TITLE_FORMAT = '¿Seguro que queres eliminar a :username?';
    edit(e) {
        const data = {
            username: e.target.dataset.username,
            email: e.target.dataset.email,
            password: e.target.dataset.password,
            roleAdmin: e.target.dataset.roleAdmin
        }
        const formAction = e.target.dataset.formAction;
        this.dispatch('onEdit', { detail: { formAction, data } });
    }
    
    new() {
        this.dispatch('onNew');
    }
    
    delete(e) {
        const formAction = e.target.dataset.formAction;
        const username = e.target.dataset.username;
        let title = this.TITLE_FORMAT.replace(':username', username);
        this.dispatch('onDelete', { detail: { formAction, title } });
    }
}
