$(".deleteUser").click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    var that = $(this);
    var idUser = $(this).data('id');
    var nameUser = $(this).data('name');
    var url = "/ajax/deleteUser";
    var postedData = {"id": idUser};
    $.confirm({
        title: 'Odstranění uživatele',
        content: 'Chcete odstranit uživatele: '+nameUser+' ?',
        type: 'red',
        typeAnimated: true,
        closeIcon: true,
        closeIconClass: 'fa fa-close',
        buttons: {
            formSubmit: {
                text: '<i class="fa fa-trash-o" aria-hidden="true"></i> Ano',
                btnClass: 'btn-danger',
                action: function () {
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: postedData,
                        dataType: 'json',
                        success: function (data) {
                            $.alert('Uživatel byl úspěšně odstraněn.');
                            that.parent().parent().parent().hide();
                        }
                    });
                }
            },
            NE: {
                text: 'Ne',
                btnClass: 'btn-success',
                action: function () {
                }
            }
        }
    });
});