 <template>
        <company :title="__('l.Surveys')" :pn="__('l.Surveys List')" :pl="route('surveys.index')" :current="__('l.Survey Details')">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">{{ __("l.Survey Details") }}</h3>
                    <div class="float-right">
                        <inertia-link :href="route('surveys.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__("l.Surveys List")}}</span></inertia-link>
                        <inertia-link :href="route('surveys.edit', survey.id)" class="btn btn-xs btn-success float-right ml-3"><i class="fa fa-edit"></i> <span>{{__("l.Edit Survey")}}</span></inertia-link>
                        <a :href="route('survey.survey', survey.id)" class="btn btn-xs btn-secondary float-right ml-3" target="_blank"><i class="fa fa-eye"></i> <span>{{__("l.View Survey")}}</span></a></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a href="#tab1" @click.prevent="savemenu(1)" data-toggle="tab" :class="{'active' : menu==1}" class="nav-link">{{ __("l.Questions") }}</a>
                                <a href="#tab2" @click.prevent="savemenu(2)" data-toggle="tab" :class="{'active' : menu==2}" class="nav-link">{{ __("l.Send Survey") }} <span class="badge bg-danger float-right" v-if="survey.in_progress_campaigns_count>0">{{survey.in_progress_campaigns_count}}</span></a>
                                <a href="#tab3" @click.prevent="savemenu(3)" data-toggle="tab" :class="{'active' : menu==3}" class="nav-link">{{ __("l.Results") }}</a>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="tab-content" style="min-height: 400px">
                                <div id="tab1" :class="{'show in active' : menu==1}" class="tab-pane fade">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__("l.Add Question")}}<span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a @click.prevent="add_question('Text')" href="#" class="dropdown-item">{{__("l.Text")}}</a></li>
                                            <li><a @click.prevent="add_question('Textarea')" href="#" class="dropdown-item">{{__("l.Textarea")}}</a></li>
                                            <li><a @click.prevent="add_question('Checkbox')" href="#" class="dropdown-item">{{__("l.Checkbox")}}</a></li>
                                            <li><a @click.prevent="add_question('Radio')" href="#" class="dropdown-item">{{__("l.Radio")}}</a></li>
                                        </ul>
                                        <div id="sortable">
                                            <div :data-id="question.id" v-for="question in survey.questions" class="question-wrapper">
                                                <div class="card question bg-light color-palette mt-3">
                                                    <div class="card-header position-relative">
                                                        <div class="float-left">{{__("l."+ question.type)}}</div>
                                                        <a @click.prevent="delete_question(question.id)" class="float-right ml-2 btn btn-danger btn-xs" :title="__('l.Delete')" href=""><i class="fa fa-times"></i></a>
                                                        <a @click.prevent="update_question(question)"class="float-right btn btn-success btn-xs" :title="__('l.Save')" href=""><i class="fa fa-save"></i></a>
                                                    </div>
                                                    <div class="card-body pb-0">
                                                        <div class="form-group">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" :id="'required'+question.id" v-model="question.required" name="required">
                                                                <label :for="'required'+question.id">{{__("l.Required")}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>{{__("l.Question")}} : </label>
                                                            <input type="text" v-model="question.question" class="form-control" name="question" />
                                                        </div>
                                                        <div v-if="question.type=='Checkbox'||question.type=='Radio'" class="form-group">
                                                            <label>{{__("l.Options")}} : <a @click.prevent="add_option(question)" href=""><i class="fa fa-plus"></i></a></label>
                                                            <ul class="list-group">
                                                                <li v-for="(option, i) in question.options" class="list-group-item p-1 border-0 bg-transparent">
                                                                    <div class="icheck-primary d-inline-block mt-1">
                                                                        <input :type="(question.type=='Checkbox')?'checkbox':'radio'" :id="'required'+question.id+'_'+i" disabled>
                                                                        <label :for="'required'+question.id+'_'+i"></label>
                                                                    </div>
                                                                    <input name="options[]" type="text" class="form-control w-200 d-inline-block mr-2" v-model="question.options[i]">
                                                                    <a @click.prevent="delete_option(question, i)" href=""><i class="fa fa-minus text-danger"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab2" :class="{'show in active' : menu==2}" class="tab-pane fade">
                                    <form @submit.prevent="submit_campaign" id="submit_campaign">
                                        <input type="hidden" name="survey_id" :value="survey.id">
                                        <div v-for="list in lists" class="icheck-primary">
                                            <input type="checkbox" :id="'list'+list.id" :name="'list_'+list.id" :disabled="list.emails_count==0">
                                            <label :for="'list'+list.id">{{list.name}} <small>({{list.emails_count}} {{__("l.emails")}})</small></label>
                                        </div>
                                        <div class="form-group">
                                            <button v-if="lists.length>0" class="btn btn-primary"><i class="fa fa-save"></i> <span>{{__("l.Submit")}}</span></button>
                                        </div>
                                    </form>
                                    <div v-if="survey.campaigns.length>0">
                                        <table class="table table-bordered table-striped mt-2">
                                            <thead>
                                            <tr>
                                                <th class="text-center" width="50">#</th>
                                                <th>{{__("l.Mailing Lists")}}</th>
                                                <th>{{__("l.Status")}}</th>
                                                <th>{{__("l.N° Emails")}}</th>
                                                <th width="200">{{__("l.Created At")}}</th>
                                                <th width="260">{{__("l.Actions")}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <template v-for="(campaign, i) in survey.campaigns">
                                                    <tr>
                                                        <td class="text-center">{{ i + 1 }}</td>
                                                        <td>
                                                            <ul class="m-0 pl-3">
                                                                <li v-if="mailing_list.mailing_list" v-for="mailing_list in campaign.mailing_lists">{{mailing_list.mailing_list.name}}</li>
                                                            </ul>
                                                        </td>
                                                        <td class="text-center">
                                                            <div v-if="campaign.status==0" class="text-primary">{{__("l.Waiting")}}</div>
                                                            <div v-else-if="campaign.status==1" class="text-warning">{{__("l.In Progress")}} <span class="text-danger">{{campaign.progress}}%</span></div>
                                                            <div v-else-if="campaign.status==2" class="text-success">{{__("l.Done")}}</div>
                                                        </td>
                                                        <td class="text-center">{{campaign.emails.length}}</td>
                                                        <td>{{campaign.created_at|format-date-time}}</td>
                                                        <td class="text-center">
                                                            <a v-if="campaign.status!=2" href="#" @click.prevent="campaign_emails_send(campaign)" :id="'btn_email_'+campaign.id" class="btn btn-xs btn-success"><i class="far fa-envelope"></i> <span>{{__("l.Send Emails")}}</span></a>
                                                            <a v-else href="javascript:void(0)" disabled class="btn btn-xs btn-success  disabled"><i class="far fa-envelope"></i> <span>{{__("l.Send Emails")}}</span></a>
                                                            <a href="#" @click.prevent="campaign_emails(campaign)" class="btn btn-xs btn-info"><i class="fa fa-th"></i> <span>{{__("l.Details")}}</span></a>
                                                            <Inertia-link href="#" v-on:click.prevent="delete_campaign(campaign.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                                                        </td>
                                                    </tr>
                                                    <tr class="campaign_emails" :id="'campaign_emails_'+campaign.id">
                                                        <td colspan="6">
                                                            <div v-if="campaign.status==1" class="text-center mb-2">{{__("l.Please leave the page open")}} !</div>
                                                            <div class="progress mb-2">
                                                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" :aria-valuenow="campaign.progress" aria-valuemin="0" aria-valuemax="100" :style="'width: '+campaign.progress+'%'">
                                                                    <span>{{campaign.progress}}%</span>
                                                                </div>
                                                            </div>
                                                            <div style="max-height: 400px; overflow-y: auto;">
                                                                <table class="table">
                                                                    <tr v-if="campaign.show_all_emails||email.status!=2||campaign.status==2" v-for="(email, j) in campaign.emails">
                                                                        <td width="60" class="text-center">{{ j + 1 }}</td>
                                                                        <td width="100" class="text-center">
                                                                            <div v-if="email.status==0" class="text-primary">{{__("l.Waiting")}}</div>
                                                                            <div v-else-if="email.status==1" class="text-warning">{{__("l.In Progress")}}</div>
                                                                            <div v-else-if="email.status==2" class="text-success">{{__("l.Done")}}</div>
                                                                        </td>
                                                                        <td>{{email.email}}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="tab3" :class="{'show in active' : menu==3}" class="tab-pane fade">
                                    <h4>{{__("l.Survey Results")}}</h4>
                                    <p v-if="survey.answers.length==0">{{__("l.No Results Found")}}</p>
                                    <div v-else>
                                        <div v-for="question in survey.questions" class="card bg-light color-palette mt-3">
                                            <div class="card-header">{{question.question}}</div>
                                            <div class="card-body">
                                                <template v-if="question.type=='Text'||question.type=='Textarea'">
                                                    <a href="#" data-toggle="modal" :data-target="'#myModal'+question.id">{{__("l.See All Results")}}</a>
                                                    <div :id="'myModal'+question.id" class="modal fade" role="dialog">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h4 class="modal-title">{{__("l.See All Results")}}</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul>
                                                                    <li v-if="answer.survey_question_id==question.id && answer.value && answer.value!=''"
                                                                        v-for="answer in survey.answers">
                                                                        {{answer.value}}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </template>
                                                <template v-else>
                                                    <div v-for="(option, i) in question.options" class="form-group">
                                                        <label>{{option}} : </label>
                                                        <div class="progress" style="height: 22px;">
                                                            <div :class="'bg-'+colors[Math.floor(Math.random() * colors.length)]"
                                                                 class="progress-bar progress-bar-striped" role="progressbar"
                                                                 :aria-valuenow="question.options_answers[i]/question.options_answers.reduce((a, b) => a + b, 0)*100" aria-valuemin="0"
                                                                 aria-valuemax="100" :style="'width: '+question.options_answers[i]/question.options_answers.reduce((a, b) => a + b, 0)*100+'%'">
                                                                <span>{{question.options_answers[i]/question.options_answers.reduce((a, b) => a + b, 0)*100}}%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </company>
</template>

<script>

import company from "../layout/company"
import service from "../../../service";
import 'jquery-ui/ui/widgets/sortable.js';

export default {
    props : ["lists", "survey"],
    components:{
        company,
    },
    mounted() {
        this.menu = (localStorage.menu) ? localStorage.menu : 1;
        this.survey.questions.forEach(question=>{
            if(!question.options)
                question.options = []
            else
                question.options = question.options.split(",")
            question.options_answers = []
            question.options.forEach((option, i)=>{
                question.options_answers[i] = 0
                this.survey.answers.forEach(answer => {
                    if(answer.value && answer.value!=''){
                        let values = answer.value.split(";;;")
                        if(values.includes(option))
                            question.options_answers[i] = question.options_answers[i]+1
                    }
                })
            })
        })
        this.survey.campaigns.forEach(campaign=> campaign.show_all_emails = true)
        let app = this
        $('#sortable').sortable({
            axis: "y",
            placeholder: "ui-state-highlight",
            stop: function(e, ui){
                let data = [];
                $.each($("#sortable .question-wrapper"), function (i, el) {
                    data.push({"id": $(el).data("id"), "order": i+1})
                })
                app.change_questions_order(data)
            },
        });
    },
    data() {
        return {
            menu : 1,
        }
    },
    methods: {
        savemenu(n){
            localStorage.menu = n
        },
        add_question(type){
            let data = {id: this.survey.id, type: type}
            this.$inertia.post(this.route("surveys.save_question"), data, {preserveState: false, preserveScroll: true})
        },
        async delete_question(id){
            if(await service.confirmation()) {
                this.$inertia.visit(this.route("surveys.delete_question", id), {preserveState: false, preserveScroll: true})
            }
        },
        update_question(question){
            this.$inertia.post(this.route("surveys.update_question"), question, {preserveState: false, preserveScroll: true})
        },
        change_questions_order(data){
            axios.post(this.route("surveys.change_questions_order"), data).then(res=> this.$toastr.success(this.__("l.Data Updated Successfully")))
        },
        add_option(question){
            question.options.push("")
        },
        delete_option(question, x){
            question.options = question.options.filter((el, i) => {
                return i != x
            });
        },
        submit_campaign(){
            let data = new FormData(document.getElementById("submit_campaign"));
            $("#submit_campaign button").prop("disabled", true)
            $("#submit_campaign button i").attr("class", "fa fa-spin fa-spinner")
            $("#submit_campaign button span").html(this.__("l.In Progress"))
            this.$inertia.post(this.route("surveys.submit_campaign"), data, {preserveState: false, preserveScroll: true})
        },
        async delete_campaign(id){
            if(await service.confirmation()) {
                this.$inertia.visit(this.route("surveys.delete_campaign", id), {preserveState: false, preserveScroll: true})
            }
        },
        campaign_emails(campaign){
            campaign.show_all_emails = true
            $(".campaign_emails:not(#campaign_emails_"+campaign.id+")").hide("fast")
            $(".campaign_emails#campaign_emails_"+campaign.id).slideToggle()
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".campaign_emails#campaign_emails_"+campaign.id).offset().top - 100
            }, 1000);
        },
        campaign_emails_send(campaign){
            campaign.show_all_emails = false
            $(".campaign_emails:not(#campaign_emails_"+campaign.id+")").hide("fast")
            $(".campaign_emails#campaign_emails_"+campaign.id).slideDown()
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".campaign_emails#campaign_emails_"+campaign.id).offset().top - 100
            }, 1000);
            this.send_email(campaign, campaign.emails[0], 0);
        },
        async send_email(campaign, email, num){
            let app = this
             if(email.status !== 2){
                 email.status = 1;
                 await axios.get(app.route("surveys.send_email", email.id)).then(
                     res => {
                         campaign.status = res.data.campaign.status
                         campaign.progress = res.data.campaign.progress
                         email.status = res.data.email.status
                         app.next_email(campaign, num+1)
                     }
                 );
             }else{
                 this.next_email(campaign, num+1)
             }
        /*
        if(email.status != 2){
            console.log(num)
            if(num%10==5)
            await $("#emails_table_"+campaign.id).animate({scrollTop: $("#emails_"+email.id).offset().top+300});

        }else{
            if(campaign.emails[num+1])
                this.send_email(campaign, campaign.emails[num+1], num+1);
            else {
                this.$toastr.success(this.__("l.All Emails Are Sent Successfully"))
                $(".campaign_emails").hide("fast")
            }
        }*/
    },
        next_email(campaign, num){
            if (!campaign.emails[num]){
                console.log("eee"+num)
                this.$toastr.success(this.__("l.All Emails Are Sent Successfully"))
                $(".campaign_emails").hide("fast")
            }else{
                this.send_email(campaign, campaign.emails[num], num);
            }
        }
    }
}

</script>

<style scoped>
.question .card-header {
    cursor : move
}
#sortable{
    position: relative;
}
.delete-btn{
    top: 7px;
    right: 10px;
    position: absolute;
}
.delete-save{
    top: 7px;
    right: 35px;
    position: absolute;
}
label{
    font-weight: normal !important;
}
.campaign_emails{
    display: none;
}
</style>
