<template>
    <index :title="__('l.Reset Password')">
        <div class="login-page" :style="'background-image: url('+login_page_image+');background-size: cover;'">
            <div class="login-box">
                <div class="login-logo">
                    <a :href="route('index')"><b>{{$page.flash.app_name}}</b></a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">{{ __("l.Reset Password") }}</p>
                        <div v-if="$page.flash.status" class="alert alert-success" role="alert">{{$page.flash.status}}</div>
                        <form v-on:submit.prevent="password_email" :action="route('login')" method="post">
                            <div class="input-group mb-3">
                                <input v-model="email" type="email" class="form-control" :placeholder="__('l.Email')">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <span v-if="$page.errors.email" class="invalid-feedback mb-3" role="alert"><strong>{{$page.errors.email}}</strong></span>
                            <div class="row">
                                <div class="col-6"></div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block">{{__("l.Reset Password")}}</button>
                                </div>
                            </div>
                        </form>
                        <p class="mb-1 mt-3">
                            <Inertia-link :href="route('login')">{{ __("l.Go to Login page") }}</Inertia-link>
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
            login_page_image : this.$page.flash.login_page_image
        }
    }, methods:{
        password_email(){
            this.$inertia.post(this.route("password.email"), {
                email: this.email,
                password: this.password,
            });
        }
    }
}
</script>
