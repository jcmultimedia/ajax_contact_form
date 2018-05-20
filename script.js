/**
 * Created by Jason on 2018/05/20.
 */

$("#form" ).validate({
    rules: {
        clientName: "required",
        clientPhone: "required",
        clientEmail: {
            required: true,
            email: true
        },
        clientSubject: "required",
    },
    messages: {
        clientName: "Please enter your full name",
        clientPhone: "Please enter your contact number",
        clientEmail: "Please enter your email address",
        clientSubject: "Please enter your business name",

    },
    errorElement: "em",
    errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block" );

        // Add `has-feedback` class to the parent div.form-group
        // in order to add icons to inputs
        element.parents( ".form-group" ).addClass( "has-feedback" );

        if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
        } else {
            error.insertAfter( element );
        }

        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !element.next( "span" )[ 0 ] ) {
            $( "<span class='fa fa-close form-control-feedback'></span>" ).insertAfter( element );
        }
    },
    success: function ( label, element ) {
        // Add the span element, if doesn't exists, and apply the icon classes to it.
        if ( !$( element ).next( "span" )[ 0 ] ) {
            $( "<span class='fa fa-check form-control-feedback'></span>" ).insertAfter( $( element ) );
        }
    },
    highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
        $( element ).next( "span" ).addClass( "fa-close" ).removeClass( "fa-check" );
    },
    unhighlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );
        $( element ).next( "span" ).addClass( "fa-check" ).removeClass( "fa-close" );
    }
});


$("#design-form").on("submit", function(e){
    e.preventDefault();

if($("#design-form").valid(){
$.ajax({
    type: 'POST',
    url: 'form-handler.php',
    dataType: 'json',
    data: $('#design-form').serialize(),
    beforeSend: function(){

        $('#loading').show();

    },
    success: function(data){
        console.log(data.text);
        $("#messageBox").empty().append(data.text).show();
    },
    error: function(){

        $('#loading').hide();
        $("#message-box-container #message-box p").html("An error occurred when trying to send the form.");
        $('#message-box-container').show();

    },
    complete: function(){

        $('#loading').hide();
    }
})
}
}