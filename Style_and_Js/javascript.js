$(document).ready(function() {
    $('.money').mask('000,00', {
        reverse: true
    });
    $('#validade').mask('00/00/0000');
});
$(document).ready(function() {
    $("#desabilitar_limite").on("click", function() {
        if ($(this).prop("checked")) {
            $(".limite_d").prop("disabled", true);
        } else {
            $(".limite_d").prop("disabled", false);
        }
    });
});
$(document).ready(function() {
    $("#desabilitar_validade").on("click", function() {
        if ($(this).prop("checked")) {
            $(".validade_d").prop("disabled", true);
        } else {
            $(".validade_d").prop("disabled", false);
        }
    });
});
$('#botao').click(function() {
    $.notify(
        "I'm to the right of this box",
        { position:"top center" }
      );
});




