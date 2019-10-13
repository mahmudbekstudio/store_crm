<template>
    <v-footer
            :inset="footerInset"
            app
    >
        <span class="px-4">&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
</template>
<script>
    import { mapState } from 'vuex';

  export default {
    computed: {
      ...mapState({
        footerInset: state => state.view.footerInset
      })
    }
  }
</script>
