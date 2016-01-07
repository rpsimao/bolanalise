/**
 * Created by rpsimao on 24/03/15.
 */



function changeRow(id){

    var table  = $('#table-new-customer-emails').html();
    var emails = $('#email-'+id);
    var button = $('#button-emails-'+id);

    button.html('<a class="btn btn-mini btn-success" href="#" onclick="updateRow('+id+')"><i class="icon-ok"></i> OK</a>&nbsp;<a id="cancel-update" class="btn btn-mini btn-danger" href="#"><i class="icon-remove"></i> Cancel</a>');

    var emailsOld = $.ajax({
        type: 'GET',
        url: '/emails/ajaxfind',
        data: {'id': id},
        dataType: 'html',
        async: false
    }).responseText;


    emails.html('<textarea id="new-emails-'+id+'">'+emailsOld+'</textarea>');




    $("#cancel-update").click(function(){
        $("#table-new-customer-emails").html(table);
    });



}

function updateRow(id)
{

    var emails = $('#new-emails-'+id);
    var button = $('#button-emails-'+id);

    var emailsArray = emails.val();
    var res = emailsArray.split(";");

    res.forEach(function(entry){

        if(!validateEmail(entry)){

            $("#error-flash-email").fadeIn().html('<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;&nbsp;O email <b><u>"'+ entry +'"</u></b> não está correcto!</div>');
        }

    });


    $.ajax({
        type: 'GET',
        url: '/emails/ajaxupdate',
        data: {'id': id, 'emails': emails.val()},
        dataType: 'json',
        async: false
    });

    var alert   = $('#flash-email');
    alert.html('<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;&nbsp;Emails alterados com sucesso.</div>');

    var emails = $('#email-'+id);


    var emailsNew = $.ajax({
        type: 'GET',
        url: '/emails/ajaxfind',
        data: {'id': id},
        dataType: 'html',
        async: false
    }).responseText;


    emails.html(emailsNew.replace(";","<br />"));
    button.html('<a class="btn btn-mini btn-info" href="#" onclick="changeRow('+id+')"><i class="icon-pencil"></i> Alterar</a>');
    $("#error-flash-email").fadeOut(25500);

}



function createNewRowEmail() {

    var clientes = $.ajax({
        type: 'GET',
        url: '/emails/ajaxgetallclients',
        dataType: 'html',
        async: false
    }).responseText;


    var html = '<tr>';
    html += '<td>';
    html += clientes;
    html += '</td>';
    html += '<td>';
    html += '<textarea rows="5" cols="30" id="b-new-emails">';
    html += '</textarea><br /><small>Separar os emails por ; (ponto e vírgula)</small>';
    html += '</td>';
    html += '<td>';
    html += '<a class="btn btn-mini btn-success" href="#" onclick="addClienteForEmails()"><i class="icon-plus-sign"></i>&nbsp;&nbsp;Adicionar</a>';
    html += '</td>';
    html += '</tr>';


    $('#table-new-customer-emails tr:first').after(html);


}


function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function addClienteForEmails(){

    var cliente = $('#for-emails-all-clientes');
    var emails  = $('#b-new-emails');
    var alert   = $('#flash-email');


    if (cliente.val() == "" || emails.val() == "")
    {

        alert.html('<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;&nbsp;Os campos de Cliente e Email, têm de estar preenchidos.</div>');

    } else {

            var emailsArray = emails.val();
            var res = emailsArray.split(";");

                res.forEach(function(entry){

                    if(!validateEmail(entry)){

                        $("#error-flash-email").fadeIn().html('<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;&nbsp;O email <b><u>"'+ entry +'"</u></b> não está correcto!</div>');
                    }

                });

            $.ajax({
                type: 'GET',
                url: '/emails/ajaxinsertnew',
                data: {'cliente': cliente.val(), 'emails': emails.val()},
                dataType: 'json',
                async: false
            });


            var table = $.ajax({
                type: 'GET',
                url: '/emails/ajaxrefreshpage',
                dataType: 'html',
                async: false
            }).responseText;

            $("#email-clients-table-refresh").html(table);
            alert.html('<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;&nbsp;Dados inseridos com sucesso.</div>');


    }
}


function deleteEmailCliente(id, uid){

    var alert   = $('#flash-email');

    $.ajax({
        type: 'GET',
        url: '/emails/ajaxdeleterecord',
        data: {'id': id},
        datatype: 'html',
        async: false,

        success: function(response) {

            $("#"+uid).hide();
            alert.html('<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;&nbsp;Dados removidos com sucesso.</div>');

        }

    });

}