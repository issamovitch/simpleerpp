<template>
    <company :title="__('l.Projects')" :current="__('l.Projects List')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Projects List") }}</h3>
                <div class="float-right">
                    <inertia-link :href="route('projects.add')" class="btn btn-xs float-right btn-primary ml-2"><i class="fa fa-plus"></i> {{__("l.Add Project")}}</inertia-link>
                </div>
            </div>
            <div class="card-body pb-5" style="min-height: 600px">
                <div class="mb-5">
                    <h4>{{__("l.Projects Summary")}}</h4>
                    <div class="row mt-4 mb-2">
                        <div v-if="i!=0" v-for="(status, i) in statuses" class="col-sm-2" :class="{'border-right': i!=5}">
                            <a href="#" @click.prevent="status_filter=i"><h3>{{projects_statuses_count[i]}}</h3></a>
                            <br>
                            <div :class="'text-'+statuses[i][0]">{{statuses[i][1]}}</div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover mb-5" id="projects">
                    <thead>
                        <tr>
                            <th><input type="text" class="form-control" v-model="name_filter" :placeholder="__('l.Name')"></th>
                            <th>
                                <select class="form-control" v-model="client_filter">
                                    <option value="">{{__("l.Customer")}}</option>
                                    <option v-for="client in clients" :value="client.id">{{client.name}}</option>
                                </select>
                            </th>
                            <th>
                                <select class="form-control" v-model="member_filter">
                                    <option value="">{{__("l.Members")}}</option>
                                    <option v-for="user in users" :value="user.id">{{user.name}}</option>
                                </select>
                            </th>
                            <th>{{__("l.Start Date")}}</th>
                            <th>{{__("l.Deadline")}}</th>
                            <th>{{__("l.Progress")}}</th>
                            <th>
                                <select class="form-control" v-model="status_filter">
                                    <option value="">{{__("l.Status")}}</option>
                                    <option value="1">{{__("l.New")}}</option>
                                    <option value="2">{{__("l.In Progress")}}</option>
                                    <option value="3">{{__("l.Completed")}}</option>
                                    <option value="4">{{__("l.Delayed")}}</option>
                                    <option value="5">{{__("l.Canceled")}}</option>
                                </select>
                            </th>
                            <th width="140">
                                <button @click="reset_filter" class="btn btn-block btn-dark"><i class="fa fa-sync-alt"></i> {{__("l.Refresh")}}</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="filtered_projects.length>0">
                        <tr v-for="(project, i) in filtered_projects">
                            <td class="align-middle">
                                <div>{{project.name}}</div>
                                <div v-if="project.labels_array.length>0">
                                    <div  class="badge badge-primary bg-lightblue mr-1" v-for="label in project.labels_array">{{label}}</div>
                                </div>
                            </td>
                            <td>
                                <inertia-link v-if="project.client" :href="route('clients.view', project.client)" >
                                    <img v-if="project.client.image" :src="asset('storage/app/'+project.client.image)" class="member-image elevation-2" :title="project.client.name" />
                                    <img v-else :src="asset('public/no-image.png')" class="member-image elevation-2" :title="project.client.name" />
                                    <span>{{project.client.name}}</span>
                                </inertia-link>
                            </td>
                            <td>
                                <inertia-link :key="'member'+member.id" :href="route('users.view', member.id)"  v-for="member in project.members">
                                    <img v-if="member.image" :src="asset('storage/app/'+member.image)" class="member-image elevation-2" :title="member.name" />
                                    <img v-else :src="asset('public/no-image.png')" class="member-image elevation-2" :title="member.name" />
                                </inertia-link>
                            </td>
                            <td class="text-center align-middle">{{project.start_date}}</td>
                            <td class="text-center align-middle"><div :class="{'text-danger': project.deadline_pass}">{{project.deadline}}</div></td>
                            <td class="text-center align-middle" :title="project.progress+'%'">
                                <div class="progress progress-sm">
                                    <div :class="(project.progress==0)?'bg-danger':(project.progress==100)?'bg-success':'bg-warning'" class="progress-bar":style="'width: '+project.progress+'%'">
                                        <small class="text-white">{{project.progress}}%</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="status d-block" :class="'bg-'+statuses[project.status][0]">{{statuses[project.status][1]}}</div>
                            </td>
                            <td class="text-center align-middle">
                                <inertia-link :href="route('projects.edit', project.id)" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> {{__("l.Edit")}}</inertia-link>
                                <a href="#" @click.prevent="delete_project(project.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> {{__("l.Delete")}}</a>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr>
                            <td class="text-center" colspan="8">{{__("l.No Data")}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </company>
</template>

<script>

import company from "../layout/company"
import service from "../../../service"
import moment from 'moment'

export default {
    components: {
        company,
    },
    props: ["projects", "clients", "users"],
    data(){
        return {
            statuses: [["", ""], ["primary", this.__("l.New")], ["warning", this.__("l.In Progress")], ["success", this.__("l.Completed")], ["info", this.__("l.Delayed")], ["danger", this.__("l.Canceled")]],
            name_filter: "",
            status_filter: "",
            client_filter: "",
            member_filter: "",
            projects_statuses_count: []
        }
    },
    computed: {
        filtered_projects(){
            this.projects_statuses_count= [0, 0, 0, 0, 0, 0]
            return this.projects.filter(project => {
                this.projects_statuses_count[project.status] += 1
                project.labels_array = []
                if(project.labels && project.labels!="")
                    project.labels_array = project.labels.split(";;;")
                project.members_ids = []
                project.members.forEach(member => project.members_ids.push(member.id))
                project.deadline_pass= false
                if(project.deadline && project.deadline!="")
                    if(moment(project.deadline)<=moment())
                        project.deadline_pass= true
                // Filters
                if (this.name_filter != "")
                    if (!project.name.includes(this.name_filter) && !project.labels.includes(this.name_filter))
                        return false
                if (this.status_filter != "")
                    if (project.status!=this.status_filter)
                        return false
                if (this.client_filter != "")
                    if (project.client_id!=this.client_filter)
                        return false
                if (this.member_filter != "")
                    if (!project.members_ids.includes(this.member_filter))
                        return false
                return true
            })
        }
    },
    methods: {
        reset_filter(){
            this.name_filter= ""
            this.status_filter= ""
            this.client_filter= ""
            this.member_filter= ""
        },
        async delete_project(id){
            let url = route('projects.delete', id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}
</script>

<style scoped>
#projects .member-image {
    border-radius: 50%;
    height: 40px;
    width: 40px;
    border: 1px solid #c7c5c5;
    margin-right: 2px;
}
#projects .status{
    padding: 2px;
    font-size: 0.9em;
}
#projects .progress{
    height: 12px;
    border-radius: 5px;
}
#projects .progress-bar{
    padding: 1px 0px 0px 2px;
}
</style>
