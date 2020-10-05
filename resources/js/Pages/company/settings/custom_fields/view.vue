<template>
    <div class="row">
        <div v-if="field.model==model" v-for="field in custom_fields" :class="get_class(field)">
            <div class="form-group">
                <label class="label">{{field.name}} <span v-if="field.required" class="text-danger">*</span></label>
                <template v-if="field.type=='Text'">
                    <input class="form-control" maxlength="300" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder"
                    :value="field.value"/>
                </template>
                <template v-if="field.type=='Textarea'">
                    <textarea class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder">{{field.value}}</textarea>
                </template>
                <template v-if="field.type=='Select'">
                    <select :options="field.options" :class="(highlight_field_id==field.id)?'highlight':''" :name="'field_'+field.id"
                            v-bind:required="field.required" class="form-control" :value="field.value">
                        <option value="">{{field.placeholder}}</option>
                        <option v-if="field.options" v-for="option in field.options" :value="option">{{option}}</option>
                    </select>
                </template>
                <template v-if="field.type=='Multi Select'">
                    <select :options="field.options" :class="(highlight_field_id==field.id)?'highlight':''" :name="'field_'+field.id+'[]'"
                            v-bind:required="field.required" multiple class="form-control">
                        <option value="">{{field.placeholder}}</option>
                        <option v-bind:selected="field.value &&field.value.split(',').includes(option)" v-if="field.options" v-for="option in field.options" :value="option">{{option}}</option>
                    </select>
                </template>
                <template v-if="field.type=='Checkbox'">
                    <label v-for="(option, i) in field.options" class="d-block">
                        <input type="checkbox" v-bind:checked="field.value &&field.value.split(',').includes(option)" :name="'field_'+field.id+'[]'" :value="option"> {{option}}
                    </label>
                </template>
                <template v-if="field.type=='Radio'">
                    <label v-for="option in field.options" class="d-block">
                        <input type="radio" v-bind:checked="field.value &&field.value.split(',').includes(option)" :name="'field_'+field.id" :value="option" v-bind:required="field.required"> {{option}}
                    </label>
                </template>
                <template v-if="field.type=='Date'">
                    <input type="date" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" :value="field.value" />
                </template>
                <template v-if="field.type=='Time'">
                    <input type="time" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" :value="field.value" />
                </template>
                <template v-if="field.type=='DateTime'">
                    <input type="datetime-local" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" :value="field.value" />
                </template>
                <template v-if="field.type=='Number'">
                    <input type="number" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" :value="field.value" />
                </template>
                <template v-if="field.type=='Color'">
                    <input type="color" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" :value="field.value" />
                </template>
                <template v-if="field.type=='Url'">
                    <input type="url" class="form-control" :name="'field_'+field.id" v-bind:required="field.required" :placeholder="field.placeholder" :value="field.value" />
                </template>
                <div v-if="['Checkbox', 'Radio', 'Date', 'Time'].includes(field.type)" style="height: 24px; overflow-y: auto" class="placeholder">{{field.placeholder}}</div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
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
