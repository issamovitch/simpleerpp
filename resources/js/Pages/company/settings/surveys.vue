<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Surveys')">
        <div class="card card-primary">
            <div class="card-header">{{__("l.Surveys")}}</div>
            <div class="card-body">
                <form v-on:submit.prevent="surveys_save" id="surveys_save" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>{{__("l.Survey thank you message")}} : </label>
                        <textarea v-model="survey_thank_you_message" name="survey_thank_you_message" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"><i class="fa fa-user"></i> <span>{{__("l.Save")}}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </index>
</template>

<script>

import index from "./index";

export default {
    props: ["settings"],
    components: {
        index
    }, data() {
        return {
            survey_thank_you_message : this.$props.settings.survey_thank_you_message?.value,
        }
    },methods: {
        surveys_save() {
            var data = new FormData(document.getElementById("surveys_save"))
            this.$inertia.post(this.route("settings.surveys_save"), data, {preserveState: false})
        }
    }
}
</script>
