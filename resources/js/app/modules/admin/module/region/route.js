import ParentRoute from '../../view/ParentRoute';
import RegionList from './list/RegionList';
import RegionForm from './form/RegionForm';

const route = {
    path: '/region',
    name: 'region',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'region.list'}},
        {
            path: 'list',
            name: 'region.list',
            component: RegionList,
            meta: {
                title: 'Regions',
                requiresAuth: true
            }
        },
        {
            path: 'edit/:id',
            name: 'region.edit',
            component: RegionForm,
            meta: {
                title: 'Edit region',
                requiresAuth: true
            }
        },
        {
            path: 'add',
            name: 'region.add',
            component: RegionForm,
            meta: {
                title: 'Add region',
                requiresAuth: true
            }
        }
    ]
};

export default route;
