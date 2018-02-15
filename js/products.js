$(document).ready(function () {
    $('#newProduct').submit(function (event) {
        if ($('#name').val() != "" && $('#price').val() != "") {
            return true;
        } else {
            event.preventDefault();
            if($('#name').val() == "" && $('#price').val() == ""){
                $('#name').addClass('bg-danger text-white');
                $('#price').addClass('bg-danger text-white');
            } else if ($('#name').val() == "") {
                $('#name').addClass('bg-danger text-white');
            }else{
                $('#price').addClass('bg-danger text-white');
            }
        }
    });
    $('#name').focusin(function () {
        $('#name').removeClass('bg-danger text-white')
    });
    $('#price').focusin(function () {
        $('#price').removeClass('bg-danger text-white')
    });
});