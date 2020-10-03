<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Client Groups')">
        <div class="card card-primary" v-if="client_groups">
            <div class="card-header">{{__("l.Client Groups")}}</div>
            <div class="card-body">
                <a href="#" class="btn btn-primary btn-xs mb-3" data-toggle="modal" data-target="#add_client_group"><i class="fa fa-plus"></i> <span>{{__("l.Add Client Group")}}</span></a>
                <form v-on:submit.prevent="client_groups_save" class="modal fade save_client_group" id="add_client_group">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{__("l.Add Client Group")}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control name" name="name" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary w-150"><i class="fa fa-save"></i> <span>{{__("l.Save")}}</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" width="50">#</th>
                        <th>{{__("l.Name")}}</th>
                        <th width="150" class="text-center">{{__("l.Actions")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(client_group, i) in client_groups">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{client_group.name}}</td>
                        <td class="text-center align-middle">
                            <a href="#" data-toggle="modal" :data-target="'#client_groups_update'+client_group.id" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></a>
                            <Inertia-link v-on:click="delete_confirm" :href="route('settings.client_groups_delete',client_group.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <form v-for="client_group in client_groups" v-on:submit.prevent="client_groups_update(client_group.id)" class="modal fade" :id="'client_groups_update'+client_group.id">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{__("l.Edit Client Group")}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" :value="client_group.id">
                                <div class="form-group">
                                    <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                                    <input type="text" :value="client_group.name" class="form-control" name="name" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary w-150"><i class="fa fa-save"></i> <span>{{__("l.Save")}}</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </index>
</template>

<script>

import index from "./index"
import service from "../../../service"

export default {
    components:{
        index
    },
    props: ["client_groups", "breadcrumb"],

    methods: {
        client_groups_save(e) {
            var id = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#" + id).modal("hide");
            this.$inertia.post(this.route("settings.client_groups_save"), data, {preserveState: false, preserveScroll: true})
        },
        client_groups_update(id){
            var data = new FormData(document.getElementById("client_groups_update"+id));
            $("#client_groups_update"+id).modal("hide");
            this.$inertia.post(this.route("settings.client_groups_update"), data,  {preserveState: false, preserveScroll: true})
        },
        async delete_confirm(e) {
            e.preventDefault();
            let url = (e.target.href) || e.target.parentElement.href;
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}

</script>
