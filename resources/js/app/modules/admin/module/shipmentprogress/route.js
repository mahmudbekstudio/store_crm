import i18n from '../../plugin/i18n';
import ShipmentProgress from './ShipmentProgress'
import ParentRoute from '../../view/ParentRoute';

const route = {
    path: '/shipment-progress',
    name: 'shipment-progress',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'shipment-progress.list'}},
        {
            path: 'list',
            name: 'shipment-progress.list',
            component: ShipmentProgress,
            meta: {
                requiresAuth: true,
                title: i18n.t('shipmentprogress.title')
            },
        },
        {
            path: 'list/1',
            name: 'shipment-progress.list2',
            component: ShipmentProgress,
            meta: {
                requiresAuth: true,
                title: i18n.t('shipmentprogress.title2')
            },
        }
    ]
};

export default route;
