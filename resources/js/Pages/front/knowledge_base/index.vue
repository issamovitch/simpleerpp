<template>
    <layout>
        <ul class="list">
            <li v-for="group in groups" class="mb-5">
                <i class="far fa-folder"></i>
                <inertia-link style="font-size: 18px;" :href="route('knowledge-base.group', group.id)"><strong>{{group.name}}</strong></inertia-link> <small>{{group.articles_count}}</small>
                <p>{{group.description}}</p>
            </li>
        </ul>
    </layout>
</template>

<script>

import layout from "./layout";

export default {
    components: {
        layout
    },
    props: ["groups"]
}

</script>

<style scoped>
.list{
    list-style: none;
    margin: 0px;
    padding: 0px;
}
.fa-folder{
    font-size: 20px;
    margin-bottom: 10px;
}
p{
    margin-bottom: 10px;
    font-size: 13px;
}
</style>
