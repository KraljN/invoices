$(document).ready(function(){
    let myModal = new bootstrap.Modal(document.getElementById('createInvoice'), {
        keyboard: false
    })
    if( $('#error').val().trim() == 1 ){
        myModal.show();
    }
});

