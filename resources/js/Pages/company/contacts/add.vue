<template>
    <company :title="__('l.Contacts')" :pn="__('l.Contacts List')" :pl="route('contacts.index')" :current="__('l.Add Contact')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Add Contact") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('contacts.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__("l.Contacts List")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body">
                <form id="contact_save" @submit.prevent="contact_save">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><span>{{__("l.Name")}}</span><span class="text-danger">*</span></label>
                                <input type="text" value="" name="name" required="required" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Job")}}</label>
                                <input type="text" value="" name="job" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.About")}}</label>
                                <input type="text" value="" name="about" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{__("l.Address")}}</label>
                                <input type="text" value="" name="address" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{__("l.Phone")}}</label>
                                <input type="text" value="" name="phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>{{__("l.Email")}}</label>
                                <input type="email" value="" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__("l.Image")}}</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>
                    <view-custom-fields :custom_fields="custom_fields" model="Contact"></view-custom-fields>
                    <div class="row mb-3 mt-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-150"><i class="fa fa-save"></i>
                                    <span>{{__("l.Save")}}</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </company>
</template>

<script>

import company from "../layout/company"
import ViewCustomFields from "../settings/custom_fields/view"

export default {
    components: {
        company,
        ViewCustomFields
    },
    props: ["custom_fields"],
    methods: {
        contact_save(){
            let data = new FormData(document.getElementById("contact_save"))
            this.$inertia.post(this.route('contacts.save'), data, {preserveState: false})
        }
    }
}

</script>
