import * as constants from '../constants';
import mainConfig from './main';

export default {
    page: {
        default: 'dashboard',
        notFound: 'error.not-found',
        login: 'auth.login'
    },
    selected: 'main',// main, tablet, mobile
    layoutsList: ['Main', 'Empty', 'Centered'],
    defaultLayout: 'Main',// Main, Empty, Centered

    isDark: false,
    isMini: false,
    title: 'Single page Panel',
    companyName: mainConfig.app.name,

    footerInset: true,
    snackbar: {
        absolute: false,
        "auto-height": true,
        bottom: true,
        color: constants.SNACKBAR_COLORS.info,
        left: false,
        "multi-line": false,
        right: false,
        timeout: 3000,
        top: false,
        vertical: false,
        showButton: true
    },

    main: {
        /*navigationMini: false,
        navigationIsOpened: true,
        temporary: false*/
    },
    tablet: {
        /*navigationMini: true,
        navigationIsOpened: true,
        temporary: false*/
    },
    mobile: {
        /*navigationMini: false,
        navigationIsOpened: false,
        temporary: true*/
    },
};
