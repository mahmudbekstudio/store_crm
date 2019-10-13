import i18n from '../../plugin/i18n';
import Dashboard from './Category.vue'

const route = {
    path: '/category',
    name: 'category',
    component: Dashboard,
    meta: {
        layout: 'Main',
        requiresAuth: true,
        title: i18n.t('category.title')
    }
};

export default route;
