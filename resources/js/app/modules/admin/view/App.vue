<template>
    <v-app id="module-admin">
        <component :is="layout" v-if="inited">
            <router-view/>
        </component>
        <Centered v-if="!inited">
            {{$t('translations.words.loading')}}
        </Centered>
    </v-app>
</template>

<script>
  import {mapState} from 'vuex';
  import Empty from './layout/Empty';
  import Main from './layout/Main';
  import Centered from './layout/Centered';
  import viewConfig from '../config/view';
  //import api from '../api';
  import mainConfig from '../config/main';
  import app from '../service/App';

  export default {
    name: 'App',
    data() {
      return {
        //
      }
    },
    computed: {
      ...mapState({
        layout: state => state.view.layout,
        inited: state => state.view.inited,
      })
    },
    created() {
      this.$logger.info('app created');
      this.$vuetify.theme.dark = viewConfig.isDark;
      // app.checkInit();
    },
    components: {
      Empty,
      Main,
      Centered
    }
  }
</script>
