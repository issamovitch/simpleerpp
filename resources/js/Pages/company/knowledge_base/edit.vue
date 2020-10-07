<template>
    <company :title="__('l.Knowledge Base')" :pn="__('l.Articles List')" :pl="route('knowledge_base.index')" :current="__('l.Edit Article')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Edit Article") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('knowledge_base.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__("l.Articles List")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body" style="min-height: 500px">
                <a target="_blank" :href="route('knowledge-base.article', article.slug)">{{route('knowledge-base.article', article.slug)}}</a>
                <br><br>
                <form id="article_save" @submit.prevent="article_save" enctype="multipart/form-data">
                    <input type="hidden" name="id" :value="article.id">
                    <div class="form-group">
                        <label><span>{{__("l.Subject")}}</span> <span class="text-danger">*</span></label>
                        <input type="text" :value="article.subject" name="subject" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.Slug")}}</span> <span class="text-danger">*</span></label>
                        <input type="text" :value="article.slug" name="slug" class="form-control" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.Group")}}</span></label>
                        <div class="input-group">
                            <select name="group_id" class="form-control" id="group_id">
                                <option value="">{{__("l.Choose")}}</option>
                                <option :selected="article.group_id==group.id" v-for="group in groups" :value="group.id">{{group.name}}</option>
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-button"><button type="button" data-toggle="modal" data-target="#group_save" class="btn btn-primary"><i class="fa fa-plus"></i></button></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" :checked="article.draft" name="draft"> {{__("l.Draft")}}
                        </label>
                        <small class="d-block">{{__("l.Knowledge Base Note")}}</small>
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.Content")}}</span> <span class="text-danger">*</span></label>
                        <trumbowyg v-model="content" :config="config" class="form-control" name="text" required></trumbowyg>
                    </div>
                    <div class="form-group"><label><span>{{ __("l.Order") }}</span></label>
                        <input type="number" :value="article.order" name="order" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary w-150"><i class="fa fa-save"></i>
                            <span>{{__("l.Save")}}</span></button>
                    </div>
                </form>
            </div>
        </div>
        <form @submit.prevent="group_save" class="modal fade" id="group_save">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__("l.Add Group")}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group"><label><span>{{ __("l.Name") }}</span> <span class="text-danger">*</span></label>
                            <input type="text" name="name" required autocomplete="off" class="form-control">
                        </div>
                        <div class="form-group"><label><span>{{ __("l.Description") }}</span></label>
                            <textarea type="text" name="description" autocomplete="off" class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="draft"> {{__("l.Draft")}}
                            </label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary w-150"><i class="fa fa-save"></i> <span>{{__("l.Save")}}</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </company>
</template>

<script>

import company from "../layout/company"
// Trumbowygtext editor
import Trumbowyg from 'vue-trumbowyg';
import 'trumbowyg/dist/ui/trumbowyg.css';

export default {
    components:{
        company,
        Trumbowyg
    },
    data() {
        return {
            content: this.article.text,
            config: {
                svgPath: this.asset("public/images/vendor/trumbowyg/dist/ui/icons.svg"),
            }
        }
    },
    props : ["groups", "article"],
    methods: {
        async group_save(e){
            $("#group_save").modal("hide")
            var url = this.route('knowledge_base.group_save');
            var data = new FormData(document.getElementById("group_save"));
            await axios.post(url, data).then(res => {
                let group = res.data
                var html = "<option value='"+group.id+"'>"+group.name+"</option>"
                $("#group_id").append(html)
                $("#group_id").val(group.id)
                $("#group_save").trigger("reset")
            }).catch(e => console.log(e));
        },article_save(){
            let data = new FormData(document.getElementById("article_save"))
            this.$inertia.post(this.route('knowledge_base.update'), data, {preserveState: false})
        }
    }
}

</script>
