import ParentRoute from '../../view/ParentRoute';
import GoodsList from './list/GoodsList';
//import GoodsForm from './form/GoodsForm';

const route = {
    path: '/goods',
    name: 'goods',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'goods.list'}},
        {
            path: 'list',
            name: 'goods.list',
            component: GoodsList,
            meta: {
                title: 'Goods',
                requiresAuth: true
            }
        },
        /*{
            path: 'edit/:id',
            name: 'goods.edit',
            component: GoodsForm,
            meta: {
                title: 'Edit goods',
                requiresAuth: true
            }
        },
        {
            path: 'add',
            name: 'goods.add',
            component: GoodsForm,
            meta: {
                title: 'Add goods',
                requiresAuth: true
            }
        }*/
    ]
};

export default route;
