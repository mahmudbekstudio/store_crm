import i18n from '../../plugin/i18n';
import Stock from './Stock'
import StockDetail from './StockDetail';
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
        {
            path: 'detail/1',
            name: 'stock.detail1',
            component: StockDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title-detail') + '1'
            },
        },
        {
            path: 'detail/2',
            name: 'stock.detail2',
            component: StockDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title-detail') + '2'
            },
        },
        {
            path: 'detail/3',
            name: 'stock.detail3',
            component: StockDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title-detail') + '3'
            },
        },
        {
            path: 'detail/4',
            name: 'stock.detail4',
            component: StockDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title-detail') + '4'
            },
        },
        {
            path: 'detail/5',
            name: 'stock.detail5',
            component: StockDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title-detail') + '5'
            },
        },
        {
            path: 'detail/6',
            name: 'stock.detail6',
            component: StockDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title-detail') + '6'
            },
        },
        {
            path: 'detail/7',
            name: 'stock.detail7',
            component: StockDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('stock.title-detail') + '7'
            },
        }
    ]
};

export default route;
