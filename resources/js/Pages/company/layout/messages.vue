<template>
    <div class="flash d-none">
        <pre>
            {{$page.flash}}
        </pre>
    </div>
</template>

<script>
export default {
    methods: {
        toastrfn(){
            if (this.$page.flash.success)
                this.$toastr.success(this.$page.flash.success)
            if (this.$page.flash.status)
                this.$toastr.info(this.$page.flash.status)
            if (this.$page.flash.message)
                this.$toastr.info(this.$page.flash.message)
            if (this.$page.flash.error)
                this.$toastr.error(this.$page.flash.error)
            if (this.$page.errors){
                for (const [key, value] of Object.entries(this.$page.errors)) {
                    console.log(`${key}: ${value}`);
                    this.$toastr.error(value)
                }
            }

        }
    },
    mounted() {
        this.toastrfn()
    },
    updated() {
        this.toastrfn()
    }
}
</script>
