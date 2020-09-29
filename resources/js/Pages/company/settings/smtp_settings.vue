<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.Roles & Permissions')">
        <div class="card card-primary">
            <div class="card-header">{{__("l.SMTP Settings")}}</div>
            <div class="card-body">
                <form id="smtp_settings_save" v-on:submit.prevent="smtp_settings_save">
                    <div class="form-group">
                        <label><span>{{__("l.SMTP Host")}}</span> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="smtp_host" name="smtp_host" required>
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.SMTP User")}}</span> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="smtp_username" name="smtp_username" required>
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.SMTP Password")}}</span> <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" v-model="smtp_password" name="smtp_password" required>
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.SMTP Port")}}</span> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="smtp_port" name="smtp_port" required>
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.SMTP Security Type")}}</span> <span class="text-danger">*</span></label>
                        <select class="form-control" v-model="smtp_security_type" name="smtp_security_type" required>
                            <option value="tls">{{__("l.TLS")}}</option>
                            <option value="ssl">{{__("l.SSL")}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><span>{{__("l.Send a test mail to")}}</span></label>
                        <input type="text" class="form-control" v-model="smtp_test_email" name="smtp_test_email" :placeholder="__('l.Keep it blank if you are not interested to send test mail')">
                    </div>
                    <div class="form-group mt-4">
                        <button class="btn btn-primary" v-bind:disabled="disabled">
                            <i v-if="!disabled" class="fa fa-save"></i><i v-else class="fas fa-sync fa-spin"></i>
                            <span v-if="!disabled">{{__("l.Save")}}</span><span v-else>{{__("l.Saving")}}...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </index>
</template>


<script>

import index from "./index"

export default {
    props: ["settings"],
    mounted(){
        this.smtp_host = this.$props.settings.smtp_host?.value;
        this.smtp_username = this.$props.settings.smtp_username?.value;
        this.smtp_password = this.$props.settings.smtp_password?.value;
        this.smtp_port = this.$props.settings.smtp_port?.value;
        this.smtp_security_type = this.$props.settings.smtp_security_type?.value;
    },
    components: {
        index
    }, data() {
        return {
            smtp_host : null,
            smtp_username : null,
            smtp_password : null,
            smtp_port : null,
            smtp_security_type: null,
            smtp_test_email : "",
            disabled : false,
        }
    }, methods: {
        smtp_settings_save() {
            $("#smtp_settings_save button").prop("disabled", true);
            $("#smtp_settings_save button i").attr("class", "fas fa-sync fa-spin");
            var data = new FormData(document.getElementById("smtp_settings_save"))
            this.$inertia.post(this.route("settings.smtp_settings_save"), data, {preserveState: false, preserveScroll: true})
        }
    }
}
</script>
