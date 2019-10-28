import ParentRoute from '../../view/ParentRoute';
import CategoryList from './list/CategoryList';
//import CategoryForm from './form/CategoryForm';

const route = {
    path: '/category',
    name: 'category',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'category.list'}},
        {
            path: 'list',
            name: 'category.list',
            component: CategoryList,
            meta: {
                title: 'Categories',
                requiresAuth: true
            }
        },
        /*{
            path: 'edit/:id',
            name: 'category.edit',
            component: CategoryForm,
            meta: {
                title: 'Edit category',
                requiresAuth: true
            }
        },
        {
            path: 'add',
            name: 'category.add',
            component: CategoryForm,
            meta: {
                title: 'Add category',
                requiresAuth: true
            }
        }*/
    ]
};

export default route;
