<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Contacts Groups')">
        <div class="card card-primary" v-if="contact_groups">
            <div class="card-header">{{__("l.Client Groups")}}</div>
            <div class="card-body">
                <a href="#" class="btn btn-primary btn-xs mb-3" data-toggle="modal" data-target="#add_contact_group"><i class="fa fa-plus"></i> <span>{{__("l.Add Contact Group")}}</span></a>
                <form v-on:submit.prevent="contact_groups_save" class="modal fade save_contact_group" id="add_contact_group">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">{{__("l.Add Contact Group")}}</h5>
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
                    <tr v-for="(contact_group, i) in contact_groups">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{contact_group.name}}</td>
                        <td class="text-center align-middle">
                            <a href="#" data-toggle="modal" :data-target="'#contact_groups_update'+contact_group.id" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></a>
                            <Inertia-link v-on:click="delete_confirm" :href="route('settings.contact_groups_delete',contact_group.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <form v-for="contact_group in contact_groups" v-on:submit.prevent="contact_groups_update(contact_group.id)" class="modal fade" :id="'contact_groups_update'+contact_group.id">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">{{__("l.Edit Client Group")}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" :value="contact_group.id">
                                <div class="form-group">
                                    <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                                    <input type="text" :value="contact_group.name" class="form-control" name="name" required autocomplete="off">
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
    props: ["contact_groups", "breadcrumb"],

    methods: {
        contact_groups_save(e) {
            var id = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#" + id).modal("hide");
            this.$inertia.post(this.route("settings.contact_groups_save"), data, {preserveState: false, preserveScroll: true})
        },
        contact_groups_update(id){
            var data = new FormData(document.getElementById("contact_groups_update"+id));
            $("#contact_groups_update"+id).modal("hide");
            this.$inertia.post(this.route("settings.contact_groups_update"), data,  {preserveState: false, preserveScroll: true})
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
