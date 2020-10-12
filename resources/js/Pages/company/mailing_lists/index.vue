 <template>
        <company :title="__('l.Mailing Lists')" :current="__('l.Mailing Lists')">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">{{ __("l.Mailing Lists") }}</h3>
                    <div class="float-right">
                        <a href="#" @click="add_modal" data-toggle="modal" data-target="#add_mailing_list" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-plus"></i> <span>{{__("l.Add Mailing List")}}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form v-if="list" @submit.prevent="add_mailing_list" id="add_mailing_list" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h4 v-if="action=='add'" class="modal-title">{{__("l.Add Mailing List")}}</h4>
                                    <h4 v-else class="modal-title">{{__("l.Edit Mailing List")}}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input v-if="list.id!='0'" type="hidden" name="id" :value="list.id">
                                    <div class="form-group">
                                        <label>{{__("l.Name")}} <span class="text-danger">*</span></label>
                                        <input v-model="list.name" type="text" class="form-control" name="name" required autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <button @click="add_custom_field" type="button" class="btn btn-default"><i class="fa fa-plus"></i> {{__("l.Add Custom Field")}}</button>
                                        <div v-for="field in list.fields" class="input-group mt-2">
                                            <input type="text" v-model="field.name" :name="(field.id=='0')?'new_field_'+field.num:'old_field_'+field.id" class="form-control" required :placeholder="__('l.Enter Field Name')" autocomplete="off">
                                            <div class="input-group-btn">
                                                <button v-if="field.id=='0'" @click="delete_custom_field(field.num)" class="btn btn-default" type="button"><i class="fa fa-times text-danger"></i></button>
                                                <button v-else @click="delete_custom_field_axios(field.id)" class="btn btn-default" type="button"><i class="fa fa-times text-danger"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right mb-0 mt-5">
                                        <button type="submit" class="btn btn-primary w-150"><i class="fa fa-save"></i> {{__("l.Save")}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>{{__("l.Name")}}</th>
                                <th width="100">{{__("l.N° Emails")}}</th>
                                <th width="200">{{__("l.Custom Fields")}}</th>
                                <th width="160">{{__("l.Created At")}}</th>
                                <th class="text-center" width="240">{{__("l.Actions")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(list, i) in lists">
                                <td class="text-center">{{ i + 1 }}</td>
                                <td>{{list.name}}</td>
                                <td class="text-center">{{list.emails_count}}</td>
                                <td><ul class="pl-3 m-0"><li v-for="field in list.fields">{{field.name}}</li></ul></td>
                                <td>{{list.created_at|format-date-time}}</td>
                                <td class="text-center align-middle">
                                    <inertia-link :href="route('mailing_lists.view', list.id)" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> {{__("l.Emails")}}</inertia-link>
                                    <a  href="#" @click="edit_modal(list)" data-toggle="modal" data-target="#add_mailing_list" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> {{__("l.Edit")}}</a>
                                    <a href="#" @click.prevent="delete_list(list.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> {{__("l.Delete")}}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </company>
</template>

<script>

import company from "../layout/company"
import service from "../../../service";

export default {
    props : ["lists"],
    components:{
        company
    },
    data() {
        return {
            action: "add",
            list: null,
            empty_list: {id: "0", name: "", fields: []},
        }
    },
    mounted() {
        this.list = this.empty_list
    },
    methods: {
        add_custom_field(){
            let num = this.list.fields.length+1
            this.list.fields.push({id: "0", num: num, name: ""})
        },
        delete_custom_field(num){
            this.list.fields = this.list.fields.filter(function( field ) {
                return field.num !== num;
            });
        },
        async delete_custom_field_axios(id){
            if(await service.confirmation()){
                this.list.fields = this.list.fields.filter(function( field ) {
                    return field.id !== id;
                });
                axios.get(this.route('mailing_lists.delete_field', id))
            }
        },
        add_mailing_list(){
            $("#add_mailing_list").modal("hide")
            let data = new FormData(document.getElementById("add_mailing_list"))
            let url = (this.list.id=='0')? this.route('mailing_lists.save'): this.route('mailing_lists.update')
            this.$inertia.post(url, data, {preserveState: false, preserveScroll: true})
        },
        add_modal(){
            this.action = "add"
            this.list = this.empty_list
        },
        edit_modal(list){
            this.action = "edit"
            this.list = list
            this.list.fields.forEach((field, i) => {
                field.num = i+1;
            })
        },
        async delete_list(id){
            let url = this.route("mailing_lists.delete", id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}
</script>

<style scoped>

</style>
