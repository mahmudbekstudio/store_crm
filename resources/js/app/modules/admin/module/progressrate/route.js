import i18n from '../../plugin/i18n';
import ProgressRate from './ProgressRate'

const route = {
  path: '/progressrate',
  name: 'progressrate',
  component: ProgressRate,
  meta: {
    requiresAuth: true,
    title: i18n.t('progressrate.title')
  }
};

export default route;
