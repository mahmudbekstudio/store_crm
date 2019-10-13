<template>
    <v-flex sm8 md6 lg4 elevation-6>
        <v-toolbar class="blue darken-2">
            <v-toolbar-title class="white--text"><h4>{{$t('auth.forgot-password.forgot_password')}}</h4></v-toolbar-title>
        </v-toolbar>
        <v-card>
            <v-card-text class="pt-4">
                <div>
                    <v-form ref="form">
                        <v-text-field
                                ref="email"
                                v-model="form.email"
                                :rules="rules.email"
                                :error-messages="errors.email"
                                :label="$t('translations.words.email')"
                                required
                                :disabled="isLoading"
                                @keyup.enter="submit"
                                autofocus
                                prepend-icon="person"
                                type="text"
                        ></v-text-field>
                        <v-layout justify-space-between>
                                    <span>
                                        <router-link :to="{ name: 'auth.login'}">{{ $t('translations.words.login') }}</router-link><br />
                                        <router-link :to="{ name: 'auth.register'}">{{$t('translations.words.register')}}</router-link>
                                    </span>
                            <v-btn color="primary" @click.prevent="submit" :disabled="submitDisabled || isLoading">{{$t('translations.words.send')}}</v-btn>
                        </v-layout>
                    </v-form>
                </div>
            </v-card-text>
        </v-card>
    </v-flex>
</template>
<script>
    import { mapState } from 'vuex';
    import validation from '../../../config/validation';
    import * as constants from '../../../constants';
    import Service from './service';

    export default {
        service: new Service(),
        data() {
            return {
                minPasswordLength: constants.VALIDATION_MIN_PASSWORD_LENGTH,
                rules: {
                    email: [
                        validation.required('E-mail'),
                        validation.isEmail('E-mail')
                        // () => !!this.form.email || 'This field is required',
                        // () => constants.VALIDATION_EMAIL.test(this.form.email) || 'E-mail is not valid'
                    ],
                }
            }
        },
        computed: {
            ...mapState({
                form: state => state.resetPassword.form,
                submitDisabled: state => state.resetPassword.submitDisabled,
                errors: state => state.resetPassword.errors,
                isLoading: state => state.resetPassword.isLoading
            }),
        },
        watch: {
            form: {
                handler: function() {
                    if(this.$store.state.resetPassword.errors.email) {
                        this.$store.commit('resetPassword/changeErrors', {email: ''});
                    }

                    this.$store.commit('resetPassword/changeSubmitDisabled', !this.$refs.email || !this.$refs.email.validate())
                },
                deep: true
            }
        },
        methods: {
            submit() {
                if(this.submitDisabled || this.isLoading) {
                    return false;
                }

                this.$options.service.submit();
            }
        }
    }
</script>