<template>
    <layout>
        <div class="row">
            <div class="col-sm-8">
                <div class="mb-3" style="font-size: 18px">
                    <h4>{{article.subject}}</h4><hr>
                </div>
                <div v-html="article.text"></div>
            </div>
            <div class="col-sm-4">
                <div class="mb-3" style="font-size: 18px">
                    <h4>{{__("l.Related Articles")}}</h4><hr>
                </div>
                <ul class="list">
                    <li v-if="!art.draft" v-for="art in group.articles" class="mb-2">
                        <inertia-link :href="route('knowledge-base.article', art.slug)" class="d-blcok"><h5>{{art.subject}}</h5></inertia-link>
                        <p>{{art.text}}</p>
                    </li>
                </ul>
            </div>
        </div>
    </layout>
</template>

<script>

import layout from "./layout";

export default {
    components: {
        layout
    },
    props: ["group", "article"],
    mounted(){
        this.group.articles.forEach(a=>{
            var result = "";
            var limit = 20; // Words count required
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
