<template>
    <index :title="__('l.Knowledge Base')">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
            <div class="container">
                <inertia-link class="navbar-brand" :href="route('index')">
                    <img :src="$page.flash.logo" width="30" height="30" alt="">
                </inertia-link>
                <inertia-link class="navbar-brand" :href="route('index')">{{$page.flash.app_name}}</inertia-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="mr-auto"></div>
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <inertia-link class="nav-link" :href="route('knowledge-base.index')">{{__("l.Knowledge Base")}}</inertia-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="wrapper">
            <div class="container">
                <div class="mb-5 pt-5 text-center">
                    <h4>{{__("l.Search Knowledge Base Articles")}}</h4>
                    <div class="form-inline d-block mx-auto mt-4">
                        <input @keyup="search" v-model="query" class="form-control search" type="search" :placeholder="__('l.Search')">
                    </div>
                </div>
                <div class="card">
                    <div class="card-body p-4">
                        <div v-if="query!=''">
                            <h4 class="mb-3">{{__("l.Search Results")}} : </h4>
                            <div v-if="result">
                                <ul class="list" v-if="result.length>0">
                                    <li v-if="!article.draft" v-for="article in result" class="mb-5">
                                        <inertia-link :href="route('knowledge-base.article', article.slug)" class="d-blcok"><h5>{{article.subject}}</h5></inertia-link>
                                        <p>{{article.text}}</p>
                                    </li>
                                </ul>
                                <div v-else>{{__("l.No Results Found")}}</div>
                            </div>
                        </div>
                        <slot v-else />
                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer text-center">Copyright &copy; {{ new Date().getFullYear() }} All rights reserved.</footer>
    </index>
</template>

<script>

import index from "../../index";

export default {
    components: {
        index
    },
    data() {
        return{
            query: "",
            result: ""
        }
    },
    methods :{
        search(){
            if(this.query!=''){
                axios.post(this.route("knowledge-base.search"), {q: this.query}).then(res=>{
                    this.result = res.data
                    this.result.forEach(a=>{
                        var result = "";
                        var limit = 50; // Words count required
                        var contentarr = a.text.replace(/(<([^>]+)>)/gi, "").split(' ');
                        for (var i = 0; i < limit; i++) {
                            let x = (contentarr[i])?contentarr[i]:''
                            result = result + " " + x + " ";
                        }
                        a.text = result+ '...'
                    })
                }).catch(e=>console.log(e))
            }
        }
    }
}

</script>

<style scoped>
.list{
    list-style: none;
    margin: 0px;
    padding: 0px;
}
.main-footer {
    background: #fff;
    border-top: 1px solid #dee2e6;
    color: #6a6d71;
    padding: 1rem;
    margin: 0px !important;
    position: fixed;
    bottom: 0px;
    right: 0;
    left: 0;
}
.wrapper{
    background: #f8f8f8;
    min-height: 80vh;
}
.form-control.search{
    width: 400px;
    height: 50px;
    font-size: 17px;
}
.search-btn{
    height: 50px;
    font-size: 17px;
}
.wrapper .container{
    padding-bottom: 200px;
}
</style>
