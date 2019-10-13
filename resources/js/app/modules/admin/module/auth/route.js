import ParentRoute from '../../view/ParentRoute';
import Login from './login/Login';
import ForgotPassword from './forgot-password/ForgotPassword';
import Register from './register/Register';
import Profile from './profile/Profile';

const route = {
    path: '/auth',
    name: 'auth',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'auth.login'}},
        {
            path: 'login',
            name: 'auth.login',
            component: Login,
            meta: {
                layout: 'Centered',
            }
        },
        {
            path: 'forgot-password',
            name: 'auth.forgot-password',
            component: ForgotPassword,
            meta: {
                layout: 'Centered',
            }
        },
        {
            path: 'register',
            name: 'auth.register',
            component: Register,
            meta: {
                layout: 'Centered',
            }
        },
        {
            path: 'profile',
            name: 'auth.profile',
            component: Profile,
            meta: {
                title: 'Profile',
                requiresAuth: true
            }
        }
    ]
};

export default route;
