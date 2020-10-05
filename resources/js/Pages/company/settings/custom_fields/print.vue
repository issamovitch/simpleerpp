<template>
    <div class="row">
        <div v-for="field in custom_fields" :class="'col-sm-'+field.width">
            <div class="form-group">
                <label class="label">{{field.name}}</label>
                <div class="attachment-block p-3" :style="(field.type=='Color')?'color:'+field.value+' !important;':''">{{field.value}}</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "print-custom-fields",
    props: ["custom_fields"],
}

</script>
