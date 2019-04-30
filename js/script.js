$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip()
    
    $('div.hidden').fadeIn(900).removeClass('hidden');

    $('.custom-file-input').on('change',function(){
        var fileName = $(this).val().split('\\').pop();
        if (fileName != "") {
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        } else {
            $(this).next('.custom-file-label').html('Nie je vybratý súbor');
        }
    });

    $("#uploadfile").submit(function(e){
        console.log($("#fileToUpload").val().split('\\').pop());
        var extension = $('.custom-file-input').val().split('\\.').pop().split('.').pop();
        if (extension == "") {
            $("#error_form").text("Nevložili ste súbor!");
            $("#error_form").fadeIn();
            return false;
        } else if (extension != "xlsx") {
            $("#error_form").text("Vložili ste zlý súbor!");
            $("#error_form").fadeIn();
            return false;
        } else {
            $("#error_form").hide();
        }
    });
});