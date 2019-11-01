import i18n from '../../plugin/i18n';
import ProgressRate from './ProgressRate'
import ProgressRateDetail from './ProgressRateDetail';
import ParentRoute from '../../view/ParentRoute';

const route = {
    path: '/progressrate',
    name: 'progressrate',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'progressrate.list'}},
        {
            path: 'list',
            name: 'progressrate.list',
            component: ProgressRate,
            meta: {
                requiresAuth: true,
                title: i18n.t('progressrate.title')
            },
        },
        {
            path: 'detail',
            name: 'progressrate.detail',
            component: ProgressRateDetail,
            meta: {
                requiresAuth: true,
                title: i18n.t('progressrate.title-detail')
            },
        }
    ]
};

export default route;
