<template>
    <tr v-if="(!label.id) || (label.id && message.label_id && label.id==message.label_id)" :data-label-id="message.id">
        <td>
            <div class="icheck-primary">
                <input type="checkbox" :value="message.id" :id="'check='+message.id" class="checkbox"> <label :for="'check='+message.id"></label>
            </div>
        </td>
        <td class="mailbox-star">
            <a v-if="message.favorite" href="#"  @click.prevent="unfavorite(message.id)"><i class="fas fa-star text-warning"></i></a>
            <a v-else href="#" @click.prevent="favorite(message.id)"><i class="far fa-star text-warning"></i></a>
        </td>
        <td>
            <inertia-link :href="route('mailbox.message', message.id)">
                <img v-if="message.user_to && message.user_to.image" :src="asset('storage/app/'+message.user_to.image)" alt="User Avatar" class="img-size-32 mr-1 img-circle" style="height: 32px;">
                <img v-else :src="asset('public/no-image.png')" alt="User Avatar" class="img-size-32 mr-1 img-circle" style="height: 32px;">
                {{(message.user_to)?message.user_to.name:''}}
                <span v-if="current=='inbox'&&message.read==0" class="text-danger">*</span>
            </inertia-link>
        </td>
        <td class="mailbox-subject">
            <div class="mb-2">
                <img v-if="message.user_from && message.user_from.image" :src="asset('storage/app/'+message.user_from.image)" alt="User Avatar" class="img-size-32 mr-1 img-circle" style="height: 32px;">
                <img v-else :src="asset('public/no-image.png')" alt="User Avatar" class="img-size-32 mr-1 img-circle" style="height: 32px;">
                <b>{{(message.user_from)?message.user_from.name:''}}</b>
                - {{message.subject}}
            </div>
            <small v-if="message.label" class="p-1 text-white text-center" style="font-size:70%;min-width: 70px;display: inherit; padding: 2px !important; border-radius: 2px;" v-bind:style="'background: '+message.label.color">{{message.label.name}}</small>
        </td>
        <td class="mailbox-date" style="vertical-align: middle">{{message.created_at|format-date-time}}</td>
        <td class="text-center" style="vertical-align: middle">
            <inertia-link :href="route('mailbox.message', message.id)" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></inertia-link>
        </td>
    </tr>
</template>

<script>
export default {
    name: "message-row",
    props: ["message", "label", "favorite", "unfavorite", "current"],
}
</script>

<style scoped>

</style>
