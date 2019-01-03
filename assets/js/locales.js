$(document).ready(function(){

  $.i18n({
          locale: lang_user
      });


    $.i18n().load({

      portuguese_br: {
        'contact-placeholder': 'Selecione um contato...',
      },
      english: {
        'contact-placeholder': 'Select a contact...',
      },
      es: {
        'contact-placeholder': 'Seleccione un contacto...',
      }

    });

});
