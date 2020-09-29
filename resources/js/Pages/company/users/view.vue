<template>
    <Company :title="breadcrumb.title" :breadcrumb="breadcrumb">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.User Details") }}</h3>
                <Inertia-link :href="route('users.index')" class="btn btn-xs btn-primary float-right"><i class="fa fa-list"></i> <span>{{__("l.Users List")}}</span></Inertia-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Account -->
                    <div class="col-sm-12 text-center mb-4">
                        <img v-if="user.image" :src="asset('storage/app/'+ user.image)" class="image-wrapper" />
                        <img v-else :src="asset('public/no-image.png')" class="image-wrapper" />
                        <h4>{{user.name}}</h4>
                        <h6>{{user.email}}</h6>
                    </div>
                    <!-- Professional -->
                    <div class="col-sm-6">
                        <div class="card card-primary">
                            <div class="card-header">{{__("l.Professional")}}</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><span>{{__("l.Role")}} : </span></label>
                                    {{(user.role)?user.role.name:''}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Designation")}} : </span></label>
                                    {{ (user.designation)?user.designation.name:''}}
                                </div>
                                <div class="form-group">
                                    <label>{{__("l.Department")}} : </label>
                                    {{(user.department)?user.department.name:''}}
                                </div>
                                <div class="form-group">
                                    <label>{{__("l.Manager")}} : </label>
                                    {{ (user.manager)?user.manager.name:''}}
                                </div>
                                <div class="form-group">
                                    <label>{{__("l.Workplace")}} : </label>
                                    {{user.workplace}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact -->
                    <div class="col-sm-6">
                        <div class="card card-primary">
                            <div class="card-header">{{__("l.Contact")}}</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><span>{{__("l.Phone")}} : </span></label>
                                    {{user.phone}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Mobile")}} : </span></label>
                                    {{user.mobile}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Emergency Contact")}} : </span></label>
                                    {{user.emergency_contact}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- Personal -->
                        <div class="card card-primary">
                            <div class="card-header">{{__("l.Personal")}}</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><span>{{__("l.Gender")}} : </span></label>
                                    {{(user.gender)?__("l."+ user.gender):''}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Civil Status")}} : </span></label>
                                    {{(user.civil_status)?__("l."+ user.civil_status):''}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Number Of Children")}} : </span></label>
                                    {{(user.number_of_children)?user.number_of_children:''}}
                                </div>
                            </div>
                        </div>
                        <!-- Education -->
                        <div class="card card-primary">
                            <div class="card-header">{{__("l.Education")}}</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><span>{{__("l.Certificate Level")}} : </span></label>
                                    {{ (user.certificate_level)?__("l."+ user.certificate_level):''}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Field Of Study")}} : </span></label>
                                    {{user.field_of_study}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.University")}} : </span></label>
                                    {{user.university}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Citizenship -->
                    <div class="col-sm-6">
                        <div class="card card-primary">
                            <div class="card-header">{{__("l.Contact")}}</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><span>{{__("l.Nationality")}} : </span></label>
                                    <span v-if="v == user.nationality" v-for="(k, v) in countries()" :value="v">{{k}}</span>
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.N° Identification")}} : </span></label>
                                    {{user.num_identification}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.N° Passport")}} : </span></label>
                                    {{user.num_passport}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Date Of Birth")}} : </span></label>
                                    {{user.date_of_birth}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Place Of Birth")}} : </span></label>
                                    {{user.place_of_birth}}
                                </div>
                                <div class="form-group">
                                    <label><span>{{__("l.Native Country")}} : </span></label>
                                    <span v-if="v == user.native_country" v-for="(k, v) in countries()" :value="v">{{k}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Company>
</template>

<script>

import Company from "../layout/Company";

export default {
    components:{
        Company
    },
    props: ["breadcrumb", "user"],
}
</script>

<style scoped>
.form-group{
    margin-bottom: 10px !important;
}
.image-wrapper {
    width: 160px;
    height: 160px;
    border: 1px solid #ced4da;
    display: block;
    margin: 0px auto 10px;
    border-radius: 50%;
}
</style>
