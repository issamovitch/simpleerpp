<template>
    <company :title="__('l.Clients')" :pn="__('l.Clients List')" :pl="route('clients.index')" :current="__('l.Client Details')">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title float-left">{{ __("l.Client Details") }}</h3>
                <div class="float-right">
                    <Inertia-link :href="route('clients.index')" class="btn btn-xs btn-primary float-right ml-3"><i class="fa fa-list"></i> <span>{{__("l.Clients List")}}</span></Inertia-link>
                </div>
            </div>
            <div class="card-body">

                <div class="client-details">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="form-group mb-0">
                                <h5 class="d-inline-block"><b>{{client.name}}</b></h5>
                                <span v-if="client.type==0">{{__("l.Particular")}}</span>
                                <span v-else>{{__("l.Company")}}</span>
                            </div>
                            <div class="form-group mb-0" v-if="client.type == 0">
                                <label v-if="client.company"><span>{{__("l.Company")}}</span></label> : {{$client.company.name}}
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><span>{{__("l.Reference")}}</span></label> : {{client.reference}}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><span>{{__("l.Sector")}}</span></label> : {{client.sector.name}}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label><span>{{__("l.Client Group")}}</span></label> : {{client.group.name}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group float-right">
                                <img v-if="client.image" :src="asset('storage/app/'+ client.image)" class="w-150 border" />
                                <img v-else :src="asset('public/no-image.png')" class="w-150 border"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-2"><label>{{__("l.Address")}}</label></div>
                                <div class="col-sm-10">
                                    <div><label>{{__("l.Street")}}</label> : {{client.street}}</div>
                                    <div><label>{{__("l.Street 2")}}</label> : {{client.street2}}</div>
                                    <div><label>{{__("l.City")}}</label> : {{client.city}}</div>
                                    <div><label>{{__("l.State")}}</label> : {{client.state}}</div>
                                    <div>
                                        <label>{{__("l.Country")}}</label> :
                                        <span v-if="client.country==country" v-for="country in countries">{{country}}</span>
                                    </div>
                                    <div><label>{{__("l.Postal Code")}}</label> : {{client.postal_code}}</div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-2"><label>{{__("l.N° TVA")}}</label></div>
                                <div class="col-sm-10">{{client.tva_num}}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div><label>{{__("l.Phone")}}</label> : {{client.phone}}</div>
                            <div><label>{{__("l.Mobile")}}</label> : {{client.mobile}}</div>
                            <div><label>{{__("l.Email")}}</label> : {{client.email}}</div>
                            <div><label>{{__("l.Website")}}</label> : {{client.website}}</div>
                        </div>
                    </div>
                    <div class="row mt-0" v-if="client.notes && client.notes != ''">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>{{__("l.Notes")}}</label> :
                                <div class="attachment-block p-3">{{client.notes}}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-pills mt-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#tab1" role="tab" aria-controls="home" aria-selected="true">{{__("l.Contacts & Adresses")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-controls="profile" aria-selected="false">{{__("l.Projects")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-controls="contact" aria-selected="false">{{__("l.Estimates")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab4" role="tab" aria-controls="contact" aria-selected="false">{{__("l.Invoices")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab5" role="tab" aria-controls="contact" aria-selected="false">{{__("l.Payments")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab6" role="tab" aria-controls="contact" aria-selected="false">{{__("l.Expenses")}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab7" role="tab" aria-controls="contact" aria-selected="false">{{__("l.Events")}}</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent" style="min-height: 300px;">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="home-tab">...</div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="profile-tab">...</div>
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="contact-tab">...</div>
                    <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>

            </div>
        </div>
    </company>
</template>

<script>

import company from "../layout/company"

export default {
    props : ["client", "sectors", "companies", "client_groups"],
    components:{
        company
    }
}

</script>
