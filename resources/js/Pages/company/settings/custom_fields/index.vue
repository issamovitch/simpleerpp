<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Custom Fields')">
        <div class="card card-primary">
            <div class="card-header">{{__('l.Custom Fields')}}</div>
            <div class="card-body">
                <a href="#" @click="add_modal()" class="btn btn-primary btn-xs mb-3" data-toggle="modal" data-target="#custom_fields_save"><i class="fa fa-plus"></i> <span>{{__("l.Add Custom Field")}}</span></a>
                <form v-on:submit.prevent="custom_fields_save" class="modal fade save_custom_field" id="custom_fields_save">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 v-if="action=='add'" class="modal-title">{{__("l.Add Custom Field")}}</h5>
                                <h5 v-else class="modal-title">{{__("l.Edit Custom Field")}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input v-if="field.id" type="hidden" name="id" :value="field.id">
                                <div class="form-group">
                                    <label><span>{{__("l.Belongs To")}}</span> <span class="text-danger">*</span></label>
                                    <select v-model="field.model" class="form-control" name="model" required>
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option value="Client">{{__("l.Client")}}</option>
                                        <option value="Contact">{{__("l.Contact")}}</option>
                                    </select>
                                </div>
                                <div class="form-group" v-if="field.model=='Contact'">
                                    <label><span>{{__("l.Contact Group")}}</span></label>
                                    <select v-model="field.group_id" class="form-control" name="group_id">
                                        <option value="">{{__("l.All Groups")}}</option>
                                        <option v-for="group in contact_groups" :value="group.id">{{group.name}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                                    <input v-model="field.name" type="text" class="form-control" name="name" required autocomplete="off" :placeholder="__('l.Name')">
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Order")}}</span></label>
                                    <input v-model="field.order" type="text" class="form-control" name="order" autocomplete="off" :placeholder="__('l.Order')">
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Field Type")}}</span> <span class="text-danger">*</span></label>
                                    <select v-model="field.type" name="type" required="required" class="form-control">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option value="Text">{{__("l.Text")}}</option>
                                        <option value="Textarea">{{__("l.Textarea")}}</option>
                                        <option value="Select">{{__("l.Select")}}</option>
                                        <option value="Multi Select">{{__("l.Multi Select")}}</option>
                                        <option value="Checkbox">{{__("l.Checkbox")}}</option>
                                        <option value="Radio">{{__("l.Radio")}}</option>
                                        <option value="Date">{{__("l.Date")}}</option>
                                        <option value="Time">{{__("l.Time")}}</option>
                                        <option value="DateTime">{{__("l.DateTime")}}</option>
                                        <option value="Number">{{__("l.Number")}}</option>
                                        <option value="Color">{{__("l.Color")}}</option>
                                        <option value="Url">{{__("l.Url")}}</option>
                                    </select>
                                </div>
                                <div class="form-group" v-if="['Select', 'Multi Select', 'Checkbox', 'Radio'].includes(field.type)">
                                    <multiselect name="options" v-model="field.options" :tag-placeholder="__('l.Add this as new option')"
                                                 :placeholder="__('l.Add an option')" :options="[]"
                                                 :multiple="true" :taggable="true" :allow-empty="true" @tag="addTag">
                                    </multiselect>
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Width")}}</span> <span class="text-danger">*</span></label>
                                    <select v-model="field.width" name="width" required="required" class="form-control">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option value="12">{{__("l.Full Width")}} (100%)</option>
                                        <option value="9">{{__("l.Three-quarters")}} (3/4)</option>
                                        <option value="6">{{__("l.Half Width")}} (1/2)</option>
                                        <option value="4">{{__("l.One Third")}} (1/3)</option>
                                        <option value="3">{{__("l.ِQuarter")}} (1/4)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Placeholder")}}</span></label>
                                    <input v-model="field.placeholder" maxlength="300" type="text" class="form-control" name="placeholder" autocomplete="off" :placeholder="__('l.Placeholder')">
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" v-model="field.required" name="required"> {{__("l.Required")}}
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary w-150"><i class="fa fa-save"></i> <span>{{__("l.Save")}}</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="float-right">
                    <div class="input-group w-200">
                        <select v-model="type" class="form-control">
                            <option value="All">{{__("l.All")}}</option>
                            <option v-for="model in models" :value="model">{{__("l."+model)}}</option>
                        </select>
                    </div>
                </div>
                <div class="clearfix mb-2"></div>
                <table class="table table-bordered table-striped table-hover small">
                    <thead>
                    <tr>
                        <th class="text-center" width="30">#</th>
                        <th>{{__("l.Belongs To")}}</th>
                        <th>{{__("l.Name")}}</th>
                        <th>{{__("l.Type")}}</th>
                        <th>{{__("l.Width")}}</th>
                        <th>{{__("l.Placeholder")}}</th>
                        <th>{{__("l.Required")}}</th>
                        <th width="100" class="text-center">{{__("l.Actions")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-show="type=='All'||field.model==type" v-for="(field, i) in custom_fields">
                        <td class="text-center">{{i+1}}</td>
                        <td>
                            <a data-toggle="modal" href="" @click="highlight_field_id=field.id" :data-target="'#custom_fields_'+field.model">
                                <div>{{__('l.'+field.model)}}</div>
                                <small v-if="field.model=='Contact'">
                                        <span v-if="field.group_id">
                                            <span v-if="field.group">{{field.group.name}}</span>
                                            <span v-else><span class="text-danger">{{__("l.Error")}}</span></span>
                                        </span>
                                    <span v-else><span>{{__("l.All Groups")}}</span></span>
                                </small>
                            </a>
                        </td>
                        <td>{{field.name}}</td>
                        <td>
                            <div>{{__('l.'+field.type)}}</div>
                            {{(field.options)}}
                        </td>
                        <td>
                            <span v-if="field.width==12">{{__("l.Full Width")}} (100%)</span>
                            <span v-if="field.width==9">{{__("l.Three-quarters")}} (3/4)</span>
                            <span v-if="field.width==6">{{__("l.Half Width")}} (1/2)</span>
                            <span v-if="field.width==4">{{__("l.One Third")}} (1/3)</span>
                            <span v-if="field.width==3">{{__("l.ِQuarter")}} (1/4)</span>
                        </td>
                        <td>{{field.placeholder}}</td>
                        <td class="text-center">
                            <span v-if="field.required" class="text-danger">{{__("l.Required")}}</span>
                            <span v-else class="text-success">{{__("l.Optional")}}</span>
                        </td>
                        <td class="text-center align-middle">
                            <a href="#" data-toggle="modal" @click="highlight_field_id=field.id" :data-target="'#custom_fields_'+field.model" class="btn btn-block btn-info btn-xs"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></a>
                            <a href="#" data-toggle="modal" @click="edit_modal(field)" data-target="#custom_fields_save" class="btn btn-block btn-success btn-xs"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></a>
                            <Inertia-link v-on:click="delete_confirm" :href="route('settings.custom_fields_delete',field.id)" class="btn btn-block btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div v-for="model in models" class="modal fade view" :id="'custom_fields_'+model">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title" id="exampleModalLabel">{{__("l.Custom Fields")}} : {{__("l."+model)}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <view-custom-fields :custom_fields="custom_fields" :model="model" :highlight_field_id="highlight_field_id"></view-custom-fields>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </index>
</template>

<script>

import index from "../index"
import service from "../../../../service"
import Multiselect from 'vue-multiselect'
import ViewCustomFields from "./view"

export default {
    components:{
        index,
        Multiselect,
        ViewCustomFields
    },
    props: ["custom_fields", "contact_groups"],
    data() {
        return {
            highlight_field_id: null,
            models: ["Client", "Contact"],
            type: "All",
            action: "add",
            field: Object,
            empty_field: {model: "", group_id: "" , name: "", order: 0, placeholder:"", type: "", options: [], required:false, width: "12"},
        }
    },
    mounted(){
        this.field = this.empty_field
    },
    methods: {
        add_modal(){
            this.action = 'add'
            this.field = this.empty_field
        },
        edit_modal(field){
            this.action = 'edit'
            this.field = field
            this.field.group_id = (field.group_id && field.group_id!="") ? field.group_id : ""
        },
        addTag (newTag) {
            this.field.options.push(newTag)
        },
        custom_fields_save(e) {
            var data = new FormData(document.getElementById("custom_fields_save"));
            if(this.field.options && this.field.options.length>0)
                data.append("options", this.field.options.join(","))
            $("#custom_fields_save").modal("hide");
            this.$inertia.post(this.route("settings.custom_fields_save"), data, {preserveState: false, preserveScroll: true})
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
