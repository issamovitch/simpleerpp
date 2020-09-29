<template>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{title}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><Inertia-link :href="route('dashboard')">{{__("l.Home")}}</Inertia-link></li>
                        <li v-if="pn && pl" class="breadcrumb-item"><Inertia-link :href="pl">{{pn}}</Inertia-link></li>
                        <li class="breadcrumb-item active">{{current}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: ["title", "current", "pn", "pl"],
    mounted() {
    }
}
</script>
