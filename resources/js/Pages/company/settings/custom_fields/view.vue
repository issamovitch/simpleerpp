<template>
    <div class="row">
        <div v-if="field.model==model" v-for="field in custom_fields" :class="get_class(field)">
            <div class="form-group">
                <label class="label">{{field.name}} <span v-if="field.required" class="text-danger">*</span></label>
                <template v-if="field.type=='Text'">
                    <input class="form-control" maxlength="300" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" />
                </template>
                <template v-if="field.type=='Textarea'">
                    <textarea class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder"></textarea>
                </template>
                <template v-if="field.type=='Select'">
                    <v-select :options="field.options" :class="(highlight_field_id==field.id)?'highlight':''" :name="'field_'+field.id"
                              :placeholder="field.placeholder" v-bind:required="field.required"></v-select>
                </template>
                <template v-else-if="field.type=='Multi Select'">
                    <v-select :options="field.options" :class="(highlight_field_id==field.id)?'highlight':''" :name="'field_'+field.id+'[]'"
                              :placeholder="field.placeholder" multiple v-bind:required="field.required"></v-select>
                </template>
                <template v-else-if="field.type=='Checkbox'">
                    <label v-for="option in field.options" class="d-block">
                        <input type="checkbox" :name="'field_'+field.id" :value="option" v-bind:required="field.required"> {{option}}
                    </label>
                </template>
                <template v-else-if="field.type=='Radio'">
                    <label v-for="option in field.options" class="d-block">
                        <input type="radio" :name="'field_'+field.id" :value="option" v-bind:required="field.required"> {{option}}
                    </label>
                </template>
                <template v-if="field.type=='Date'">
                    <input type="date" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" />
                </template>
                <template v-if="field.type=='Time'">
                    <input type="time" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" />
                </template>
                <template v-if="field.type=='DateTime'">
                    <input type="datetime-local" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" />
                </template>
                <template v-if="field.type=='Number'">
                    <input type="number" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" />
                </template>
                <template v-if="field.type=='Color'">
                    <input type="color" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" />
                </template>
                <template v-if="field.type=='Url'">
                    <input type="url" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" />
                </template>
                <div v-if="['Checkbox', 'Radio', 'Date', 'Time'].includes(field.type)" style="height: 24px; overflow-y: auto" class="placeholder">{{field.placeholder}}</div>
            </div>
        </div>
    </div>
</template>

<script>

import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

export default {
        components:{
            vSelect,
        },
        name: "view-custom-fields",
        props: ["custom_fields", "model", "highlight_field_id"],
        methods:{
            get_class(field){
                let _class = 'col-sm-'+field.width+ ' '
                _class += (this.highlight_field_id==field.id) ? 'highlight' : ''
                return _class
            }
        },
    }

</script>

<style scoped>
    .highlight .label::before{
        content: "\F0EB";
        font-family: 'Font Awesome 5 Free';
        display: inline-block;
        margin-right: 5px;
    }
    .highlight .label{
        color: #007bff !important;
    }
    .highlight .form-control{
        border-color: #007bff !important;
    }
</style>
