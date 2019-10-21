import ParentRoute from '../../view/ParentRoute';
import UserList from './list/UserList';
import UserForm from './form/UserForm';

const route = {
    path: '/user',
    name: 'user',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'user.list'}},
        {
            path: 'list',
            name: 'user.list',
            component: UserList,
            meta: {
                title: 'Users',
                requiresAuth: true
            }
        },
        {
            path: 'edit/:id',
            name: 'user.edit',
            component: UserForm,
            meta: {
                title: 'Edit user',
                requiresAuth: true
            }
        },
        {
            path: 'add',
            name: 'user.add',
            component: UserForm,
            meta: {
                title: 'Add user',
                requiresAuth: true
            }
        }
    ]
};

export default route;
