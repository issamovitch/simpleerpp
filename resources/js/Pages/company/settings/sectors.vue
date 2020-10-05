<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Sectors')">
        <div class="card card-primary" v-if="sectors">
            <div class="card-header">{{__("l.Sectors")}}</div>
            <div class="card-body">
                <a href="#" class="btn btn-primary btn-xs mb-3" data-toggle="modal" data-target="#add_sector"><i class="fa fa-plus"></i> <span>{{__("l.Add Sector")}}</span></a>
                <form v-on:submit.prevent="sectors_save" class="modal fade save_sector" id="add_sector">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">{{__("l.Add Sector")}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label><span>{{__("l.Sector")}}</span> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="sector" required>
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option v-for="value in main_sectors" :value="value">{{__("l."+value)}}</option>
                                    </select>
                                </div>
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
                        <th>{{__("l.Sector")}}</th>
                        <th  width="150" class="text-center">{{__("l.Actions")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(sector, i) in sectors">
                        <td class="text-center">{{i+1}}</td>
                        <td>{{sector.name}}</td>
                        <td><div v-if="sector.sector == value" v-for="value in main_sectors">{{value}}</div></td>
                        <td class="text-center align-middle">
                            <a href="#" data-toggle="modal" :data-target="'#sectors_update'+sector.id" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></a>
                            <Inertia-link v-on:click="delete_confirm" :href="route('settings.sectors_delete', sector.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <form v-for="sector in sectors" v-on:submit.prevent="sectors_update(sector.id)" class="modal fade save_sector" :id="'sectors_update'+sector.id">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">{{__("l.Edit Sector")}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" :value="sector.id">
                                <div class="form-group">
                                    <label><span>{{__("l.Sector")}}</span> <span class="text-danger">*</span></label>
                                    <select class="form-control" name="sector" required>
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option :selected="value==sector.sector" v-for="value in main_sectors" :value="value">{{__("l."+value)}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                                    <input type="text" :value="sector.name" class="form-control" name="name" required autocomplete="off">
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
    props: ["sectors", "main_sectors"],
    methods:{
        sectors_save(e){
            var id   = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#"+id).modal("hide");
            this.$inertia.post(this.route("settings.sectors_save"), data,  {preserveState: false, preserveScroll: true})
        },
        sectors_update(id){
            var data = new FormData(document.getElementById("sectors_update"+id));
            $("#sectors_update"+id).modal("hide");
            this.$inertia.post(this.route("settings.sectors_update"), data,  {preserveState: false, preserveScroll: true})
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
