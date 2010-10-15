var Account = new (function(){

    /* PUBLIC METHODS
     **************************************************************************/
    $(document).ready(function(){
        var o = $.extend({}, jQueryValidatorOptDef, {
            rules : {
                txtCompany : 'required',
                txtName : 'required',
                txtAddress : 'required',
                txtCity : 'required',
                txtPC : 'required',
                cboCountry : 'required',
                cboState : 'required',
                txtEmail : 'required',
                txtPhoneNum : 'required',
                txtMessage : 'required'
            },
            submitHandler : function(form){
                //form.submit();
            },
            invalidHandler : function(){
            }
        });
        $('#form1').validate(o);

    });
    /* PUBLIC METHODS
     **************************************************************************/
     this.show_states = function(me){
         me.disabled=true;
         $.post(get_url('contacto/ajax_show_states'), 'country_id='+me.value, function(data){
             me.disabled=false;
             $('#cboState').parent().show()
             $('#cboState').html(data);
         });
     };


    /* PRIVATE PROPERTIES
     **************************************************************************/

    /* PRIVATE METHODS
     **************************************************************************/

})();
