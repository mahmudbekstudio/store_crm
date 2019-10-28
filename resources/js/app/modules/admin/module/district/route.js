import ParentRoute from '../../view/ParentRoute';
import DistrictList from './list/DistrictList';
//import RegionForm from './form/RegionForm';

const route = {
    path: '/district',
    name: 'district',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'district.list'}},
        {
            path: 'list',
            name: 'district.list',
            component: DistrictList,
            meta: {
                title: 'District',
                requiresAuth: true
            }
        },
        /*{
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
        }*/
    ]
};

export default route;
