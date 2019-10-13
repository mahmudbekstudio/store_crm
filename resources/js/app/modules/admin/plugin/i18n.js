import Vue from 'vue'
import VueI18n from 'vue-i18n'
import {set as setVal, forEach} from 'lodash';
import langConfig from '../config/lang';
import translations from '../../../../../static/translations';

Vue.use(VueI18n);

const localesList = [
    'validation'
];

function loadLocaleMessages() {
    const messages = {};
    const customLocale = require.context('../locale/', true, /[A-Za-z0-9-_,\s]+\.json$/i);

    customLocale.keys().forEach(key => {
        const matched = key.match(/([A-Za-z0-9-_]+)\./i);

        if (
            matched &&
            matched.length > 1 &&
            langConfig.langsList.indexOf(matched[1]) > -1
        ) {
            const keyArr = key.split('/');

            if(localesList.indexOf(keyArr[1]) > -1) {
                let langKey = [matched[1], 'locale', keyArr[1]];
                setVal(messages, langKey.join('.'), customLocale(key));
            }
        }
    });

    const locales = require.context('../module/', true, /[A-Za-z0-9-_,\s]+\.json$/i);

    for(let langKey in translations) {
        setVal(messages, langKey + '.translations', translations[langKey]);
    }

    locales.keys().forEach(key => {
        const matched = key.match(/([A-Za-z0-9-_]+)\./i);

        if (
            matched &&
            matched.length > 1 &&
            langConfig.langsList.indexOf(matched[1]) > -1
        ) {
            const locale = matched[1];
            let langKey = [locale];

            forEach(key.split('/'), function (val) {
                if (val === 'translations') {
                    return false;
                }

                if (val !== '.') {
                    langKey.push(val)
                }
            });

            setVal(messages, langKey.join('.'), locales(key));
        }
    });

    return messages
}

export default new VueI18n({
    locale: langConfig.defaultLang,
    messages: loadLocaleMessages(),
    fallbackLocale: langConfig.defaultLang
});
