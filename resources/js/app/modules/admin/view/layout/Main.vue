<template>
    <Empty>
        <template slot="header">
            <Navigation></Navigation>
            <Header></Header>
        </template>
        <v-row
                align="start"
                justify="start"
        >
            <slot></slot>
        </v-row>
        <template slot="footer">
            <Footer></Footer>
        </template>
    </Empty>
</template>
<script>
    import { mapMutations } from 'vuex';
    import Empty from './Empty'
    import Navigation from '../partial/Navigation';
    import Header from '../partial/Header';
    import Footer from '../partial/Footer';

    export default {
      created() {
        this.changeContainerFillHeight(false);
      },
      methods: {
        ...mapMutations({
          changeContainerFillHeight: 'view/changeContainerFillHeight'
        })
      },
        components: {
            Empty,
            Navigation,
            Header,
          Footer,
        }
    }
</script>
<style scoped lang="scss"></style>
