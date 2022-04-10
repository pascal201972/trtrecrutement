$(function () {

    $('#idbox-slide').slideUp();
    $('#idplier').addClass("hide");
    $("#iddeplier").on('click', function () {
        $('#idbox-slide').slideDown();
        $('#idplier').removeClass("hide");
        $('#iddeplier').addClass("hide");
    })
    $("#idplier").on('click', function () {
        $('#idbox-slide').slideUp();
        $('#iddeplier').removeClass("hide");
        $('#idplier').addClass("hide");
    })
})