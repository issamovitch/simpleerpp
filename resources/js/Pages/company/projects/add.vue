<template>
    <company :title="__('l.Projects')" :pn="__('l.Projects List')" :pl="route('projects.index')" :current="__('l.Add Project')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Add Project") }}</h3>
                <div class="float-right">
                    <inertia-link :href="route('projects.index')" class="btn btn-xs btn-primary"><i class="fa fa-list"></i> {{__("l.Projects List")}}</inertia-link>
                </div>
            </div>
            <div class="card-body">
                <form @submit.prevent="save_project" id="save_project">
                    <div class="form-group">
                        <label>{{__("l.Project Name")}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" v-model="project.name" v-validate="'required'">
                        <div class="text-danger">{{errors.first('name')}}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Customer")}}</label>
                                <v-select name="client_id" v-model="project.client_id" :from="clients" as="name:id:id"></v-select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Members")}}</label>
                                <v-select name="members" v-validate="'required'" v-model="project.members" :from="users" as="name:id:id" :multiple="true"></v-select>
                                <div class="text-danger">{{errors.first('members')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="icheck-primary">
                            <input type="checkbox" @change="progress" id="progress_tasks" v-model="project.progress_tasks" name="required">
                            <label for="progress_tasks">{{__("l.Calculating progress using tasks")}}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__("l.Progress")}} ({{project.progress}}%)</label>
                        <input :disabled="project.progress_tasks" type="range" class="form-control" v-model="project.progress" value="12" min="0" max="100" />
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Start Date")}} <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="start_date" v-model="project.start_date" v-validate="'required'">
                                <div class="text-danger">{{errors.first('start_date')}}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Deadline")}}</label>
                                <input type="date" class="form-control" v-model="project.deadline">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Billing Type")}} <span class="text-danger">*</span></label>
                                <select class="form-control" name="billing_type" v-model="project.billing_type" v-validate="'required'">
                                    <option value="1">{{__("l.Fixed Rate")}}</option>
                                    <option value="2">{{__("l.Hourly Rate")}} ({{__("l.Timesheets")}})</option>
                                    <option value="3">{{__("l.Tasks Hours")}}</option>
                                </select>
                                <div class="text-danger">{{errors.first('billing_type')}}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group" v-if="project.billing_type==1">
                                <label>{{__("l.Fixed Rate")}}</label>
                                <input type="number" class="form-control" v-model="project.fixed_rate" step="0.01">
                            </div>
                            <div class="form-group" v-if="project.billing_type==2">
                                <label>{{__("l.Rate Per Hour")}}</label>
                                <input type="number" class="form-control" v-model="project.rate_per_hour" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Status")}}</label>
                                <select class="form-control" v-model="project.status">
                                    <option value="1">{{__("l.New")}}</option>
                                    <option value="2">{{__("l.In Progress")}}</option>
                                    <option value="3">{{__("l.Completed")}}</option>
                                    <option value="4">{{__("l.Delayed")}}</option>
                                    <option value="5">{{__("l.Canceled")}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Labels")}}</label>
                                <v-select v-model="project.labels" :from="[]" tagging :placeholder='__(`l.Type and click "Enter" to add a label`)'></v-select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{__("l.Description")}}</label>
                        <textarea rows="5" class="form-control" v-model="project.description"></textarea>
                    </div>
                    <div class="form-group mt-5 mb-5">
                        <button class="btn btn-primary w-150"><i class="fa fa-save"></i> {{__("l.Save")}}</button>
                    </div>
                </form>
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
    props: ["clients", "users"],
    data(){
        return {
            project: {
                name: "",
                client_id: null,
                members: [],
                progress_tasks: true,
                progress: 0,
                description: "",
                start_date: moment(String(new Date())).format('YYYY-MM-DD'),
                deadline: "",
                status: 1,
                billing_type: 1,
                fixed_rate: 0.00,
                rate_per_hour: 0.00,
                labels: []
            },
        }
    },
    methods: {
        progress(){
            if(!this.project.progress_tasks)
                this.project.progress = 0
        },
        save_project(){
            let url = this.route("projects.save")
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.$inertia.post(url, this.project, {preserveState: false})
                    return;
                }
                let field = this.$validator.errors.items[0].field
                $('[name="'+field+'"]').closest(".form-group").get()[0].scrollIntoView({ behavior: 'smooth'});
            });
        }
    }
}
</script>
