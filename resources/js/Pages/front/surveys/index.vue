<template>
        <index :title="__('l.Survey')">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
                <div class="container">
                    <inertia-link class="navbar-brand" :href="route('index')">
                        <img :src="$page.flash.logo" width="30" height="30" alt="">
                    </inertia-link>
                    <inertia-link class="navbar-brand" :href="route('index')">{{$page.flash.app_name}}</inertia-link>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="mr-auto"></div>
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <inertia-link class="nav-link" :href="route('survey.survey', survey.id)">{{__("l.Survey")}}</inertia-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="wrapper">
                <div class="container pt-5">
                    <form @submit.prevent="save_survey" id="save_survey" class="card">
                        <div class="card-body p-4">
                            <h4 class="text-success text-center m-4" v-if="$page.flash.success">{{$page.flash.success}}</h4>
                            <div v-else>
                                <input type="hidden" name="survey_id" :value="survey.id">
                                <h5 v-html="survey.short_description" v-if="survey.short_description && survey.short_description!=''"></h5>
                                <div v-for="question in survey.questions">
                                    <div  class="form-group">
                                        <label><span>{{question.question}}</span> <span v-if="question.required" class="text-danger">*</span></label>
                                        <template v-if="question.type=='Text'">
                                            <input type="text" v-validate="(question.required)?'required':''" :name="'answer_'+question.id" class="form-control">
                                        </template>
                                        <template v-else-if="question.type=='Textarea'">
                                            <textarea v-validate="(question.required)?'required':''" :name="'answer_'+question.id" class="form-control" rows="4"></textarea>
                                        </template>
                                        <template v-else-if="question.type=='Checkbox'||question.type=='Radio'">
                                            <div v-for="(option, i) in question.options" class="icheck-primary d-block">
                                                <input  :type="(question.type=='Checkbox')?'checkbox':'radio'"
                                                        :id="'answer_'+question.id+'_'+i"
                                                        :name="(question.type=='Checkbox')?'answer_'+question.id+'[]':'answer_'+question.id"
                                                        v-validate="(question.required)?'required':''"
                                                        :value="option">
                                                <label :for="'answer_'+question.id+'_'+i">{{option}}</label>
                                            </div>
                                        </template>
                                        <div class="text-danger">{{errors.first('answer_'+question.id+'[]')}}</div>
                                        <div class="text-danger">{{errors.first('answer_'+question.id)}}</div>
                                    </div>
                                </div>
                                <div v-if="survey.questions.length>0" class="form-group text-center m-5">
                                    <button class="btn btn-primary w-150"><i class="fa fa-save"></i> {{__("l.Submit")}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <footer class="main-footer text-center">Copyright &copy; {{ new Date().getFullYear() }} All rights reserved.</footer>
        </index>
</template>

<script>

import index from "../../index";

export default {
    components: {
        index
    },
    props: ["survey"],
    mounted(){
        this.survey.questions.forEach(question=>{
            if(!question.options)
                question.options = []
            else
                question.options = question.options.split(",")
        })
    },
    methods: {
        save_survey(){
            let url     = this.route("survey.save_survey")
            let data    = new FormData(document.getElementById("save_survey"));
            this.$validator.validateAll().then((result) => {
                if (result) {
                    this.$inertia.post(url, data, {preserveState: false})
                    return;
                }
                let field = this.$validator.errors.items[0].field
                $('[name="'+field+'"]').closest(".form-group").get()[0].scrollIntoView({ behavior: 'smooth'});
            });
        }
    }
}

</script>


<style scoped>
.list{
    list-style: none;
    margin: 0px;
    padding: 0px;
}
.main-footer {
    background: #fff;
    border-top: 1px solid #dee2e6;
    color: #6a6d71;
    padding: 1rem;
    margin: 0px !important;
    position: fixed;
    bottom: 0px;
    right: 0;
    left: 0;
}
.wrapper{
    background: #f8f8f8;
    min-height: 80vh;
}
.form-control.search{
    width: 400px;
    height: 50px;
    font-size: 17px;
}
.search-btn{
    height: 50px;
    font-size: 17px;
}
.wrapper .container{
    padding-bottom: 200px;
}
</style>

