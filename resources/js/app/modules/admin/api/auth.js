import Route from './route';
import Auth from '../service/Auth';

export default {
    'check-access': {
        ...Route.admin('check-access'),
        token: true
    },
    'refresh': {
        ...Route.admin('refresh'),
    },
    'logout': {
        ...Route.admin('logout'),
        token: true,
        callback: function() {
            this.params({token: Auth.getRefreshToken(false)});
        }
    }
};
