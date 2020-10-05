<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.SMTP Settings')">
        <div class="card card-primary">
            <div class="card-header">{{ __("l.Roles & Permissions") }}</div>
            <div class="card-body">
                <a href="" class="btn btn-xs btn-primary mb-3" data-toggle="modal" data-target="#add_role"><i class="fa fa-plus"></i>{{ __("l.Add Role") }}</a>
                <form v-on:submit.prevent="roles_save" class="modal fade roles_save" id="add_role">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary"><h4 class="modal-title">{{ __("l.Add Role") }}</h4>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"><label><span>{{ __("l.Name") }}</span> <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required autocomplete="off" class="form-control">
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
                        <th width="50" class="text-center">#</th>
                        <th>{{ __("l.Name") }}</th>
                        <th class="text-center" width="200">{{ __("l.Actions") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(role, i) in roles">
                        <td class="text-center">{{ i + 1 }}</td>
                        <td>{{ role.name }}</td>
                        <td class="text-center align-middle">
                            <a href="#" class="btn btn-success btn-xs" data-toggle="modal" :data-target="'#roles_update'+role.id"><i
                                class="fa fa-edit"></i> <span>{{ __("l.Edit") }}</span></a>
                            <inertia-link preserve-scroll v-on:click="delete_confirm" :href="route('settings.roles_delete', role.id)" v-bind:class="{'disabled' :role.id == 1}" class="btn btn-danger btn-xs"><i
                                class="fa fa-trash"></i> {{ __("l.Delete") }}</inertia-link>
                        </td>
                        <div v-on:submit.prevent="roles_update(role.id)" class="modal fade" :id="'roles_update'+role.id">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h4 class="modal-title">{{ __("l.Edit Role")}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form :id="'roles_update_form'+role.id">
                                            <input type="hidden" name="id" :value="role.id">
                                            <div class="form-group">
                                                <label><span>{{ __("l.Name") }}</span> <span class="text-danger">*</span></label>
                                                <input tabindex="1" type="text" :value="role.name" class="form-control" name="name" required>
                                            </div>
                                            <div class="form-group mb-0">
                                                <button class="btn btn-primary"><i class="fa fa-save"></i> <span>{{ __("l.Save") }}</span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    props: ["breadcrumb", "roles"],
    components: {
        index
    }, data() {
        return {}
    },methods:{
        roles_save(e){
            var id   = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#"+id).modal("hide");
            this.$inertia.post(this.route("settings.roles_save"), data,  {preserveState: false, preserveScroll: true})
        },
        roles_update(id){
            var data = new FormData(document.getElementById("roles_update_form"+id));
            $("#roles_update"+id).modal("hide");
            this.$inertia.post(this.route("settings.roles_save"), data,  {preserveState: false, preserveScroll: true})
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
