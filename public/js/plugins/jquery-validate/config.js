/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: ES
 */
jQuery.extend(jQuery.validator.messages, {
  required: "Este campo es obligatorio.",
  remote: "Por favor, rellena este campo.",
  email: "Por favor, escribe una dirección de correo válida",
  url: "Por favor, escribe una URL válida.",
  date: "Por favor, escribe una fecha válida.",
  dateISO: "Por favor, escribe una fecha (ISO) válida.",
  number: "Por favor, escribe un número entero válido.",
  digits: "Por favor, escribe sólo dígitos.",
  creditcard: "Por favor, escribe un número de tarjeta válido.",
  equalTo: "Por favor, escribe el mismo valor de nuevo.",
  accept: "Por favor, escribe un valor con una extensión aceptada.",
  maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
  minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
  rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
  range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
  max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
  min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")  
});

jQuery.validator.setDefaults({
    messages : {
        txtName : {
            remote : 'El nombre del producto ya existe.'
        },
        txtPassOld:{
            remote : 'La contrase&ntilde;a es incorrecta.'
        }
    }
});

// VALORES POR DEFECTO
var jQueryValidatorOptDef = {
    highlight : function(element){
        $(element).removeClass('valid-unhighlight').addClass('valid-highlight');
    },
    unhighlight : function(element){
        $(element).removeClass('valid-highlight').addClass('valid-unhighlight');
    },
    submitHandler : function(form){
        form.submit();
    },
    errorClass : 'valid-error',
    onfocusout: false
};

// NUEVOS METODOS
jQuery.validator.addMethod("password", function(value, element, param) {
    if( value.length>0 && param ){
        eval('var RegExPattern = new RegExp(/(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{'+ 8 +','+ 10 +'})$/);');
        return value.match(RegExPattern);
    }
}, "El password debe tener entre 8 y 10 caracteres, por lo menos un dígito y un alfanumérico, y no puede contener caracteres espaciales.");

jQuery.validator.addMethod("tinymce_required", function(value, element, param) {
    return tinyMCE.get(element.id).getContent().length>0;

}, "Este campo es obligatorio.");
