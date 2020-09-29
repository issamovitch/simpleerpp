<template>
    <Company :title="breadcrumb.title" :breadcrumb="breadcrumb">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Users List") }}</h3>
                <div class="float-right">
                    <a href="#" v-on:click.prevent="view_users(false)" :class="{'btn-primary': !table_users, 'btn-default': table_users}" class="btn-grid btn btn-xs float-right"><i class="fa fa-th-large"></i></a>
                    <a href="#" v-on:click.prevent="view_users(true)" :class="{'btn-primary': table_users, 'btn-default': !table_users}" class="btn-table btn btn-xs float-right ml-3"><i class="fa fa-list"></i></a>
                    <Inertia-link :href="route('users.add')" class="btn btn-xs btn-primary float-right"><i class="fa fa-plus"></i> <span>{{__("l.Add User")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body">
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
                        <tr v-for="(user, i) in users">
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
                                <a v-if="$page.auth.user.id!=user.id" href="users/delete" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></a>
                                <a v-else href="#" disabled="" class="btn btn-danger disabled btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="!table_users" id="grid-users">
                    <div class="row">
                        <div v-for="user in users" class="col-sm-4 user">
                            <div class="card p-2 position-relative" style="height: 120px;">
                                <a href="" data-toggle="dropdown" class="dropdown-toggle position-absolute" style="z-index: 2; top: 3px; right: 4px; color: #d0d0d0; font-size: 0.9em;"><i class="fa fa-cog"></i></a>
                                <div class="dropdown-menu">
                                    <Inertia-link :href="route('users.view', user.id)" class="dropdown-item text-gray"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></Inertia-link>
                                    <Inertia-link :href="route('users.edit', user.id)" class="dropdown-item text-gray"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></Inertia-link>
                                    <a v-if="$page.auth.user.id!=user.id" href="users/delete" class="delete_user dropdown-item text-gray"><i class="fa fa-trash"></i> <span>Delete</span></a>
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
    </Company>
</template>


<script>

import Company from "../layout/Company";

export default {
    props:["breadcrumb", "users"],
    data(){
        return{
            table_users: (localStorage.table_users) ? (localStorage.table_users==='true') ? true : false : true,
        }
    }, components: {
        Company,
    }, methods :{
        view_users(boolean){
            this.table_users= boolean;
            localStorage.table_users= boolean
        }
    }
}
</script>

<style>

.user-image-list {
    width: 60px !important;
    height: 60px !important;
}
.user-image-grid{
    border: 1px solid #d5d5d5;
    width: 100%;
    height: 80px;
}
</style>
