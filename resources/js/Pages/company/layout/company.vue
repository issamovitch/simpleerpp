<template>
    <index :title="title">
        <div class="wrapper">
            <navbar></navbar>
            <sidebar></sidebar>
            <div class="content-wrapper">
                <messages></messages>
                <breadcrumb :title="title" :current="current" :pn="pn" :pl="pl"></breadcrumb>
                <section class="content">
                    <slot/>
                </section>
            </div>
            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> 1.0
                </div>
                <strong>Copyright &copy; {{ new Date().getFullYear() }} All rights reserved.</strong>
            </footer>
        </div>
    </index>
</template>

<script>

import index from "../../index";
import navbar from "./navbar";
import sidebar from "./sidebar";
import breadcrumb from "./breadcrumb";
import messages from "./messages";

export default {
    props: ["title", "current", "pn", "pl"]
    , components: {
        index,
        navbar,
        sidebar,
        breadcrumb,
        messages,
    },
}
</script>

<style>

.btn, .nav-pills .nav-link, .card, .card-header, .form-control, .input-group-text {
    border-radius: 0px !important;
}

.dg-title{
    font-size: 24px !important;
}

.w-150{
    width: 150px !important;
}

.w-120{
    width: 120px !important;
}

.swal2-icon.swal2-warning::before{
    display: none;
}

.user-image-list {
    width: 60px !important;
    height: 60px !important;
}
.user-image-grid{
    border: 1px solid #d5d5d5;
    width: 100%;
    height: 80px;
}
</style>
