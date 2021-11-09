$(document).ready(function(){
    let myModal = new bootstrap.Modal(document.getElementById('createInvoice'), {
        keyboard: false
    })
    //Ukoliko postoji neka greska prilikom dodavanja nove fakture, automatski se otvara modal prilikom ucitavanja stranice
    if( $('#error').val().trim() == 1 ){
        myModal.show();
    }
});

