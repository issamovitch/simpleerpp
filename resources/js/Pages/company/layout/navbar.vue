<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <Inertia-Link :href="route('dashboard')" class="nav-link"><i class="fa fa-home"></i> {{ __("l.Dashboard") }}</Inertia-Link>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <Inertia-Link :href="route('settings.index')" class="nav-link"><i class="fa fa-cog"></i> {{ __("l.Settings") }}</Inertia-Link>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fa fa-plus-circle"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <Inertia-link :href="route('users.add')" class="dropdown-item">{{__("l.Add User")}}</Inertia-link>
                    <Inertia-link :href="route('clients.add')" class="dropdown-item">{{__("l.Add Client")}}</Inertia-link>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img v-if="$page.auth.user.image" :src="asset('/storage/app/'+$page.auth.user.image)" alt="" class="user-image img-circle elevation-2">
                    <img v-else :src="asset('public/no-image.png')" alt="" class="user-image img-circle elevation-2">
                    <span class="d-none d-md-inline">{{$page.auth.user.name}}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img v-if="$page.auth.user.image" :src="asset('/storage/app/'+$page.auth.user.image)" alt="" class="img-circle elevation-2">
                        <img v-else :src="asset('public/no-image.png')" alt="" class="img-circle elevation-2">
                        <p>
                            {{$page.auth.user.name}}
                        </p>
                    </li>
                    <li class="user-footer">
                        <Inertia-link :href="route('users.view', $page.auth.user.id)" class="btn btn-default btn-flat">{{ __("l.Profile") }}</Inertia-link>
                        <inertia-link :href="route('logout')" class="btn btn-default btn-flat float-right">{{ __("l.Logout") }}</inertia-link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    methods: {
        logout() {
            this.$inertia.post(this.route("logout"), {})
        }
    }
}
</script>
