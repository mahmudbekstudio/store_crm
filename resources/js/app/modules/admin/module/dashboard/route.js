import i18n from '../../plugin/i18n';
import Dashboard from './Dashboard.vue'

const route = {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
        layout: 'Main',
        requiresAuth: true,
        title: i18n.t('dashboard.dashboard')
    }
};

export default route;
