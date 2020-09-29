<template>
    <company :title="title" :pn="pn" :pl="pl" :current="current">
        <div class="card">
            <div class="card-header">{{ __("l.Settings") }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                             aria-orientation="vertical">
                            <Inertia-link :href="route('settings.general_settings')" v-bind:class="{'active' : current_route()=='settings.general_settings'}" class="nav-link">
                                {{ __("l.General Settings") }}
                            </Inertia-link>
                            <Inertia-link :href="route('settings.smtp_settings')" v-bind:class="{'active' : current_route()=='settings.smtp_settings'}" class="nav-link">
                                {{ __("l.SMTP Settings") }}
                            </Inertia-link>
                            <Inertia-link :href="route('settings.roles')" v-bind:class="{'active' : current_route()=='settings.roles'}" class="nav-link">
                                {{ __("l.Roles") }}
                            </Inertia-link>
                            <Inertia-link :href="route('settings.designations')" v-bind:class="{'active' : current_route()=='settings.designations'}" class="nav-link">
                                {{ __("l.Designations") }}
                            </Inertia-link>
                            <Inertia-link :href="route('settings.departments')" v-bind:class="{'active' : current_route()=='settings.departments'}" class="nav-link">
                                {{ __("l.Departments") }}
                            </Inertia-link>
                            <Inertia-link :href="route('settings.sectors')" v-bind:class="{'active' : current_route()=='settings.sectors'}" class="nav-link">
                                {{ __("l.Sectors") }}
                            </Inertia-link>
                            <Inertia-link :href="route('settings.client_groups')" v-bind:class="{'active' : current_route()=='settings.client_groups'}" class="nav-link">
                                {{ __("l.Client Groups") }}
                            </Inertia-link>
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <slot/>
                    </div>
                </div>
            </div>
        </div>
    </company>
</template>

<script>

import company from "../layout/company";

export default {
    props: ["title", "pn", "pl", "current"],
    components: {
      company
    },
}
</script>
