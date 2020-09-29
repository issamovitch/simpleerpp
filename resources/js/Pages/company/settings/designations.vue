<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Designations')">
        <div class="card card-primary">
            <div class="card-header">{{ __("l.Designations") }}</div>
            <div class="card-body">
                <a href="" class="btn btn-xs btn-primary mb-3" data-toggle="modal" data-target="#add_designation"><i class="fa fa-plus"></i>{{ __("l.Add Designation") }}</a>
                <form v-on:submit.prevent="designations_save" class="modal fade designations_save" id="add_designation">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header"><h4 class="modal-title">{{ __("l.Add Designation") }}</h4>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"><label>{{ __("l.Name") }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group"><label>{{ __("l.Description") }}</label>
                                    <textarea name="dsecription" autocomplete="off" class="form-control"></textarea>
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
                        <th width="40%">{{ __("l.Description") }}</th>
                        <th class="text-center" width="200">{{ __("l.Actions") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(designation, i) in designations">
                        <td class="text-center">{{ i + 1 }}</td>
                        <td>{{ designation.name }}</td>
                        <td>{{ designation.dsecription }}</td>
                        <td class="text-center align-middle">
                            <a href="#" class="btn btn-success btn-xs" data-toggle="modal" :data-target="'#designations_update'+designation.id"><i
                                class="fa fa-edit"></i> <span>{{ __("l.Edit") }}</span></a>
                            <inertia-link preserve-scroll v-on:click="delete_confirm" :href="route('settings.designations_delete', designation.id)" v-bind:class="{'disabled' :designation.id == 1}" class="btn btn-danger btn-xs"><i
                                class="fa fa-trash"></i> {{ __("l.Delete") }}</inertia-link>
                        </td>
                        <div v-on:submit.prevent="designations_update(designation.id)" class="modal fade" :id="'designations_update'+designation.id">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __("l.Edit designation")}}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form :id="'designations_update_form'+designation.id">
                                            <input type="hidden" name="id" :value="designation.id">
                                            <div class="form-group">
                                                <label><span>{{ __("l.Name") }}</span> <span class="text-danger">*</span></label>
                                                <input tabindex="1" type="text" :value="designation.name" class="form-control" name="name" required>
                                            </div>
                                            <div class="form-group"><label>{{ __("l.Description") }}</label>
                                                <textarea name="dsecription" :value="designation.dsecription" autocomplete="off" class="form-control"></textarea>
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
    props: ["designations"],
    components: {
        index
    }, data() {
        return {}
    },methods:{
        designations_save(e){
            var id   = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#"+id).modal("hide");
            this.$inertia.post(this.route("settings.designations_save"), data,  {preserveState: false, preserveScroll: true})
        },
        designations_update(id){
            var data = new FormData(document.getElementById("designations_update_form"+id));
            $("#designations_update"+id).modal("hide");
            this.$inertia.post(this.route("settings.designations_save"), data,  {preserveState: false, preserveScroll: true})
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
