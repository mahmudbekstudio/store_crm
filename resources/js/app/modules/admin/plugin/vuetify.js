import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css'
import uz from '../locale/vuetify/uz';
import en from 'vuetify/es5/locale/en'
import ru from 'vuetify/es5/locale/ru'
import langConfig from '../config/lang';

Vue.use(Vuetify);

export default new Vuetify({
    icons: {
        iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
    },
    lang: {
        locales: {en, ru, uz},
        current: langConfig.defaultLang,
    },
});
