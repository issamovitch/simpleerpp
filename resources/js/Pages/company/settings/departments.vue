<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Departments')">
        <div class="card card-primary">
            <div class="card-header">{{ __("l.Departments") }}</div>
            <div class="card-body">
                <a href="" class="btn btn-xs btn-primary mb-3" data-toggle="modal" data-target="#add_department"><i class="fa fa-plus"></i>{{ __("l.Add Department") }}</a>
                <form v-on:submit.prevent="departments_save" class="modal fade departments_save" id="add_department">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary"><h4 class="modal-title">{{ __("l.Add Department") }}</h4>
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group"><label>{{ __("l.Name") }} <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group"><label>{{ __("l.Parent Department") }}</label>
                                    <select name="parent_id" autocomplete="off" class="form-control">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                                    </select>
                                </div>
                                <div class="form-group"><label>{{ __("l.Manager") }}</label>
                                    <select name="manager_id" autocomplete="off" class="form-control">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option v-for="user in users" :value="user.id">{{user.name}}</option>
                                    </select>
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
                <organization-chart v-if="ds && departments && users" :datasource="ds" :pan="true">
                    <template slot-scope="{ nodeData }">
                        <div :id="nodeData.id" class="node">
                            <div class="title">
                                <i v-if="nodeData.id==0" class="fa fa-building symbol"></i>
                                <i v-else class="fa fa-users symbol"></i>
                                <span>{{nodeData.name}}</span>
                            </div>
                            <div v-if="nodeData.id == 0" class="content"></div>
                            <div v-else class="content">
                                <div class="row m-0">
                                    <div class="col-sm-4 p-0">
                                        <a href="#" class="btn btn-xs btn-block btn-info text-center" v-on:click.prevent="show_modal(nodeData.id)" :title="__('l.View')"><i class="fa fa-eye"></i></a>
                                    </div>
                                    <div class="col-sm-4 p-0">
                                        <a href="" class="btn btn-xs btn-block btn-success text-center" v-on:click.prevent="edit_modal(nodeData.id)" :title="__('l.Edit')"><i class="fa fa-edit"></i></a>
                                    </div>
                                    <div class="col-sm-4 p-0">
                                        <inertia-link preserve-scroll v-on:click="delete_confirm" :href="route('settings.departments_delete', nodeData.id)" class="btn btn-xs btn-block btn-danger text-center"
                                                      :title="__('l.Delete')"><i class="fa fa-trash"></i></inertia-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </organization-chart>
                <div class="modal" :id="'show_modal'+department.id" v-for="department in departments">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h4 class="modal-title">{{__("l.Department Details")}}</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="mb-0">{{__("l.Name")}} : </label>
                                    <div class="d-inline-block">{{department.name}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="mb-0">{{__("l.Parent Department")}} : </label>
                                    <div class="d-inline-block">{{(department.department)? department.department.name:''}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="mb-0">{{__("l.Manager")}} : </label>
                                    <div class="d-inline-block">{{(department.manager)?department.manager.name:''}}</div>
                                </div>
                                <div class="form-group">
                                    <label class="mb-0">{{__("l.Description")}} : </label>
                                    <div class="d-inline-block">{{department.dsecription}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form v-for="department in departments" v-on:submit.prevent="departments_update" class="modal fade" :id="'edit_modal'+department.id">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title">{{ __("l.Edit Department") }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" :value="department.id">
                                <div class="form-group">
                                    <label><span>{{ __("l.Name") }}</span> <span class="text-danger">*</span></label>
                                    <input type="text" :value="department.name" class="form-control" name="name" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label><span>{{ __("l.Parent Department") }}</span></label>
                                    <select class="form-control" name="parent_id">
                                        <option value="">{{ __("l.Choose") }}</option>
                                        <option v-if="department.id!=departmentx.id" :selected="department.parent_id==departmentx.id" v-for="departmentx in departments" :value="departmentx.id">
                                            {{ departmentx.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><span>{{ __("l.Manager") }}</span></label>
                                    <select class="form-control" name="manager_id">
                                        <option value="">{{ __("l.Choose") }}</option>
                                        <option :selected="department.manager_id==user.id" v-for="user in users" :value="user.id">
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><span>{{ __("l.Description") }}</span></label>
                                    <textarea class="form-control" name="dsecription">{{department.dsecription}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary w-150"><i class="fa fa-save"></i><span>{{ __("l.Save") }}</span></button>
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
import OrganizationChart from 'vue-organization-chart'
import 'vue-organization-chart/dist/orgchart.css'

export default {
    components:{
        index,
        OrganizationChart
    },
    props: ["departments", "departments_json", "users"],
    methods:{
        departments_save(e){
            var id   = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#"+id).modal("hide");
            this.$inertia.post(this.route("settings.departments_save"), data,  {preserveState: false, preserveScroll: true})
        },
        departments_update(e){
            var id   = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#"+id).modal("hide");
            this.$inertia.post(this.route("settings.departments_update"), data,  {preserveState: false, preserveScroll: true})
        },
        show_modal(id){
            $("#show_modal"+id).modal("show")
        },
        edit_modal(id){
            $("#edit_modal"+id).modal("show")
        },
        async delete_confirm(e) {
            e.preventDefault();
            let url = (e.target.href) || e.target.parentElement.href;
            if(await service.confirmation()){
                this.$inertia.visit(url,  {method: 'get',preserveState: false, preserveScroll: true})
            }
        },
    },data () {
        return {
            ds: null
        }
    },
    mounted() {
        this.ds = this.$props.departments_json
    },
}
</script>

<style>
.orgchart .node .title{
    background-color: #007bff !important;
}
.orgchart .node .content{
    height: 26px !important;
    border-color: #007bff !important;
}
.orgchart .lines .downLine{
    background-color: #007bff !important;
    width: 2.2px !important;
}
.orgchart .lines .rightLine{
    border-right-color: #007bff !important;
}
.orgchart .lines .leftLine{
    border-left-color: #007bff !important;
}
.orgchart .lines .topLine{
    border-top-color: #007bff !important;
}
.orgchart-container{
    border: none !important;
    overflow: visible !important;
}
.orgchart{
    background-image : none !important;
}
</style>
