import ParentRoute from '../../view/ParentRoute';
import NotFound from './not-found/NotFound'
import i18n from '../../plugin/i18n';

const route = {
    path: '/error',
    name: 'error',
    component: ParentRoute,
    children: [
        {path: '', redirect: {name: 'error.not-found'}},
        {
            path: 'not-found',
            name: 'error.not-found',
            component: NotFound,
            meta: {
                layout: 'Centered',
                title: i18n.t('error.not-found.title')
            }
        }
    ]
};

export default route;
