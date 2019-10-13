<template>
    <PageBox class="module-dashboard">
        Dashoard
    </PageBox>
</template>
<script>
    import PageBox from '../../view/partial/PageBox';
    export default {
        created() {
            this.$logger.log('test1', {a: 1});
        },
        components: {
            PageBox
        }
    }
</script>
