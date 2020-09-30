<template>
    <company :title="__('l.Users')" :current="__('l.Users List')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Users List") }}</h3>
                <div class="float-right">
                    <a href="#" v-on:click.prevent="view_users(false)" :class="{'btn-primary': !table_users, 'btn-default': table_users}" class="btn-grid btn btn-xs float-right"><i class="fa fa-th-large"></i></a>
                    <a href="#" v-on:click.prevent="view_users(true)" :class="{'btn-primary': table_users, 'btn-default': !table_users}" class="btn-table btn btn-xs float-right ml-3"><i class="fa fa-list"></i></a>
                    <Inertia-link :href="route('users.add')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-plus"></i> <span>{{__("l.Add User")}}</span></Inertia-link>
                    <div class="dropdown float-right ml-3">
                        <button v-on:click="show_filter=!show_filter" class="btn btn-xs btn-primary w-150"><i class="fa fa-filter"></i> <span>{{__("l.Filters")}}</span></button>
                        <div v-if="show_filter && table_users" id="dropdownMenuButton">
                            <div class="input-group">
                                <div class="input-group-prepend w-120">
                                    <span class="input-group-text w-120">{{__("l.Filter By")}}</span>
                                </div>
                                <select class="form-control" v-on:change="select_filter_types">
                                    <option value="">{{__("l.Choose")}}</option>
                                    <option v-bind:disabled="name_do_filter" value="name">{{__("l.Name")}}</option>
                                    <option v-bind:disabled="email_do_filter" value="email">{{__("l.Email")}}</option>
                                    <option v-bind:disabled="role_do_filter" value="role">{{__("l.Role")}}</option>
                                    <option v-bind:disabled="designation_do_filter" value="designation">{{__("l.Designation")}}</option>
                                    <option v-bind:disabled="department_do_filter" value="department">{{__("l.Department")}}</option>
                                    <option v-bind:disabled="manager_do_filter" value="manager">{{__("l.Manager")}}</option>
                                    <option v-bind:disabled="nationality_do_filter" value="nationality">{{__("l.Nationality")}}</option>
                                    <option v-bind:disabled="gender_do_filter" value="gender">{{__("l.Gender")}}</option>
                                    <option v-bind:disabled="civil_status_do_filter" value="civil_status">{{__("l.Civil Status")}}</option>
                                </select>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="name_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Name")}}</div></div>
                                    <input v-model="name_filter" type="text" class="form-control" :placeholder="__('l.Name')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="name_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="email_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Email")}}</div></div>
                                    <input v-model="email_filter" type="text" class="form-control" :placeholder="__('l.Email')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#" v-on:click.prevent="email_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="role_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Role")}}</div></div>
                                    <select v-model="role_filter" class="form-control" :placeholder="__('l.Role')" autocomplete="off">
                                        <option value="">{{__("l.Role")}}</option>
                                        <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#" v-on:click.prevent="role_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="designation_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Designation")}}</div></div>
                                    <select v-model="designation_filter" class="form-control" :placeholder="__('l.Designation')" autocomplete="off">
                                        <option value="">{{__("l.Designation")}}</option>
                                        <option v-for="designation in designations" :value="designation.id">{{designation.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#" v-on:click.prevent="designation_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="department_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Department")}}</div></div>
                                    <select v-model="department_filter" class="form-control" :placeholder="__('l.Department')" autocomplete="off">
                                        <option value="">{{__("l.Department")}}</option>
                                        <option v-for="department in departments" :value="department.id">{{department.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#" v-on:click.prevent="department_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="manager_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Manager")}}</div></div>
                                    <select v-model="manager_filter" class="form-control filter" :placeholder="__('l.Manager')" autocomplete="off">
                                        <option value="">{{__("l.Manager")}}</option>
                                        <option v-for="user in users" :value="user.id">{{user.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"  v-on:click.prevent="manager_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="nationality_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Nationality")}}</div></div>
                                    <select v-model="nationality_filter" class="form-control" :placeholder="__('l.Nationality')" autocomplete="off">
                                        <option value="">{{__("l.Nationality")}}</option>
                                        <option v-for="(k, v) in countries()" :value="v">{{k}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#" v-on:click.prevent="nationality_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="gender_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Gender")}}</div></div>
                                    <select v-model="gender_filter" class="form-control" :placeholder="__('l.Gender')" autocomplete="off">
                                        <option value="">{{__("l.Gender")}}</option>
                                        <option value="Male">{{__("l.Male")}}</option>
                                        <option value="Female">{{__("l.Female")}}</option>
                                        <option value="Other">{{__("l.Other")}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#" v-on:click.prevent="gender_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="civil_status_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Civil Status")}}</div></div>
                                    <select v-model="civil_status_filter" class="form-control" :placeholder="__('l.Civil Status')" autocomplete="off">
                                        <option value="">{{__("l.Civil Status")}}</option>
                                        <option value="Single">{{__("l.Single")}}</option>
                                        <option value="Married">{{__("l.Married")}}</option>
                                        <option value="Cohabitant">{{__("l.Cohabitant")}}</option>
                                        <option value="Widower">{{__("l.Widower")}}</option>
                                        <option value="Divorced">{{__("l.Divorced")}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#" v-on:click.prevent="civil_status_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="min-height: 500px">
                <table v-if="table_users" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th width="100">{{ __("l.Image") }}</th>
                        <th>{{ __("l.Name") }}</th>
                        <th>{{ __("l.Email") }}</th>
                        <th>{{ __("l.Role") }}</th>
                        <th>{{ __("l.Designation") }}</th>
                        <th width="200">{{ __("l.Actions") }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, i) in filtered_users" v-if="filtered_users.length>0">
                            <td class="text-center align-middle">{{ i + 1 }}</td>
                            <td class="align-middle">
                                <Inertia-link :href="route('users.view', user.id)">
                                    <img v-if="user.image" :src="asset('/storage/app/'+user.image)" alt="" class="img-thumbnail user-image-list">
                                    <img v-else :src="asset('public/no-image.png')" alt="" class="img-thumbnail user-image-list">
                                </Inertia-link>
                            </td>
                            <td class="align-middle"><Inertia-link :href="route('users.view', user.id)">{{ user.name }}</Inertia-link></td>
                            <td class="align-middle">{{user.email}}</td>
                            <td class="align-middle">{{(user.role)?user.role.name:''}}</td>
                            <td class="align-middle">{{(user.designation)?user.designation.name:''}}</td>
                            <td class="text-center align-middle">
                                <Inertia-link :href="route('users.view', user.id)" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></Inertia-link>
                                <Inertia-link :href="route('users.edit', user.id)" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></Inertia-link>
                                <a v-if="$page.auth.user.id!=user.id" href="#" v-on:click.prevent="delete_user(user.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></a>
                                <a v-else href="#" disabled="" class="btn btn-danger disabled btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></a>
                            </td>
                        </tr>
                        <tr v-if="filtered_users.length==0">
                            <td colspan="7" class="text-center"><b>{{__("l.No Data")}}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="!table_users" id="grid-users">
                    <div class="row">
                        <div v-for="user in filtered_users" class="col-sm-4 user">
                            <div class="card p-2 position-relative" style="height: 120px;">
                                <a href="" data-toggle="dropdown" class="dropdown-toggle position-absolute" style="z-index: 2; top: 3px; right: 4px; color: #d0d0d0; font-size: 0.9em;"><i class="fa fa-cog"></i></a>
                                <div class="dropdown-menu">
                                    <Inertia-link :href="route('users.view', user.id)" class="dropdown-item text-gray"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></Inertia-link>
                                    <Inertia-link :href="route('users.edit', user.id)" class="dropdown-item text-gray"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></Inertia-link>
                                    <a v-if="$page.auth.user.id!=user.id" href="#" v-on:click.prevent="delete_user(user.id)" class="dropdown-item text-gray"><i class="fa fa-trash"></i> <span>Delete</span></a>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <Inertia-link :href="route('users.view', user.id)">
                                            <img v-if="user.image" :src="asset('/storage/app/'+user.image)" alt="" class="user-image-grid">
                                            <img v-else :src="asset('public/no-image.png')" alt="" class="user-image-grid">
                                        </Inertia-link>
                                    </div>
                                    <div class="col-sm-9">
                                        <h6><Inertia-link :href="route('users.view', user.id)"><b class="text-dark">{{user.name}}</b></Inertia-link></h6>
                                        <h6>{{user.email}}</h6>
                                        <h6>{{(user.role)?user.role.name:''}}</h6>
                                        <h6>{{(user.designation)?user.designation.name:''}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="backdrop" v-if="show_filter" @click="show_filter=false"></div>
    </company>
</template>


<script>

import company from "../layout/company"
import service from "../../../service";

export default {
    props:["users", "roles", "designations", "departments"],
    computed:{
        filtered_users(){
            return this.users.filter(user =>{
                if(this.name_do_filter && this.name_filter != "")
                    if(!user.name.includes(this.name_filter))
                        return false
                if(this.email_do_filter && this.email_filter != "")
                    if(!user.email.includes(this.email_filter))
                        return false
                if(this.role_do_filter && this.role_filter)
                    if(user.role_id != this.role_filter)
                        return false
                if(this.designation_do_filter && this.designation_filter)
                    if(user.designation_id != this.designation_filter)
                        return false
                if(this.department_do_filter && this.department_filter)
                    if(user.department_id != this.department_filter)
                        return false
                if(this.manager_do_filter && this.manager_filter)
                    if(user.manager_id != this.manager_filter)
                        return false
                if(this.nationality_do_filter && this.nationality_filter)
                    if(user.nationality != this.nationality_filter)
                        return false
                if(this.gender_do_filter && this.gender_filter)
                    if(user.gender != this.gender_filter)
                        return false
                if(this.civil_status_do_filter && this.civil_status_filter)
                    if(user.civil_status != this.civil_status_filter)
                        return false
                return true
            })
        }
    },
    data(){
        return{
            show_filter : false,
            name_do_filter: false,
            name_filter : "",
            email_do_filter : false,
            email_filter : "",
            role_do_filter: false,
            role_filter : "",
            designation_do_filter : false,
            designation_filter : "",
            department_do_filter : false,
            department_filter : "",
            manager_do_filter : false,
            manager_filter : "",
            nationality_do_filter : false,
            nationality_filter : "",
            gender_do_filter : false,
            gender_filter : "",
            civil_status_do_filter : false,
            civil_status_filter : "",
            table_users: (localStorage.table_users) ? (localStorage.table_users==='true') ? true : false : true,
        }
    }, components: {
        company,
    }, methods :{
        view_users(boolean){
            this.table_users= boolean;
            localStorage.table_users= boolean
        },
        async delete_user(id){
            let url = this.route("users.delete", id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
        select_filter_types(e){
            if(e.target.value){
                this[e.target.value+"_do_filter"] = true;
            }
        }
    }
}

</script>

<style>

    .dropdown-toggle::after{
        display: none;
    }

    #dropdownMenuButton{
        width: 400px;
        border: 1px solid #eee;
        padding: 10px;
        position: absolute;
        left: -100px;
        background: #fff;
        z-index: 10401;
    }

    .backdrop{
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1040;
        width: 100vw;
        height: 100vh;
    }

</style>
