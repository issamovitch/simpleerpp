<template>
    <company :title="__('l.Mailbox')" :pn="__('l.Mailbox')" :pl="route('mailbox.inbox')" :current="__('l.'+current.charAt(0).toUpperCase() + current.slice(1))">
        <div class="row">
            <div class="col-md-3">
                <inertia-link :href="route('mailbox.compose')" class="btn btn-primary btn-block mb-3">{{__("l.Compose Message")}}</inertia-link>
                <!-- Folders -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__("l.Folders")}}</h3>
                        <div class="card-tools">
                            <button type="button" data-card-widget="collapse" class="btn btn-tool"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <inertia-link :href="route('mailbox.inbox')" :class="{'active' : current=='inbox'}" class="nav-link"><i class="fas fa-inbox" style="width: 20px;"></i> {{__("l.Inbox")}}
                                    <span v-if="$page.flash.unread_messages.length>0" class="badge bg-danger  float-right">{{$page.flash.unread_messages.length}}</span>
                                </inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link :href="route('mailbox.sent')" :class="{'active' : current=='sent'}" class="nav-link "><i class="far fa-envelope" style="width: 20px;"></i> {{__("l.Sent")}}</inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link :href="route('mailbox.draft')" :class="{'active' : current=='draft'}" class="nav-link "><i class="far fa-file-alt" style="width: 20px;"></i> {{__("l.Drafts")}}</inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link :href="route('mailbox.trash')" :class="{'active' : current=='trash'}" class="nav-link "><i class="far fa-trash-alt" style="width: 20px;"></i> {{__("l.Trash")}}</inertia-link>
                            </li>
                            <li class="nav-item">
                                <inertia-link :href="route('mailbox.favorite')" :class="{'active' : current=='favorite'}" class="nav-link "><i class="far fa-star" style="width: 20px;"></i> {{__("l.Favorites")}}</inertia-link>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Labels -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{__("l.Labels")}}</h3>
                        <div class="card-tools"><button type="button" data-card-widget="collapse" class="btn btn-tool"><i class="fas fa-minus"></i></button></div>
                    </div>
                    <div class="card-body p-0">
                        <div id="label-wrapper">
                            <div id="label-div">
                                <ul class="nav nav-pills flex-column mb-0" style="border-bottom: 1px solid rgba(0, 0, 0, 0.125);">
                                    <li v-for="lb in labels" class="nav-item">
                                        <a @click.prevent="current_label(lb)" href="#" class="nav-link btn-label">
                                            <i class="fa fa-circle" v-bind:style="'color:'+lb.color" style="width: 20px;"></i> <span>{{lb.name}}</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="p-2">
                                    <form @submit.prevent="save_label">
                                        <input type="hidden" name="id" :value="label.id">
                                        <div class="input-group">
                                            <input type="color" v-model="label.color" name="color" :placeholder="__('l.Color')" required="required" class="form-control">
                                            <input type="text" v-model="label.name" name="name" :placeholder="__('l.Name')" required="required" autocomplete="off" class="form-control">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    <span v-if="label.id">{{__("l.Update")}}</span>
                                                    <span v-else>{{__("l.Save")}}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <div v-if="label.id" class="mt-3 mb-2">
                                        <a class="text-danger d-block" @click.prevent="delete_label(label.id)" href="">{{__("l.Delete")}} "{{label.name}}"</a>
                                        <a class="text-primaryr d-block" @click.prevent="reset_label()" href="">{{__("l.Reset")}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header"><h3 class="card-title">{{__("l."+current.charAt(0).toUpperCase() + current.slice(1))}}</h3>
                        <div class="card-tools">
                            <form @submit.prevent="search" method="post" class="message_search input-group input-group-sm">
                                <input @keyup="search" v-model="q" type="text" required :placeholder="__('l.Search Mail')" class="form-control">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    <a @click.prevent="search_reset" href="#" class="btn btn-primary" style="border-left: 1px solid gray;"><i class="fas fa-sync-alt"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0" style="min-height: 700px;">
                        <div class="mailbox-controls">
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i></button>
                            <button @click.prevent="delete_messages" type="button" class="btn btn-default btn-sm"><i class="far fa-trash-alt"></i></button>
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <div id="messages-wrapper">
                                <div id="messages-div">
                                    <slot :search_messages="messages" :label="label" :favorite="favorite" :unfavorite="unfavorite"></slot>
                                    <div class="mt-2 p-2"></div>
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

export default {
    data(){
        return {
            labels : [],
            label : {id: null, name: "", color: "#0000ff"},
            messages : null,
            q : ""
        }
    },
    props : ["current"],
    components:{
        company
    },
    mounted() {
        this.get_labels()
        let app = this
        $(document).on("click", ".checkbox-toggle", function () {
            var clicks = $(this).data('clicks')
            if (clicks) {
                //Uncheck all checkboxes
                $('.mailbox-messages .checkbox').prop('checked', false)
                $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
            } else {
                //Check all checkboxes
                $('.mailbox-messages .checkbox').prop('checked', true)
                $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
            }
            $(this).data('clicks', !clicks)
        });
    },
    methods:{
        favorite(id){
            var url = this.route("mailbox.dofavorite")+ '/' + id;
            this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
        },
        unfavorite(id){
            var url = this.route("mailbox.unfavorite")+ '/' + id;
            this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
        },
        get_labels(){
            axios.get(this.route('mailbox.get_labels'), this.label)
                .then(res => this.labels = res.data)
                .catch(e=>console.log(e))
        },
        save_label(){
            axios.post(this.route('mailbox.save_label'), this.label)
                .then(res => {
                    this.label = {id: null, name: "", color: "#0000ff"}
                    this.get_labels()
                }).catch(e=>console.log(e))
        },
        current_label(lb){
            this.label = lb
        },
        async delete_label(id){
            if(await service.confirmation()){
                this.$inertia.visit(this.route('mailbox.delete_label', id),  {preserveState: false, preserveScroll: true})
            }
        },
        async delete_messages(){
            var els = [];
            $.each($(".mailbox-messages .checkbox"), function (i, el) {
                if ($(el).is(":checked"))
                    els.push($(el).attr("value"));
            });
            if (els.length == 0) {
                this.$toastr.error(this.__("l.You have to choose a message"))
                return;
            } else {
                if(await service.confirmation()){
                    this.$inertia.post(this.route('mailbox.delete'), {ids: els},  {preserveState: false, preserveScroll: true})
                }
            }

        },
        reset_label(){
            this.label = {id: null, name: "", color: "#0000ff"}
        },
        search_reset(){
            this.messages = null
            this.q = null
        },
        search(){
            if(this.q && this.q!=""){
                axios.post(this.route('mailbox.search'), {q: this.q, current: this.current})
                    .then(res => {
                        this.messages = res.data
                    }).catch(e=>console.log(e))
            }else{
                this.messages = null
            }
        }
    }
}

</script>
