<template>
    <mailbox v-if="messages" v-slot="slotProps" current="inbox">
        <mailbox-folder current="inbox" :slotProps="slotProps" :pagination="pagination" :messages="messages" />
    </mailbox>
</template>

<script>

import mailbox from "./mailbox";
import MailboxFolder from "./mailbox-folder"

export default {
    props: ["messages", "pagination"],
    components:{
        mailbox,
        MailboxFolder
    }
}

</script>
