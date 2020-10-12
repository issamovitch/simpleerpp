 <template>
        <company :title="__('l.Surveys')" :pn="__('l.Surveys List')" :pl="route('surveys.index')" :current="__('l.Edit Survey')">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">{{ __("l.Edit Survey") }}</h3>
                    <div class="float-right">
                        <inertia-link :href="route('surveys.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__("l.Surveys List")}}</span></inertia-link>
                        <inertia-link :href="route('surveys.details', survey.id)" class="btn btn-xs btn-info float-right ml-3"><i class="fa fa-th"></i> <span>{{__("l.Survey Details")}}</span></inertia-link>
                        <a :href="route('survey.survey', survey.id)" class="btn btn-xs btn-secondary float-right ml-3" target="_blank"><i class="fa fa-eye"></i> <span>{{__("l.View Survey")}}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form @submit.prevent="save_survey" id="save_survey">
                        <input type="hidden" name="id" :value="survey.id">
                        <div class="form-group">
                            <label>{{__("l.Name")}} <span class="text-danger">*</span></label>
                            <input type="text" :value="survey.name" name="name" class="form-control" required autocomplete="off">
                        </div>
                        <div class="form-group short_description">
                            <label>{{__("l.Short Description")}}</label>
                            <trumbowyg v-model="short_description" :config="config" class="form-control" name="short_description"></trumbowyg>
                        </div>
                        <div class="form-group">
                            <label>{{__("l.Email Description")}}</label>
                            <div class="row">
                                <div class="col-sm-10">
                                    <trumbowyg v-model="email_description" :config="config" class="form-control" name="email_description"></trumbowyg>
                                </div>
                                <div class="col-sm-2 pt-3">
                                    <a class="d-blcok mb-2" href="#" @click.prevent="add_to_text('survey_link')"><span class="text-dark">{{__("l.Add")}}</span> {survey_link}</a>
                                    <div class="mb-2 mt-2">{{__("l.Mailing Lists")}} :</div>
                                    <div v-if="list.fields.length>0" v-for="list in lists" class="mb-2">
                                        <strong>{{list.name}}:</strong>
                                        <a v-for="field in list.fields" class="d-block" href="#"  @click.prevent="add_to_text(field.name)"><span class="text-dark">{{__("l.Add")}}</span> {<span>{{field.name}}</span>}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{__("l.From")+" "+__("l.Email")}}</label>
                            <input type="email" :value="survey.from" name="from" class="form-control">
                        </div>
                        <div class="form-group mt-5">
                            <button class="btn btn-primary w-150"><i class="fa fa-save"></i> {{__("l.Save")}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </company>
</template>

<script>

import company from "../layout/company"
import service from "../../../service";
// Trumbowygtext editor
import Trumbowyg from 'vue-trumbowyg';
import 'trumbowyg/dist/ui/trumbowyg.css';

export default {
    props : ["lists", "survey"],
    components:{
        company,
        Trumbowyg
    },
    mounted() {
    },
    data() {
        return {
            short_description: this.survey.short_description,
            email_description: this.survey.email_description,
            config: {
                svgPath: this.asset("public/images/vendor/trumbowyg/dist/ui/icons.svg"),
            }
        }
    },
    methods: {
        add_to_text(text){
            this.email_description += " {"+text+"}"
        },
        save_survey(){
            let data = new FormData(document.getElementById("save_survey"))
            this.$inertia.post(this.route('surveys.update'), data, {preserveState: false})
        }
    }
}
</script>

<style>
.short_description .trumbowyg-box{
    min-height: inherit !important;
}
.short_description .trumbowyg-editor{
    min-height: 100px !important;
    height: 100px !important;
}
</style>
