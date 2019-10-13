import ParentRoute from '../../view/ParentRoute';
import SchoolList from './list/SchoolList';
import SchoolForm from './form/SchoolForm';

const route = {
    path: '/school',
    name: 'school',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'school.list'}},
        {
            path: 'list',
            name: 'school.list',
            component: SchoolList,
            meta: {
                title: 'Schools',
                requiresAuth: true
            }
        },
        {
            path: 'edit/:id',
            name: 'school.edit',
            component: SchoolForm,
            meta: {
                title: 'Edit school',
                requiresAuth: true
            }
        },
        {
            path: 'add',
            name: 'school.add',
            component: SchoolForm,
            meta: {
                title: 'Add school',
                requiresAuth: true
            }
        }
    ]
};

export default route;
