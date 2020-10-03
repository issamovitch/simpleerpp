<template>
    <company :title="__('l.Mailbox')" :pn="__('l.Mailbox')" :pl="route('mailbox.inbox')" :current="__('l.Compose')">
        <form @submit.prevent="save_message(false)" id="save_message" class="card card-primary card-outline"
              enctype="multipart/form-data">
            <div class="card-header">
                <h3 class="card-title">{{ __("l.Compose New Message") }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <select name="to" class="form-control" required>
                            <option value="">{{ __("l.To:") }}</option>
                            <option v-for="user in users" :value="user.id">{{ user.name }}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select name="label_id" class="form-control">
                            <option value="">{{ __("l.Label:") }}</option>
                            <option v-for="label in labels" :value="label.id">{{ label.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <input class="form-control" name="subject" :placeholder="__('l.Subject')+':'" required>
                </div>
                <div class="form-group">
                    <trumbowyg v-model="content" :config="config" class="form-control" name="text"></trumbowyg>
                </div>
                <div class="form-group">
                    <div class="btn btn-default overflow-hidden position-relative">
                        <i class="fas fa-paperclip"></i> {{ __("l.Attachments") }}
                        <input type="file" name="attachments[]" multiple class="attachments">
                    </div>
                    <div id="attachments"></div>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-right btns">
                    <button type="button" @click="save_message(true)" class="btn btn-default"><i class="fas fa-pencil-alt"></i>
                        {{ __("l.Draft") }}
                    </button>
                    <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i>
                        {{ __("l.Send") }}
                    </button>
                </div>
                <inertia-link :href="route('mailbox.inbox')" class="btn btn-default"><i class="fas fa-times"></i>
                    {{ __("l.Discard") }}
                </inertia-link>
            </div>
        </form>
    </company>
</template>

<script>

import company from "../layout/company"
// Trumbowygtext editor
import Trumbowyg from 'vue-trumbowyg';
import 'trumbowyg/dist/ui/trumbowyg.css';

export default {
    data() {
        return {
            content: null,
            config: {
                svgPath: this.asset("public/images/vendor/trumbowyg/dist/ui/icons.svg"),
            }
        }
    },
    props: ["users", "labels"],
    components: {
        company,
        Trumbowyg
    },
    methods: {
        save_message(draft = false) {
            $(".btns button").prop("disabled", true)
            let data = new FormData(document.getElementById("save_message"))
            if(draft)
                data.append("draft", 1)
            this.$inertia.post(route('mailbox.save_message'), data).catch(e => {
                $(".btns button").prop("disabled", false)
            })
        }

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
