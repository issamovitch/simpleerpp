<template>
    <company :title="__('l.Mailbox')" :pn="__('l.Mailbox')" :pl="route('mailbox.inbox')" :current="__('l.Message Details')">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">{{__("l.Message Details")}}</h3>
            </div>
            <div class="card-body p-0">
                <div class="mailbox-read-info">
                    <h5>{{message.subject}}</h5>
                    <h6 class="clearfix mt-2">
                        <div class="float-left">
                            <div>{{__("l.From")}}: <span v-if="message.user_from">{{message.user_from.name}} &lt;{{message.user_from.email}}&gt;</span></div>
                            <div>{{__("l.To")}}: <span v-if="message.user_to">{{message.user_to.name}} &lt;{{message.user_to.email}}&gt;</span></div>
                            <div v-if="message.label" class="mt-1">
                                <i class="fa fa-circle" v-bind:style="'color : '+ message.label.color" style="width: 20px;"></i>
                                <span :style="'color:'+message.label.color">{{message.label.name}}</span>
                            </div>
                        </div>
                        <span class="mailbox-read-time float-right">{{message.created_at}}</span>
                    </h6>
                </div>
                <div class="mailbox-read-message" id="DivIdToPrint" v-html="message.text"></div>
                <div v-if="message.attachments.length>0" class="card-footer bg-white">
                    <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                        <li v-for="attachment in message.attachments">
                            <span v-if='["jpg", "png", "gif"].includes(attachment.pathinfo["extension"])' class="mailbox-attachment-icon has-img overflow-hidden">
                                <img :src="asset('storage/app/'+attachment.path)" alt="" style="height: 132.5px; width: 100%;">
                            </span>
                            <span v-else class="mailbox-attachment-icon"><i class="far fa-file"></i></span>
                            <div class="mailbox-attachment-info">
                                <a :href="asset('storage/app/'+attachment.path)" class="mailbox-attachment-name btn-file"><i class="fas fa-paperclip"></i>{{attachment.pathinfo["basename"].substr(11)}}</a>
                                <span class="mailbox-attachment-size clearfix mt-1">
                                  <span>{{attachment.size}}</span>
                                    <a :href="asset('storage/app/'+attachment.path)" class="ml-2 btn-file btn btn-default btn-sm float-right"><i class="fas fa-eye text-dark"></i></a>
                                    <a @click.prevent="downloadWithAxios(asset('storage/app/'+attachment.path), attachment.pathinfo['basename'].substr(11))" class="btn btn-default btn-sm float-right"><i class="fas fa-download text-dark"></i></a>
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-footer">
                <inertia-link :href="route('mailbox.inbox')" class="btn btn-default"><i class="fas fa-reply"></i> {{__("l.Return")}}</inertia-link>
                <inertia-link :href="route('mailbox.delete_message', message.id)" @click.prevent="delete_confirm" class="btn btn-default"><i class="far fa-trash-alt"></i> {{__("l.Delete")}}</inertia-link>
                <button @click.prevent="printSection" type="button" class="btn-print btn btn-default"><i class="fas fa-print"></i> {{__("l.Print")}}</button>
                <inertia-link v-if="message.draft" :href="route('mailbox.send_draft', message.id)" class="btn btn-default"><i class="far fa-envelope"></i> {{__("l.Send")}}</inertia-link>
            </div>
        </div>
    </company>
</template>

<script>

import company from "../layout/company"
import service from "../../../service"

export default {
    props: ["message"],
    components: {
        company,
    },
    methods:{
        async delete_confirm(e) {
            e.preventDefault();
            let url = (e.target.href) || e.target.parentElement.href;
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
        printSection() {
            this.$htmlToPaper("DivIdToPrint");
        },
        forceFileDownload(response, title) {
            console.log(title)
            const url = window.URL.createObjectURL(new Blob([response.data]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', title)
            document.body.appendChild(link)
            link.click()
        },
        downloadWithAxios(url, title) {
            axios({
                method: 'get',
                url,
                responseType: 'arraybuffer',
            })
                .then((response) => {
                    this.forceFileDownload(response, title)
                })
                .catch(() => console.log('error occured'))
        },
    }

}

</script>

<style scoped>
    input[type=file] {
        background: #fff;
        cursor: inherit;
        display: block;
        font-size: 100px;
        min-height: 100%;
        min-width: 100%;
        opacity: 0;
        outline: 0;
        position: absolute;
        right: 0;
        text-align: right;
        top: 0;
    }
</style>
