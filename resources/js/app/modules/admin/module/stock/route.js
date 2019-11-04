import i18n from '../../plugin/i18n';
import Stock from './Stock'
import ParentRoute from '../../view/ParentRoute';

const route = {
    path: '/stock',
    name: 'stock',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'stock.list'}},
        {
            path: 'list',
            name: 'stock.list',
            component: Stock,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title')
            },
        },
    ]
};

export default route;
