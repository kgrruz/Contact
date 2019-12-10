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
      '<img class="mr-3" src="'+base_url+'uploads/users/thumbs/no_foto_avatar.png" style="width:20px;" alt="icon">'+
      '<div class="media-body">'+
        '<h6 class="mt-0">'+option.text+'</h6>'+
    '</div>');
        return $option;

      };


                    $('#contact_id').select2({
                    ajax: {
                       url: base_url+'admin/content/contact/ajax_search/'+$('#contact_id').data('type'),
                       dataType: 'json',
                       delay: 500
                       // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                     },
                      templateResult: format,
                      templateSelection: format,
                      theme: 'bootstrap',
                      placeholder: $.i18n('contact-placeholder'),
                      allowClear: true,
                      tags: true,
                      createTag: function (tag) {
                        if($("#form_proposta").length){
                         return {
                             id: tag.term,
                             text: 'Irá criar: '+tag.term,
                             // add indicator:
                             isNew : true
                         };
                      }
                    }

                    }).on("select2:select", function(e) {

                      if(e.params.data.isNew){
                        $('#block_create_contact').css('display','block');
                      }else{
                          $('#block_create_contact').css('display','none');
                      }

                    });
                  }

                  if($("#company").length){

                    $('#company').select2();

                  }



                  if($("#user_access").length){

                    function format_user (option) {

            if (!option.id) { return option.text; }

            var $option = $('<div class="media">'+
          '<img class="mr-3" src="'+option.element.dataset.img+'" style="width:50px;" alt="icon">'+
          '<div class="media-body">'+
            '<h6 class="mt-0">'+option.element.dataset.contact+'</h6>'+
        '</div>');
            return $option;

          };

                    $('#user_access').select2({
                      templateResult: format_user,
                      templateSelection: format_user,
                      theme: 'bootstrap',
                      placeholder: $.i18n('contact-placeholder'),
                      allowClear: true
                    });

                  }

              });
