<template>
    <index :title="__('l.Settings')" :pn="__('l.Settings')" :pl="route('settings.general_settings')" :current="__('l.General Settings')">
        <div class="card card-primary">
            <div class="card-header">{{__("l.General Settings")}}</div>
            <div class="card-body">
                <form v-on:submit.prevent="general_settings_save" id="general_settings_save" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>{{__("l.App Name")}} <span class="text-danger">*</span></label>
                        <input type="text" v-model="app_name" name="app_name" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>{{__("l.App Description")}}</label>
                        <textarea v-model="app_description" name="app_description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>{{__("l.Logo")}}</label>
                        <input type="file" name="logo" ref="file" class="form-control d-none" id="logo_input">
                        <img :src="logo" alt="" v-on:click="$refs.file.click()" class="img-thumbnail mt-2 d-block" id="logo" style="height: 200px; cursor:pointer;">
                    </div>
                    <div class="form-group">
                        <label>{{__("l.Login Page Image")}}</label>
                        <input type="file" name="login_page_image" ref="file2" class="form-control d-none" id="logo_input2">
                        <img :src="login_page_image" alt="" v-on:click="$refs.file2.click()" class="img-thumbnail mt-2 d-block" id="logo2" style="height: 300px; cursor:pointer;">
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
            app_name : this.$props.settings.app_name?.value,
            app_description : this.$props.settings.app_description?.value,
            logo : (this.$props.settings.logo) ? this.asset("storage/app/"+this.$props.settings.logo.value) : this.asset("public/no-image.png"),
            login_page_image : (this.$props.settings.login_page_image) ? this.asset("storage/app/"+this.$props.settings.login_page_image.value) : this.asset("public/no-image.png"),
        }
    }, mounted(){
        $("head .favicon").attr("href", this.logo)
        $("#logo_input").on("change", this.set_logo)
        $("#logo_input2").on("change", this.set_logo2)
    }, methods: {
        set_logo(e){
            $("#logo").attr("src", URL.createObjectURL(e.target.files[0]));
        },
        set_logo2(e){
            $("#logo2").attr("src", URL.createObjectURL(e.target.files[0]));
        },
        general_settings_save() {
            var data = new FormData(document.getElementById("general_settings_save"))
            this.$inertia.post(this.route("settings.general_settings_save"), data, {preserveState: false})
        }
    }
}
</script>
