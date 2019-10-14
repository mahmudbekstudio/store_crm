<template>
    <div class="page-box-wrapper">
        <PageHeader :actions="actions"></PageHeader>
        <div class="page-box">
            <slot></slot>
        </div>
        <PageFooter :actions="footerActions"><span v-html="footerText"></span></PageFooter>
    </div>
</template>
<script>
    import PageHeader from './PageHeader';
    import PageFooter from './PageFooter';

    export default {
        props: {
            actions: {
                type: Array,
                default: () => []
            },
            footerActions: {
                type: Array,
                default: () => []
            },
            footerText: {
                type: String,
                default: ''
            }
        },
        components: {
            PageHeader,
            PageFooter
        }
    }
</script>
