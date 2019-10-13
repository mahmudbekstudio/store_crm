<template>
    <div class="page-box-wrapper">
        <PageHeader :actions="actions"></PageHeader>
        <div class="page-box">
            <slot></slot>
        </div>
    </div>
</template>
<script>
    import PageHeader from './PageHeader';

    export default {
        props: {
            actions: {
                type: Array,
                default: () => []
            }
        },
        components: {
            PageHeader
        }
    }
</script>
