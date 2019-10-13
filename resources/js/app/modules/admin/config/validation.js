import * as constants from '../constants';
import i18n from '../plugin/i18n';

export default {
    required: function(field = '') {
        return v => !!v || (field ? i18n.t('locale.validation.field_is_required', {field}) : i18n.t('locale.validation.this_field_is_required'));
    },
    max: function(field, maxLength) {
        return v => (v && v.length <= maxLength) || i18n.t('locale.validation.field_must_be_less_than_maxlength_character', {field, maxLength});
    },
    min: function (field, minLength) {
        return v => (v && v.length >= minLength) || i18n.t('locale.validation.field_must_be_more_than_minlength_character', {field, minLength});
    },
    isEmail: function(field) {
        return v => constants.VALIDATION_EMAIL.test(v) || i18n.t('field_must_be_valid', {field})
    },
    in: function (field, list) {
        return v => (v && list.indexOf(v) > -1) || i18n.t('field_must_be_in_the_list', {field, list: list.join('", "')})
    },
    notIn: function(field, list) {
        return v => (v && list.indexOf(v) == -1) || i18n.t('field_must_not_be_in_the_list', {field, list: list.join('", "')})
    }
}