import VueSimpleAlert from "vue-simple-alert";

import Swal from "sweetalert2";
export default {
    async confirmation() {



        return await Swal.fire({
            icon : "warning",
            title: lang_to_vue[lang]["l"]["Confirmation"],
            text: lang_to_vue[lang]["l"]["Are you sure ?"],
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: lang_to_vue[lang]["l"]["Yes"],
            cancelButtonText: lang_to_vue[lang]["l"]["No"],
        }).then((result) => {
            if (result.isConfirmed) {
                return true
            } else {
                return false
            }
        })
    }
}
