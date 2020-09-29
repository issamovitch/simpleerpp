<template>
    <body class="hold-transition sidebar-mini layout-fixed">
    <slot/>
    </body>
</template>

<script>
export default {
    props: ["title"],
    metaInfo() {
        return {
            title: this.$page.flash.app_name + " | " + this.title,
        }
    }
}
</script>

<style>
.invalid-feedback {
    display: block !important;
}
</style>
