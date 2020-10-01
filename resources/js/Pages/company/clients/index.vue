<template>
    <company :title="__('l.Clients')" :current="__('l.Clients List')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Clients List") }}</h3>
                <div class="float-right">
                    <a href="#" v-on:click.prevent="view_clients(false)" :class="{'btn-primary': !table_clients, 'btn-default': table_clients}" class="btn-grid btn btn-xs float-right"><i class="fa fa-th-large"></i></a>
                    <a href="#" v-on:click.prevent="view_clients(true)" :class="{'btn-primary': table_clients, 'btn-default': !table_clients}" class="btn-table btn btn-xs float-right ml-3"><i class="fa fa-list"></i></a>
                    <Inertia-link :href="route('clients.add')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-plus"></i> <span>{{__("l.Add Client")}}</span></Inertia-link>
                    <div class="dropdown float-right ml-3">
                        <button v-on:click="show_filter=!show_filter" class="btn btn-xs btn-primary w-150"><i class="fa fa-filter"></i> <span>{{__("l.Filters")}}</span></button>
                        <div v-if="show_filter" id="dropdownMenuButton">
                            <div class="input-group">
                                <div class="input-group-prepend w-120">
                                    <span class="input-group-text w-120">{{__("l.Filter By")}}</span>
                                </div>
                                <select class="form-control" v-on:change="select_filter_types">
                                    <option value="">{{__("l.Choose")}}</option>
                                    <option v-bind:disabled="name_do_filter" value="name">{{__("l.Name")}}</option>
                                    <option v-bind:disabled="reference_do_filter" value="reference">{{__("l.Reference")}}</option>
                                    <option v-bind:disabled="tva_num_do_filter" value="tva_num">{{__("l.N° TVA")}}</option>
                                    <option v-bind:disabled="email_do_filter" value="email">{{__("l.Email")}}</option>
                                    <option v-bind:disabled="phone_do_filter" value="phone">{{__("l.Phone")}}</option>
                                    <option v-bind:disabled="mobile_do_filter" value="mobile">{{__("l.Mobile")}}</option>
                                    <option v-bind:disabled="sector_do_filter" value="sector">{{__("l.Sector")}}</option>
                                    <option v-bind:disabled="group_do_filter" value="group">{{__("l.Client Group")}}</option>
                                    <option v-bind:disabled="type_do_filter" value="type">{{__("l.Type")}}</option>
                                    <option v-bind:disabled="country_do_filter" value="country">{{__("l.Country")}}</option>
                                </select>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="name_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Name")}}</div></div>
                                    <input v-model="name_filter" type="text" class="form-control" :placeholder="__('l.Name')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="name_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="reference_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Reference")}}</div></div>
                                    <input v-model="reference_filter" type="text" class="form-control" :placeholder="__('l.Reference')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="reference_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="tva_num_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.N° TVA")}}</div></div>
                                    <input v-model="tva_num_filter" type="text" class="form-control" :placeholder="__('l.N° TVA')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="tva_num_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="email_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Email")}}</div></div>
                                    <input v-model="email_filter" type="text" class="form-control" :placeholder="__('l.Email')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="email_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="phone_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Phone")}}</div></div>
                                    <input v-model="phone_filter" type="text" class="form-control" :placeholder="__('l.Phone')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="phone_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="mobile_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Mobile")}}</div></div>
                                    <input v-model="mobile_filter" type="text" class="form-control" :placeholder="__('l.Mobile')" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="mobile_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="sector_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Sector")}}</div></div>
                                    <select v-model="sector_filter" type="text" class="form-control" :placeholder="__('l.Sector')" autocomplete="off">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option v-for="sector in sectors" :value="sector.id">{{sector.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="sector_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="group_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Client Group")}}</div></div>
                                    <select v-model="group_filter" type="text" class="form-control" :placeholder="__('l.Client Group')" autocomplete="off">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option v-for="group in client_groups" :value="group.id">{{group.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="group_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="type_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Type")}}</div></div>
                                    <select v-model="type_filter" type="text" class="form-control" :placeholder="__('l.Type')" autocomplete="off">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option value="0">{{__("l.Particular")}}</option>
                                        <option value="1">{{__("l.Company")}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="type_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0" v-if="country_do_filter">
                                <div class="input-group">
                                    <div class="input-group-prepend w-120"><div class="input-group-text w-120">{{__("l.Country")}}</div></div>
                                    <select v-model="country_filter" type="text" class="form-control" :placeholder="__('l.Country')" autocomplete="off">
                                        <option value="">{{__("l.Choose")}}</option>
                                        <option v-for="(v, k) in countries" :value="k">{{v}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><a href="#"v-on:click.prevent="country_do_filter=false" class="text-danger"><i class="fa fa-times"></i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="min-height: 500px">
                <table v-if="table_clients" class="table table-bordered table-striped table-hover">
                    <thead class="bg-white">
                        <tr>
                            <th width="50">#</th>
                            <th>{{__("l.Image")}}</th>
                            <th>{{__("l.Reference")}}</th>
                            <th>{{__("l.Name")}}</th>
                            <th>{{__("l.Type")}}</th>
                            <th>{{__("l.Company")}}</th>
                            <th>{{__("l.Client Group")}}</th>
                            <th width="100">{{__("l.Actions")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(client, i) in filtered_clients" v-if="filtered_clients.length>0">
                            <td class="text-center align-middle">{{ i + 1 }}</td>
                            <td class="align-middle" width="90">
                                <Inertia-link :href="route('clients.view', client.id)">
                                    <img v-if="client.image" :src="asset('/storage/app/'+client.image)" alt="" class="img-thumbnail user-image-list">
                                    <img v-else :src="asset('public/no-image.png')" alt="" class="img-thumbnail user-image-list">
                                </Inertia-link>
                            </td>
                            <td class="align-middle">{{client.reference}}</td>
                            <td class="align-middle">{{client.name}}</td>
                            <td class="align-middle">
                                <span v-if="client.type==0">{{__("l.Particular")}}</span>
                                <span v-else>{{__("l.Company")}}</span>
                            </td>
                            <td class="align-middle">
                                <span v-if="client.type==0 && client.company">{{client.company.name}}</span>
                            </td>
                            <td class="align-middle">
                                <span v-if="client.group">{{client.group.name}}</span>
                            </td>
                            <td class="text-center align-middle">
                                <Inertia-link :href="route('clients.view', client.id)" class="btn btn-info btn-xs btn-block mb-1"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></Inertia-link>
                                <Inertia-link :href="route('clients.edit', client.id)" class="btn btn-success btn-xs btn-block mb-1"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></Inertia-link>
                                <Inertia-link href="#" v-on:click.prevent="delete_client(client.id)" class="btn btn-danger btn-xs btn-block"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                            </td>
                        </tr>
                        <tr v-if="filtered_clients.length==0">
                            <td colspan="8" class="text-center"><b>{{__("l.No Data")}}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div v-if="!table_clients" id="grid-users">
                    <div class="row">
                        <div v-for="client in filtered_clients" class="col-sm-4 user">
                            <div class="card p-2 position-relative" style="height: 120px;">
                                <a href="" data-toggle="dropdown" class="dropdown-toggle position-absolute" style="z-index: 2; top: 3px; right: 4px; color: #d0d0d0; font-size: 0.9em;"><i class="fa fa-cog"></i></a>
                                <div class="dropdown-menu">
                                    <Inertia-link :href="route('clients.view', client.id)" class="dropdown-item text-gray"><i class="fa fa-eye"></i> <span>{{__("l.View")}}</span></Inertia-link>
                                    <Inertia-link :href="route('clients.edit', client.id)" class="dropdown-item text-gray"><i class="fa fa-edit"></i> <span>{{__("l.Edit")}}</span></Inertia-link>
                                    <Inertia-link href="#" v-on:click.prevent="delete_client(client.id)" class="dropdown-item text-gray"><i class="fa fa-trash"></i> <span>{{__("l.Delete")}}</span></Inertia-link>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <Inertia-link :href="route('clients.view', client.id)">
                                            <img v-if="client.image" :src="asset('/storage/app/'+client.image)" alt="" class="user-image-grid">
                                            <img v-else :src="asset('public/no-image.png')" alt="" class="user-image-grid">
                                        </Inertia-link>
                                    </div>
                                    <div class="col-sm-9">
                                        <h6><Inertia-link :href="route('clients.view', client.id)"><b class="text-dark">{{client.name}}</b></Inertia-link></h6>
                                        <h6>{{__("l.Ref")}} : {{client.reference}}</h6>
                                        <h6>{{(client.type==0)?__('l.Particular'):__('l.Company')}}</h6>
                                        <h6>{{(client.group)?client.group.name:''}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="backdrop" v-if="show_filter" @click="show_filter=false"></div>
    </company>
</template>

<script>

import company from "../layout/company"
import service from "../../../service";

export default {
    computed:{
        filtered_clients(){
            return this.clients.filter(client =>{
                if(this.name_do_filter && this.name_filter != "")
                    if(!client.name.includes(this.name_filter))
                        return false
                if(this.reference_do_filter && this.reference_filter != "")
                    if(!client.reference.includes(this.reference_filter))
                        return false
                if(this.tva_num_do_filter && this.tva_num_filter != "")
                    if(!client.tva_num || !client.tva_num.includes(this.tva_num_filter))
                        return false
                if(this.email_do_filter && this.email_filter != "")
                    if(!client.email || !client.email.includes(this.email_filter))
                        return false
                if(this.phone_do_filter && this.phone_filter != "")
                    if(!client.phone || !client.phone.includes(this.phone_filter))
                        return false
                if(this.mobile_do_filter && this.mobile_filter != "")
                    if(!client.mobile || !client.mobile.includes(this.mobile_filter))
                        return false
                if(this.sector_do_filter && this.sector_filter != "")
                    if(!client.sector_id || client.sector_id != this.sector_filter)
                        return false
                if(this.group_do_filter && this.group_filter != "")
                    if(!client.client_group_id || client.client_group_id != this.group_filter)
                        return false
                if(this.type_do_filter && this.type_filter != "")
                    if(client.type != this.type_filter)
                        return false
                if(this.country_do_filter && this.country_filter != "")
                    if(client.country != this.country_filter)
                        return false
                return true
            })
        }
    },
    data(){
      return {
          show_filter : false,
          name_do_filter : false,
          name_filter : "",
          reference_do_filter : false,
          reference_filter : "",
          tva_num_do_filter : false,
          tva_num_filter : "",
          email_do_filter : false,
          email_filter : "",
          phone_do_filter : false,
          phone_filter : "",
          mobile_do_filter : false,
          mobile_filter : "",
          sector_do_filter : false,
          sector_filter : "",
          group_do_filter : false,
          group_filter : "",
          type_do_filter : false,
          type_filter : "",
          country_do_filter : false,
          country_filter : "",
          table_clients: (localStorage.table_clients) ? (localStorage.table_clients==='true') ? true : false : true,
      }
    },
    props : ["clients", "sectors", "client_groups", "countries"],
    components:{
        company
    },methods:{
        view_clients(boolean){
            this.table_clients = boolean;
            localStorage.table_clients= boolean
        },
        select_filter_types(e){
            if(e.target.value){
                this[e.target.value+"_do_filter"] = true;
            }
        },
        async delete_client(id){
            let url = this.route("clients.delete", id);
            if(await service.confirmation()){
                this.$inertia.visit(url,  {preserveState: false, preserveScroll: true})
            }
        },
    }
}
</script>

<style scoped>

.dropdown-toggle::after{
    display: none;
}

#dropdownMenuButton{
    width: 400px;
    border: 1px solid #eee;
    padding: 10px;
    position: absolute;
    left: -100px;
    background: #fff;
    z-index: 10401;
}

.backdrop{
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
}

</style>
