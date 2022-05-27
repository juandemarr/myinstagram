$(function(){
    $("#newPost button").on("click",function(e){
        
        if($("#post_foto").val().length == 0){
            e.preventDefault();
            $("#post").append("<p>Debes seleccionar una imagen</p>");
        }
    });

    $(".toast").on("click",function(){window.location='/report'});
});

function mostrarNotificacion(){
    
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "3500",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr["warning"]("Hay nuevas denuncias");
}
