 <template>
        <company :title="__('l.Mailing Lists')" :pn="__('l.Mailing Lists')" :pl="route('mailing_lists.index')" :current="__('l.Mailing List')+' `'+list.name+'`'">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title float-left">{{__('l.Mailing List')+' `'+list.name+'`'}}</h3>
                    <div class="float-right">
                        <inertia-link :href="route('mailing_lists.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__('l.Mailing Lists')}}</span></inertia-link>
                        <a href="#" @click="add_modal" data-toggle="modal" data-target="#add_email" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-plus"></i> <span>{{__("l.Add Email")}}</span></a>
                    </div>
                </div>
                <div class="card-body">
                    <form v-if="email" @submit.prevent="add_email" id="add_email" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h4 v-if="action=='add'" class="modal-title">{{__("l.Add Email")}}</h4>
                                    <h4 v-else class="modal-title">{{__("l.Edit Email")}}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <input v-if="email.id!='0'" type="hidden" name="id" :value="email.id">
                                    <input type="hidden" name="mailing_list_id" :value="list.id">
                                    <div class="form-group">
                                        <label>{{__("l.Email")}} <span class="text-danger">*</span></label>
                                        <input v-model="email.email" type="email" class="form-control" name="email" required autocomplete="off">
                                    </div>
                                    <div v-for="field in list.fields" class="form-group">
                                        <label>{{field.name}}</label>
                                        <input type="text" class="form-control"
                                               :value="(email.id!='0')?(email.values[field.id])?email.values[field.id].value:'':''"
                                               :name="'field_'+field.id" autocomplete="off">
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
                                <th>{{__("l.Email")}}</th>
                                <th v-for="field in list.fields">{{field.name}}</th>
                                <th width="160">{{__("l.Created At")}}</th>
                                <th class="text-center" width="240">{{__("l.Actions")}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(email, i) in list.emails">
                                <td class="text-center">{{ i + 1 }}</td>
                                <td>{{email.email}}</td>
                                <td v-for="field in list.fields">
                                    {{(email.values[field.id])?email.values[field.id].value:''}}
                                </td>
                                <td>{{list.created_at|format-date-time}}</td>
                                <td class="text-center align-middle">
                                    <a href="#" @click="edit_modal(email)" data-toggle="modal" data-target="#add_email" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> {{__("l.Edit")}}</a>
                                    <a href="#" @click.prevent="delete_email(email.id)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> {{__("l.Delete")}}</a>
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
    props : ["list"],
    components:{
        company
    },
    data() {
        return {
            action: "add",
            email: null,
            empty_email: {id: "0", email: ""},
        }
    },
    mounted() {
        this.email = this.empty_email
    },
    methods: {
        add_modal(){
            this.action = "add"
            this.email = this.empty_email
        },
        edit_modal(email){
            this.action = "edit"
            this.email = email
        },
        add_email(){
            $("#add_email").modal("hide")
            let data = new FormData(document.getElementById("add_email"))
            let url = (this.email.id=='0')? this.route('mailing_lists.save_email'): this.route('mailing_lists.update_email')
            this.$inertia.post(url, data, {preserveState: false, preserveScroll: true})
        },
        async delete_email(id){
            let url = this.route("mailing_lists.delete_email", id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}
</script>

<style scoped>

</style>
