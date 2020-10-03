<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <Inertia-link :href="route('dashboard')" class="brand-link">
            <img :src="$page.flash.logo"
                 class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{$page.flash.app_name}}</span>
        </Inertia-link>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <Inertia-link :href="route('dashboard')" class="nav-link" v-bind:class="{'active': current_route()=='dashboard'}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>{{__("l.Dashboard")}}</p>
                        </Inertia-link>
                    </li>
                    <li class="nav-item">
                        <Inertia-link :href="route('users.index')" class="nav-link" v-bind:class="{'active': current_route('users.*')}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>{{__("l.Users")}}</p>
                        </Inertia-link>
                    </li>
                    <li class="nav-item">
                        <Inertia-link :href="route('clients.index')" class="nav-link" v-bind:class="{'active': current_route('clients.*')}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>{{__("l.Clients")}}</p>
                        </Inertia-link>
                    </li>
                    <li class="nav-item">
                        <Inertia-link :href="route('mailbox.inbox')" class="nav-link" v-bind:class="{'active': current_route('mailbox.*')}">
                            <i class="nav-icon far fa-envelope"></i>
                            <p>{{__("l.Mailbox")}}</p>
                            <span v-if="$page.flash.unread_messages.length>0" class="badge bg-danger float-right">{{$page.flash.unread_messages.length}}</span>
                        </Inertia-link>
                    </li>
                    <li class="nav-item">
                        <Inertia-link :href="route('settings.index')" class="nav-link" v-bind:class="{'active': current_route('settings.*')}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>{{ __("l.Settings") }}</p>
                        </Inertia-link>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Dashboard
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../../index.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v1</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../../index2.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v2</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../../index3.html" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Dashboard v3</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
export default {
    mounted(){
    }
}
</script>

<style scoped>
.brand-image{
    width: 33px !important;
    height: 33px !important;
}
</style>
