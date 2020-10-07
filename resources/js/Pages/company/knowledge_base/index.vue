<template>
    <company :title="__('l.Knowledge Base')" :current="__('l.Knowledge Base')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Articles List") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('knowledge_base.add')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-plus"></i> <span>{{__("l.Add Article")}}</span></Inertia-link>
                    <div class="dropdown float-right ml-3">
                        <button v-on:click="show_filter=!show_filter" class="btn btn-xs btn-primary w-150"><i class="fa fa-filter"></i> <span>{{__("l.Filters")}}</span></button>
                        <div v-if="show_filter" id="dropdownMenuButton">
                            <select @change="axios_filter" v-model="group_filter" class="form-control mb-2">
                                <option value="">{{__("l.All Groups")}}</option>
                                <option v-for="group in groups" :value="group.id">{{group.name}}</option>
                                <option value="ng">{{__("l.No Group")}}</option>
                            </select>
                            <select @change="axios_filter" v-model="status_filter" class="form-control">
                                <option value="">{{__("l.All Statues")}}</option>
                                <option value="d">{{__("l.Draft")}}</option>
                                <option value="p">{{__("l.Published")}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="articles_table">
                    <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>{{__("l.Subject")}}</th>
                        <th width="180">{{__("l.Group")}}</th>
                        <th width="120">{{__("l.Status")}}</th>
                        <th width="180">{{__("l.Created At")}}</th>
                        <th width="200" class="text-center">{{__("l.Actions")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="group in groups">
                        <template v-if="article.group_id==group.id" v-for="article in filtered_articles">
                            <row :article="article" :group="group" :delete_article="delete_article"></row>
                        </template>
                    </template>
                    <template v-if="!article.group_id" v-for="article in filtered_articles">
                        <row :article="article" :delete_article="delete_article"></row>
                    </template>
                    </tbody>
                </table>
                <pagination v-if="show_pagination" :pagination="pagination" stylee="margin-top: 10px"></pagination>
            </div>
        </div>
    </company>
</template>

<script>

import company from "../layout/company";
import row from "./row";
import service from "../../../service";
import pagination from "../../common/pagination"

export default {
    components: {
        company,
        row,
        pagination
    },
    props: ["articles", "groups", "pagination", "group_id"],
    data(){
        return {
            show_filter: false,
            show_pagination: true,
            group_filter: "",
            status_filter: "",
            filtered_articles: [],
        }
    },
    mounted(){
        this.filtered_articles = this.articles.data
        this.group_filter = (this.group_id) ? this.group_id : ''
        $.each($("#articles_table tbody tr"), function (i, el) {
            $("td:first", el).html(i+1);
        })
    },
    methods:{
        axios_filter(){
            if(this.group_filter == "" && this.status_filter == ""){
                this.filtered_articles = this.articles.data
                this.show_pagination = true
                return;
            }
            this.show_pagination = false
            let url = this.route("knowledge_base.filter");
            axios.post(url, {group_id: this.group_filter, status: this.status_filter}).then(res=>{
                this.filtered_articles = res.data
            }).catch(e=>console.log(e))
        },
        async delete_article(id){
            let url = this.route("knowledge_base.delete", id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}

</script>

<style scoped>
.dropdown-toggle::after{
    display: none;
}

#dropdownMenuButton{
    width: 300px;
    border: 1px solid #eee;
    padding: 10px;
    position: absolute;
    left: -33px;
    background: #fff;
}
</style>
