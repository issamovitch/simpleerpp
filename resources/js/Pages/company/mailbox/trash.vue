<template>
    <mailbox v-if="messages" v-slot="slotProps" current="trash">
        <mailbox-folder current="trash" :slotProps="slotProps" :pagination="pagination" :messages="messages" />
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
