<template>
    <company :title="__('l.Users')" :pn="__('l.Users List')" :pl="route('users.index')" :current="__('l.Add User')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Add User") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('users.index')" class="btn btn-xs btn-primary float-right"><i class="fa fa-list"></i> <span>{{__("l.Users List")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body">
                <form v-on:submit.prevent="save_user" id="add_user" enctype="multipart/form-data">
                    <form-wizard title="" subtitle="" color="#007bff" @on-complete="save_user">
                        <!-- Account -->
                        <tab-content :title="__('l.Account')" icon="fa fa-user" :before-change="validateAccount">
                            <div class="row">
                                <div class="col-sm-10 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                                                <input type="text" ref="name" v-model="name" class="form-control" name="name" required autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label><span>{{__("l.Email")}}</span> <span class="text-danger">*</span></label>
                                                <input type="email" ref="email" v-model="email" class="form-control" name="email" required
                                                       readonly onfocus="this.removeAttribute('readonly');">
                                            </div>
                                            <div class="form-group">
                                                <label><span>{{__("l.Password")}}</span> <span class="text-danger">*</span></label>
                                                <input type="password" ref="password" v-model="password" class="form-control" name="password" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span>{{__("l.Role")}}</span> <span class="text-danger">*</span></label>
                                                <select class="form-control" ref="role_id" v-model="role_id" name="role_id" required>
                                                    <option value="">{{__("l.Choose")}}</option>
                                                    <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label><span>{{__("l.Image")}}</span></label>
                                                <input type="file" class="form-control" @change="previewFiles" ref="file" name="image" accept="image/*" style="display: none">
                                                <img :src="asset('public/no-image.png')" ref="image" v-on:click="$refs.file.click()" class="image_user_add" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tab-content>
                        <!-- Professional -->
                        <tab-content :title="__('l.Professional')" icon="fa fa-briefcase">
                            <div class="row">
                                <div class="col-sm-10 mx-auto">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span>{{__("l.Designation")}}</span></label>
                                                <div class="input-group">
                                                    <select class="form-control" name="designation_id" id="designation_id">
                                                        <option value="">{{__("l.Choose")}}</option>
                                                        <option v-for="designation in designations" :value="designation.id">{{designation.name}}</option>
                                                    </select>
                                                    <div class="input-group-prepend">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#add_designation"><i class="fa fa-plus"></i></button>
                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__("l.Department")}}</label>
                                                <div class="input-group">
                                                    <select name="department_id" class="form-control" id="department_id">
                                                        <option value="">{{__("l.Choose")}}</option>
                                                        <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                                                    </select>
                                                    <div class="input-group-prepend">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#add_department"><i class="fa fa-plus"></i></button>
                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>{{__("l.Manager")}}</label>
                                                <select name="manager_id" class="form-control">
                                                    <option value="">{{__("l.Choose")}}</option>
                                                    <option v-for="user in users" :value="user.id">{{user.name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>{{__("l.Workplace")}}</label>
                                                <textarea name="workplace" class="form-control" style="height: 208px;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tab-content>
                        <!-- Contact -->
                        <tab-content  :title="__('l.Contact')" icon="fa fa-at">
                            <div class="row">
                                <div class="col-sm-10 mx-auto">
                                    <div class="form-group">
                                        <label><span>{{__("l.Phone")}}</span></label>
                                        <input type="text" class="form-control" name="phone" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label><span>{{__("l.Mobile")}}</span></label>
                                        <input type="text" class="form-control" name="mobile" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                <label><span>{{__("l.Emergency Contact")}}</span></label>
                                <textarea class="form-control" rows="1" name="emergency_contact" autocomplete="off"></textarea>
                            </div>
                                </div>
                            </div>
                        </tab-content>
                        <!-- Personal -->
                        <tab-content  :title="__('l.Personal')" icon="fa fa-users">
                            <div class="row">
                                <div class="col-sm-10 mx-auto">
                                    <div class="form-group">
                                        <label><span>{{__("l.Gender")}}</span></label>
                                        <select class="form-control" name="gender" autocomplete="off">
                                            <option value="">{{__("l.Choose")}}</option>
                                            <option value="Male">{{__("l.Male")}}</option>
                                            <option value="Female">{{__("l.Female")}}</option>
                                            <option value="Other">{{__("l.Other")}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><span>{{__("l.Civil Status")}}</span></label>
                                        <select class="form-control" name="civil_status" autocomplete="off">
                                            <option value="">{{__("l.Choose")}}</option>
                                            <option value="Single">{{__("l.Single")}}</option>
                                            <option value="Married">{{__("l.Married")}}</option>
                                            <option value="Cohabitant">{{__("l.Cohabitant")}}</option>
                                            <option value="Widower">{{__("l.Widower")}}</option>
                                            <option value="Divorced">{{__("l.Divorced")}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><span>{{__("l.Number Of Children")}}</span></label>
                                        <input type="number" class="form-control" value="0" name="number_of_children" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </tab-content>
                        <!-- Citizenship -->
                        <tab-content  :title="__('l.Citizenship')" icon="fa fa-globe">
                            <div class="row">
                                <div class="col-sm-10 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span>{{__("l.Nationality")}}</span></label>
                                                <select class="form-control" name="nationality" autocomplete="off">
                                                    <option value="">{{__("l.Choose")}}</option>
                                                    <option v-for="(k, v) in countries()" :value="v">{{k}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label><span>{{__("l.N° Identification")}}</span></label>
                                                <input type="text" class="form-control" name="num_identification" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label><span>{{__("l.N° Passport")}}</span></label>
                                                <input type="text" class="form-control" name="num_passport" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label><span>{{__("l.Date Of Birth")}}</span></label>
                                                <input type="date" class="form-control" name="date_of_birth" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label><span>{{__("l.Place Of Birth")}}</span></label>
                                                <input type="text" class="form-control" name="place_of_birth" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label><span>{{__("l.Native Country")}}</span></label>
                                                <select class="form-control" name="native_country" autocomplete="off">
                                                    <option value="">{{__("l.Choose")}}</option>
                                                    <option v-for="(k, v) in countries()" :value="v">{{k}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tab-content>
                        <!-- Education -->
                        <tab-content  :title="__('l.Education')" icon="fa fa-book">
                            <div class="row">
                                <div class="col-sm-10 mx-auto">
                                    <div class="form-group">
                                        <label><span>{{__("l.Certificate Level")}}</span></label>
                                        <select class="form-control" name="certificate_level" autocomplete="off">
                                            <option value="">{{__("l.Choose")}}</option>
                                            <option value="Bachelor">{{__("l.Bachelor")}}</option>
                                            <option value="Master">{{__("l.Master")}}</option>
                                            <option value="Other">{{__("l.Other")}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><span>{{__("l.Field Of Study")}}</span></label>
                                        <input type="text" class="form-control" name="field_of_study" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <label><span>{{__("l.University")}}</span></label>
                                        <input type="text" class="form-control" name="university" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </tab-content>
                        <!-- Footer -->
                        <template slot="footer" slot-scope="props">
                            <div class="wizard-footer-left">
                                <wizard-button class="btn btn-primary" v-if="props.activeTabIndex > 0 && !props.isLastStep" @click.native="props.prevTab()" :style="props.fillButtonStyle"><i class="fa fa-arrow-left"></i> <span>{{__('l.Back')}}</span></wizard-button>
                            </div>
                            <div class="wizard-footer-right">
                                <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()" class="btn btn-primary wizard-footer-right w-150" :style="props.fillButtonStyle"><i class="fa fa-arrow-right"></i> <span>{{__('l.Next')}}</span></wizard-button>
                                <wizard-button v-if="props.isLastStep||props.activeTabIndex==0" @click.native="save_user" class="btn btn-primary wizard-footer-right mr-2" :style="props.fillButtonStyle"><i class="fa fa-save"></i> <span>{{__('l.Submit')}}</span></wizard-button>
                            </div>
                        </template>
                        <!-- End Footer -->
                    </form-wizard>
                </form>
            </div>
        </div>
        <form v-on:submit.prevent="designations_save" class="modal fade" id="add_designation">
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
        <form v-on:submit.prevent="departments_save" class="modal fade" id="add_department">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"><h4 class="modal-title">{{ __("l.Add Department") }}</h4>
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
    </Company>
</template>

<script>

import company from "../layout/company"
// VueFormWizard
import {FormWizard, TabContent, WizardButton} from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'

export default {
    components: {
        company,
        FormWizard,
        TabContent,
        WizardButton
    },
    props:["users", "roles", "designations", "departments"],
    data(){
        return{
            name: null,
            email: null,
            password: null,
            role_id: null,
        }
    },
    mounted() {
        $("#add_user input, #add_user select").on("change keyup", this.changeField)
    },
    methods: {
        changeField(e){
            e.target.classList.value = e.target.classList.value.replace("is-invalid", "")
        },
        previewFiles(e) {
            let file = e.target.files[0];
            this.$refs.image.src = URL.createObjectURL(file);
        },
        handleErrorField(field){
            this.$refs[field].focus()
            this.$refs[field].classList.value = this.$refs[field].classList.value + ' is-invalid'
        },
        validateAccount (){
            this.$toastr.remove()
            if(!this.name){
                this.$toastr.error(this.__("l.Name")+" "+this.__("l.is required"));
                this.handleErrorField("name")
                return false
            }
            if(!this.email){
                this.$toastr.error(this.__("l.Email")+" "+this.__("l.is required"));
                this.handleErrorField("email")
                return false
            }else{
                if(!this.validateEmail(this.email)){
                    this.$toastr.error(this.__("l.Email")+" "+this.__("l.is not an email"));
                    this.handleErrorField("email")
                    return false
                }
            }
            if(!this.password){
                this.$toastr.error(this.__("l.Password")+" "+this.__("l.is required"));
                this.handleErrorField("password")
                return false
            }
            if(!this.role_id){
                this.$toastr.error(this.__("l.Role")+" "+this.__("l.is required"));
                this.handleErrorField("role_id")
                return false
            }
            return true
        },
        validateEmail(email) {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        save_user(){
            var data = new FormData(document.getElementById("add_user"));
            this.$inertia.post(this.route("users.save"), data, {preserveState: true})
        },
        designations_save(e){
            var id   = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#"+id).modal("hide");
            axios.post(this.route("users.designations_save"), data).then(res=>{
                $("#designation_id").append('<option value="'+res.data.id+'">'+res.data.name+'</option>')
                $("#designation_id").val(res.data.id)
            }).catch(e=>console.error(e))
        },
        departments_save(e){
            var id   = e.target.getAttribute("id");
            var data = new FormData(document.getElementById(id));
            $("#"+id).modal("hide");
            axios.post(this.route("users.departments_save"), data).then(res=>{
                $("#department_id").append('<option value="'+res.data.id+'">'+res.data.name+'</option>')
                $("#department_id").val(res.data.id)
            }).catch(e=>console.error(e))
        }
    }
}

</script>

<style>
    .image_user_add{
        width: 122px;
        height: 122px;
        border: 1px solid #d2d2d2;
        cursor: pointer;
        display: block;
    }
    .vue-form-wizard{
        margin-top: 10px;
    }
    .vue-form-wizard .wizard-header{
        display: none !important;
    }
    .vue-form-wizard  li:not(.active) .wizard-icon{
        color: #0069d9 !important;
    }
    .vue-form-wizard .wizard-icon-container:hover{
        background-color: #0069d9 !important;
    }
    .vue-form-wizard .wizard-icon-circle {
        border-color: #007bff !important;
    }
    .vue-form-wizard .stepTitle{
        color: #007bff !important;
        margin-top: 10px;
        font-weight: bold;
    }
    .vue-form-wizard .wizard-card-footer{
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
        margin: 10px auto 0px;
        padding: 0px;
    }
    .vue-form-wizard .w-150{
        width: 150px;
    }
</style>

