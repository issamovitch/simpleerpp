<template>
    <div>
        <pagination v-if="!slotProps.search_messages" :pagination="pagination" stylee="margin-top: 10px"></pagination>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <td width="50"></td>
                <td width="50"></td>
                <td>{{__("l.To")}}</td>
                <td width="40%">{{__("l.From")}}</td>
                <td>{{__("l.Date")}}</td>
                <td width="90">{{__("l.View")}}</td>
            </tr>
            </thead>
            <tbody>
            <message-row :current="current" :favorite="slotProps.favorite" :unfavorite="slotProps.unfavorite"
                         :label="slotProps.label" :key="'message'+message.id" :message="message"
                         v-for="message in (slotProps.search_messages||messages.data)"></message-row>
            <tr v-if="(!slotProps.search_messages && messages.data.length==0) || (slotProps.search_messages && slotProps.search_messages.length==0)">
                <td colspan="6" class="text-center"><b>{{__("l.No Data")}}</b></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

import MessageRow from "./message-row"
import pagination from "../../common/pagination"

export default {
    props:["current", "slotProps", "pagination", "messages"],
    components:{
      MessageRow,
      pagination
    }
}
</script>
