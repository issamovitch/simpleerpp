<template>
    <company :title="__('l.Contacts')" :pn="__('l.Contacts List')" :pl="route('contacts.index')" :current="__('l.Contact Details')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Contact Details") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('contacts.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__("l.Contacts List")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body">
                <img v-if="contact.image" :src="asset('storage/app/'+ contact.image)" alt="" class="img-circle img-fluid img-thumbnail" style="width: 250px; height: 250px; display: block; margin: 0px auto 40px;">
                <img v-else :src="asset('public/no-image.png')" alt="" class="img-circle img-fluid img-thumbnail" style="width: 250px; height: 250px; display: block; margin: 0px auto 40px;">
                <div class="card card-primary">
                    <div class="card-header">{{__("l.Personal Informations")}}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>{{__("l.Name")}}</label>
                            <div>{{contact.name}}</div>
                        </div>
                        <div class="form-group">
                            <label>{{__("l.Job")}}</label>
                            <div>{{contact.job}}</div>
                        </div>
                        <div class="form-group">
                            <label>{{__("l.About")}}</label>
                            <div>{{contact.about}}</div>
                        </div>
                        <div class="form-group">
                            <label>{{__("l.Address")}}</label>
                            <div>{{contact.address}}</div>
                        </div>
                        <div class="form-group">
                            <label>{{__("l.Phone")}}</label>
                            <div>{{contact.phone}}</div>
                        </div>
                        <div class="form-group">
                            <label>{{__("l.Email")}}</label>
                            <div>{{contact.email}}</div>
                        </div>
                    </div>
                </div>
                <print-custom-fields :custom_fields="custom_fields"></print-custom-fields>
            </div>
        </div>
    </company>
</template>

<script>

import company from "../layout/company"
import PrintCustomFields from "../settings/custom_fields/print"

export default {
    components: {
        company,
        PrintCustomFields
    },
    props: ["custom_fields", "contact"],
}

</script>
