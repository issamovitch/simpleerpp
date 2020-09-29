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

.btn, .nav-pills .nav-link, .card, .card-header {
    border-radius: 0px !important;
}

.dg-title{
    font-size: 24px !important;
}

.w-150{
    width: 150px !important;
}

.swal2-icon.swal2-warning::before{
    display: none;
}

</style>
