<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Knowledge Base Groups')">
        <div class="card card-primary">
            <div class="card-header">{{ __("l.Knowledge Base Groups") }}</div>
            <div class="card-body">
                <a href="" class="btn btn-xs btn-primary mb-3" data-toggle="modal" data-target="#add_group"><i class="fa fa-plus"></i> {{ __("l.Add Group") }}</a>
                <form v-on:submit.prevent="group_save" class="modal fade roles_save" id="add_group">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary"><h4 class="modal-title">{{ __("l.Add Group") }}</h4>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"><label><span>{{ __("l.Name") }}</span> <span class="text-danger">*</span></label>
                                    <input type="text" v-model="group.name" required autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group"><label><span>{{ __("l.Description") }}</span></label>
                                    <textarea type="text" v-model="group.description" autocomplete="off" class="form-control" rows="4"></textarea>
                                </div>
                                <div class="form-group"><label><span>{{ __("l.Order") }}</span></label>
                                    <input type="number" v-model="group.order" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" v-model="group.draft"> {{__("l.Draft")}}
                                    </label>
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-primary"><i class="fa fa-save"></i> <span>{{__("l.Save")}}</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="50">#</th>
                            <th width="200">{{__("l.Name")}}</th>
                            <th>{{__("l.Description")}}</th>
                            <th width="120">{{__("l.Status")}}</th>
                            <th width="200" class="text-center">{{__("l.Actions")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(g, i) in groups">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{g.name}} <span class="badge bg-gray rounded-circle">{{g.articles_count}}</span></td>
                        <td>{{g.description}}</td>
                        <td>
                            <span v-if="g.draft" class="text-danger">{{__("l.Draft")}}</span>
                            <span v-else class="text-success">{{__("l.Published")}}</span>
                        </td>
                        <td class="text-center align-middle">
                            <Inertia-link :href="route('knowledge_base.index', g.id)" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></Inertia-link>
                            <a href="#" data-toggle="modal" @click="edit_modal(g)" data-target="#add_group" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></a>
                            <Inertia-link v-on:click="delete_confirm" :href="route('settings.knowledge_base_groups_delete',g.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </index>
</template>

<script>

import index from "./index"
import service from "../../../service"

export default {
    props: ["groups"],
    components: {
        index
    },
    data(){
        return {
            action: "add",
            group: Object,
            empty_group: {id: "", name: "", description:"", order: 0, draft: false}
        }
    },
    mounted() {
        this.group = this.empty_group
        let order = 0;
        this.groups.forEach(group => order = (order < group.order) ? group.order : order)
        this.group.order = ++order;
    },
    methods:{
        group_save(){
            $("#add_group").modal("hide");
            this.$inertia.post(this.route("settings.knowledge_base_groups_save"), this.group, {preserveState: false, preserveScroll: true})
        },
        add_modal(){
            this.action = 'add'
            this.group = this.empty_group
        },
        edit_modal(g){
            this.action = 'edit'
            this.group = g
        },
        async delete_confirm(e) {
            e.preventDefault();
            let url = (e.target.href) || e.target.parentElement.href;
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        }
    }
}

</script>
