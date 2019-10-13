<template>
    <Empty>
        <v-row
                align="center"
                justify="center"
        >
            <slot></slot>
        </v-row>
    </Empty>
</template>
<script>
    import Empty from './Empty'
    import { mapMutations } from 'vuex';
    export default {
      created() {
        this.changeContainerFillHeight(true);
      },
      methods: {
        ...mapMutations({
          changeContainerFillHeight: 'view/changeContainerFillHeight'
        })
      },
        components: {
            Empty,
        }
    }
</script>
<style scoped lang="scss"></style>
