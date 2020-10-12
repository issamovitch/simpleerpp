 <template>
        <company :title="__('l.Surveys')" :current="__('l.Surveys List')">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">{{ __("l.Surveys List") }}</h3>
                    <div class="float-right">
                        <inertia-link :href="route('surveys.add')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-plus"></i> <span>{{__("l.Add Survey")}}</span></inertia-link>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="50">#</th>
                                <th>{{__("l.Name")}}</th>
                                <th>{{__("l.N° Questions")}}</th>
                                <th>{{__("l.N° Participants")}}</th>
                                <th>{{__("l.Status")}}</th>
                                <th width="200">{{__("l.Created At")}}</th>
                                <th width="300">{{__("l.Actions")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(survey, i) in surveys">
                                <td class="text-center">{{ i + 1 }}</td>
                                <td>{{survey.name}}</td>
                                <td class="text-center">{{survey.questions_count}}</td>
                                <td class="text-center">{{survey.participants_count}}</td>
                                <td>
                                    <toggle-button v-if="survey.in_progress_campaigns_count==0" :value="(survey.status==1)?true:false"
                                                   :color="{'checked': '#1e7e34','unchecked': '#bd2130', 'disabled': '#d39e00'}"
                                                   @change="change_status(survey)"
                                                   :disabled="survey.status==2"
                                                   :labels="{'checked': __('l.Active'),'unchecked': __('l.Disabled'), 'disabled': __('l.In Progress')}"
                                                   :width="100"/>
                                    <toggle-button v-else
                                                   :color="{'checked': '#1e7e34','unchecked': '#bd2130', 'disabled': '#d39e00'}"
                                                   :disabled="true"
                                                   :labels="{'checked': __('l.In Progress'),'unchecked': __('l.In Progress'), 'disabled': __('l.In Progress')}"
                                                   :width="100"/>
                                </td>
                                <td>{{survey.created_at|format-date-time}}</td>
                                <td class="text-center align-middle">
                                    <a :href="route('survey.survey', survey.id)" class="btn btn-xs btn-secondary" target="_blank"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></a>
                                    <inertia-link :href="route('surveys.details', survey.id)" class="btn btn-xs btn-info"><i class="fa fa-th"></i> <span>{{__("l.Details")}}</span></inertia-link>
                                    <inertia-link :href="route('surveys.edit', survey.id)" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> {{__("l.Edit")}}</inertia-link>
                                    <Inertia-link href="#" v-on:click.prevent="delete_survey(survey.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </company>
</template>

<script>

import company from "../layout/company"
import service from "../../../service";

export default {
    props : ["surveys"],
    components:{
        company
    },
    data(){
        return{
            bbb: false
        }
    },
    mounted() {
        this.list = this.empty_list
    },
    methods: {
        change_status(survey){
            let status = (survey.status==1)?0:1
            let url = this.route("surveys.status", [survey.id, status]);
            this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
        },
        async delete_survey(id){
            let url = this.route("surveys.delete", id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}
</script>

<style scoped>
aaa{

}
</style>
