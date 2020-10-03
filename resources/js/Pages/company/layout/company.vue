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
            <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{__("l.Preview File")}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body position-relative">
                            ...
                        </div>
                    </div>
                </div>
            </div>
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
    },mounted() {
        $(document).on("click", ".btn-file", function (e) {
            e.preventDefault();
            var url = $(this).attr("href");
            $("#fileModal .modal-body").html("<iframe id='iframe' src='"+url+"' style='width: 100%; height: 600px;' frameborder='0'> </iframe>");
            $("#fileModal").modal("show");
        });
        $('#fileModal').on('show.bs.modal', function (e) {
            setTimeout(function () {
                var iFrameDOM = $("iframe#iframe").contents();
                iFrameDOM.find("img").css("width", "100%");
            }, 500);
        });
    }
}
</script>

<style>

.btn, .nav-pills .nav-link, .card, .card-header, .form-control, .input-group-text, .badge {
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
