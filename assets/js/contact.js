  $(document).on('ready', function() {

if($(".phone").length){

    $(".phone").inputmask({
          mask: $('#country').find(':selected').data("phone_pattern").split(','),
          keepStatic: true,
          placeholder: ""
    });

      $('.postcode').inputmask({
        mask:$('#country').find(':selected').data("zip_pattern").split(','),
        keepStatic: true
      });

      $('.cnpj').inputmask($('#country').find(':selected').data("comp_id_pattern"));
      $("input[name='cpf']").inputmask($('#country').find(':selected').data("person_id_pattern"));

                $('#country').change(function(){

                  $(".phone").inputmask({
                        mask: $(this).find(':selected').data("phone_pattern").split(','),
                        keepStatic: true,
                        placeholder: ""
                  });

                    $('.postcode').inputmask({
                      mask:$(this).find(':selected').data("zip_pattern").split(','),
                      keepStatic: true
                    });

                    $('.cnpj').inputmask($(this).find(':selected').data("comp_id_pattern"));
                    $("input[name='cpf']").inputmask($(this).find(':selected').data("person_id_pattern"));

                });

                var jr_placeholder = $('.tk_job_role').data('placeholder');

                $("#job_role").select2({
                  tags: true,
                  tokenSeparators: [','],
                  theme: 'bootstrap'

              })
                $("#city").select2({
                  tags: true,
                  tokenSeparators: [','],
                  theme: 'bootstrap'

              })

              }


      if($("#contact_id").length){

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
                      theme: 'bootstrap',
                      placeholder: $.i18n('contact-placeholder'),
                      allowClear: true
                    });



                  }
                  
                  if($("#company").length){  $('#company').select2();  }

              });
