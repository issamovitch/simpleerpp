<template>
    <company :title="__('l.Contacts')" :current="__('l.Contacts List')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Contacts List") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('contacts.add')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-plus"></i> <span>{{__("l.Add Contact")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body">
                <div class="row d-flex align-items-stretch">
                    <div v-for="contact in contacts" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <div class="card bg-light w-100">
                            <div class="card-header text-muted border-bottom-0" style="height: 50px;">{{contact.job}}</div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>{{contact.name}}</b></h2>
                                        <p class="text-muted text-sm" style="height: 40px;">
                                            <span v-if="contact.about && contact.about != ''">
                                                <b>{{__("l.About")}}: </b> {{contact.about}}
                                            </span>
                                        </p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small">
                                                <span class="fa-li">
                                                    <i class="fas fa-lg fa-building"></i>
                                                </span>
                                                {{__("l.Address")}} : {{contact.address}}
                                            </li>
                                            <li class="small">
                                                <span class="fa-li">
                                                    <i class="fas fa-lg fa-phone"></i>
                                                </span>
                                                {{__("l.Phone")}} # : <a :href="'tel:'+contact.phone">{{contact.phone}}</a>
                                            </li>
                                            <li class="small">
                                                <span class="fa-li">
                                                    <i class="fas fa-lg fa-at"></i>
                                                </span>
                                                {{__("l.Email")}} # : <a :href="'mailto:'+contact.email">{{contact.email}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img v-if="contact.image" :src="asset('storage/app/'+contact.image)" alt="" class="img-circle img-fluid img-thumbnail" style="width: 135px; height: 135px;">
                                        <img v-else :src="asset('public/no-image.png')" alt="" class="img-circle img-fluid img-thumbnail" style="width: 135px; height: 135px;">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <inertia-link :href="route('contacts.edit', contact.id)" class="btn btn-sm btn-success"><i class="fas fa-edit"></i> <span>{{__("l.Edit")}}</span></inertia-link>
                                    <inertia-link href="#" v-on:click.prevent="delete_contact(contact.id)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> <span>{{__("l.Delete")}}</span></inertia-link>
                                </div>
                                <div class="float-right">
                                    <inertia-link :href="route('contacts.view', contact.id)" class="btn btn-sm btn-primary"><i class="fas fa-user"></i> {{__("l.View Profile")}}</inertia-link>
                                </div>
                                <div class="clearfix"></div>
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

export default {
    components: {
        company
    },
    props: ["contacts"],
    methods: {
        async delete_contact(id){
            let url = this.route('contacts.delete', id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}

</script>
