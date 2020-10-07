<template>
    <layout>
        <div class="mb-3" style="font-size: 18px">
            <i class="far fa-folder"></i> <b>{{group.name}}</b>
        </div>
        <ul class="list">
            <li v-if="!article.draft" v-for="article in group.articles" class="mb-5">
                <inertia-link :href="route('knowledge-base.article', article.slug)" class="d-blcok"><h5>{{article.subject}}</h5></inertia-link>
                <p>{{article.text}}</p>
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
    props: ["group"],
    mounted(){
        this.group.articles.forEach(a=>{
            var result = "";
            var limit = 50; // Words count required
            var contentarr = a.text.replace(/(<([^>]+)>)/gi, "").split(' ');
            for (var i = 0; i < limit; i++) {
                let x = (contentarr[i])?contentarr[i]:''
                result = result + " " + x + " ";
            }
            a.text = result+ '...'
        })
    }
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
    font-size: 15px;
}
</style>
