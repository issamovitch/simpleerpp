<template>
    <index :title="__('l.Login')">
        <div class="login-page" :style="'background-image: url('+login_page_image+');background-size: cover;'">
            <div class="login-box">
                <div class="login-logo">
                    <a :href="route('index')"><b>{{$page.flash.app_name}}</b></a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">{{ __("l.Sign in to start your session") }}</p>
                        <form v-on:submit.prevent="login" :action="route('login')" method="post">
                            <div class="input-group mb-3">
                                <input v-model="email" type="email" class="form-control" :placeholder="__('l.Email')">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <span v-if="$page.errors.email" class="invalid-feedback mb-3" role="alert"><strong>{{$page.errors.email}}</strong></span>
                            <div class="input-group mb-3">
                                <input v-model="password" type="password" class="form-control" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <span v-if="$page.errors.password" class="invalid-feedback mb-3" role="alert"><strong>{{$page.errors.password}}</strong></span>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" v-model="remember" id="remember">
                                        <label for="remember">{{__("l.Remember Me")}}</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{__("l.Login")}}</button>
                                </div>
                            </div>
                        </form>
                        <p class="mb-1 mt-3">
                            <Inertia-link :href="route('password.request')">{{ __("l.I forgot my password") }}</Inertia-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </index>
</template>

<script>

import index from "../index"

export default {
    components:{
        index
    },
    data(){
        return {
            email : "",
            password : "",
            remember: false,
            login_page_image : this.$page.flash.login_page_image
        }
    }, methods:{
        login(){
            this.$inertia.post(this.route("login"), {
                email: this.email,
                password: this.password,
                remember: this.remember
            });
        }
    }
}
</script>
