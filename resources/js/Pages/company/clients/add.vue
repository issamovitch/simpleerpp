<template>
    <company :title="__('l.Clients')" :pn="__('l.Clients List')" :pl="route('clients.index')" :current="__('l.Add Client')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Add Client") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('clients.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__("l.Clients List")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body" style="min-height: 500px">
                <form id="clients_save" @submit.prevent="clients_save" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label class="mr-3"><input v-model="type" class="type" type="radio" name="type" value="0"> {{__("l.Particular")}}</label>
                                <label><input v-model="type" class="type" type="radio" name="type" value="1"> {{__("l.Company")}}</label>
                            </div>
                            <div class="form-group">
                                <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required autocomplete="off">
                            </div>
                            <div v-if="type==0" class="form-group">
                                <label><span>{{__("l.Company")}}</span></label>
                                <select name="company" class="form-control">
                                    <option value="">{{__("l.Choose")}}</option>
                                    <option v-for="company in companies" :value="company.id">{{company.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group float-right">
                                <input type="file" class="form-control" @change="previewFiles" ref="file" name="image" accept="image/*" style="display: none">
                                <img :src="asset('public/no-image.png')" ref="image" v-on:click="$refs.file.click()" class="image_user_add" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><span>{{__("l.Reference")}}</span> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" v-model="reference" name="reference" class="form-control reference" required>
                                    <div class="input-group-append">
                                        <a href="#" v-bind:disabled="btn_disabled" @click.prevent="generate_reference" class="btn btn-primary">{{__("l.Generate")}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><span>{{__("l.Sector")}}</span></label>
                                <div class="input-group">
                                    <select name="sector_id" id="sector_id" class="form-control" >
                                        <option value="">{{__("l.Choose")}}</option>
                                        <optgroup v-for="v in sectors_values" :label="v" :data-setor="v">
                                            <option v-if="sector.sector == v" v-for="sector in sectors" :value="sector.id">{{sector.name}}</option>
                                        </optgroup>
                                    </select>
                                    <div class="input-group-append">
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#sectors_save"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label><span>{{__("l.Client Group")}}</span></label>
                                <div class="input-group">
                                    <select name="client_group_id" class="form-control" id="client_group_id">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option v-for="client_group in client_groups" :value="client_group.id">{{client_group.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <a href="#" data-toggle="modal" data-target="#save_client_group" class="btn btn-primary btn-save_client_group"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2"><label>{{__("l.Address")}}</label></div>
                                <div class="col-sm-10">
                                    <input type="text" name="street" class="form-control mb-3" :placeholder="__('l.Street')+'...'">
                                    <input type="text" name="street2" class="form-control mb-3" :placeholder="__('l.Street 2')+'...'">
                                    <input type="text" name="city" class="form-control mb-3" :placeholder="__('l.City')">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <input type="text" name="state" class="form-control mb-3" :placeholder="__('l.State')">
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control select2" name="country" autocomplete="off">
                                                <option value="">{{__("l.Country")}}</option>
                                                <option v-for="(v, k) in countries" :value="k">{{v}}</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" name="postal_code" class="form-control mb-2" :placeholder="__('l.Postal Code')">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"><label>{{__("l.N° TVA")}}</label></div>
                                <div class="col-sm-10">
                                    <input type="text" name="tva_num" class="form-control" :placeholder="__('l.N° TVA')">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row mb-3">
                                <div class="col-sm-3"><label>{{__("l.Phone")}}</label></div>
                                <div class="col-sm-9">
                                    <input type="text" name="phone" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><label>{{__("l.Mobile")}}</label></div>
                                <div class="col-sm-9">
                                    <input type="text" name="mobile" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3"><label>{{__("l.Email")}}</label></div>
                                <div class="col-sm-9">
                                    <input type="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"><label>{{__("l.Website")}}</label></div>
                                <div class="col-sm-9">
                                    <input type="text" name="website" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>{{__("l.Notes")}}</label>
                                <textarea name="notes" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4 mt-5">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-150"><i class="fa fa-save"></i>
                                    <span>{{__("l.Save")}}</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <form @submit.prevent="sectors_save" class="modal fade" id="sectors_save">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__("l.Add Sector")}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><span>{{__("l.Sector")}}</span> <span class="text-danger">*</span></label>
                            <select class="form-control" name="sector">
                                <option value="">{{__("l.Choose")}}</option>
                                <option v-for="v in sectors_values" :value="v">{{__("l."+v)}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control name" name="name" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary w-150"><i class="fa fa-save"></i> <span>{{__("l.Save")}}</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <form @submit.prevent="save_client_group" class="modal fade" id="save_client_group">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{__("l.Add Client Group")}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><span>{{__("l.Name")}}</span> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control name" name="name" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary w-150"><i class="fa fa-save"></i> <span>{{__("l.Save")}}</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </company>
</template>

<script>

import company from "../layout/company"

export default {
    data() {
        return {
            type : 1,
            reference : null,
            btn_disabled : false
        }
    },
    props : ["sectors", "sectors_values", "companies", "client_groups", "countries"],
    components:{
        company
    },
    methods: {
        previewFiles(e) {
            let file = e.target.files[0];
            this.$refs.image.src = URL.createObjectURL(file);
        },
        async generate_reference(){
            this.btn_disabled = true;
            var url = this.route("clients.reference_unique");
            await axios.get(url).then(ref => this.reference = ref.data).catch(e => console.log(e));
            this.btn_disabled = false
        },
        async sectors_save(e){
            $("#sectors_save").modal("hide")
            var url = this.route('clients.sectors_save');
            var data = new FormData(document.getElementById("sectors_save"));
            await axios.post(url, data).then(res => {
                let sector = res.data
                var html = "<option value='"+sector.id+"'>"+sector.name+"</option>"
                $("#sector_id optgroup[data-setor='"+sector.sector+"']").append(html)
                $("#sector_id").val(sector.id)
                $("#sectors_save").trigger("reset")
            }).catch(e => console.log(e));
        },
        async save_client_group(e){
            $("#save_client_group").modal("hide")
            var url = this.route('clients.save_client_group');
            var data = new FormData(document.getElementById("save_client_group"));
            await axios.post(url, data).then(res => {
                let client_group = res.data
                var html = "<option value='"+client_group.id+"'>"+client_group.name+"</option>"
                $("#client_group_id").append(html)
                $("#client_group_id").val(client_group.id)
                $("#save_client_group").trigger("reset")
            }).catch(e => console.log(e));
        },
        clients_save(){
            let data = new FormData(document.getElementById("clients_save"))
            this.$inertia.post(this.route('clients.save'), data, {preserveState: false})
        }
    }
}

</script>
