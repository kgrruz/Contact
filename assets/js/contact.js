  $(document).on('ready', function() {

                $("input[name='phone']").inputmask({
                      mask: ["(99) 9999-9999", "(99) 99999-9999"],
                      keepStatic: true,
                      placeholder: ""
                });

                $("input[name='cpf']").inputmask('999.999.999-99');
                //$("input[name='num_adress']").inputmask('********', {"placeholder": ""});

                $('.postcode').inputmask('99999-999');
                $('.cnpj').inputmask('99.999.999/9999-99');

                var jr_placeholder = $('.tk_job_role').data('placeholder');

                function format (option) {

        if (!option.id) { return option.text; }

        var $option = $('<div class="media">'+
      '<img class="mr-3" src="'+option.element.dataset.img+'" alt="icon">'+
      '<div class="media-body">'+
        '<h6 class="mt-0">'+option.element.dataset.contact+'</h6>'+
    '</div>');
        return $option;

      };

                    $('#contact_id').select2({
                      templateResult: format,
                      templateSelection: format,
                      theme: 'bootstrap'
                    });


              });
