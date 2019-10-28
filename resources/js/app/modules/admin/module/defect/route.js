import i18n from '../../plugin/i18n';
import Defect from './Defect.vue'

const route = {
    path: '/defect',
    name: 'defect',
    component: Defect,
    meta: {
        requiresAuth: true,
        title: i18n.t('defect.title')
    }
};

export default route;
