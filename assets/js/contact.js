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

                $('.tk_job_role').tokenize2({
                    tokensAllowCustom: true,
                    tokensMaxItems: 1,
                    placeholder: jr_placeholder
                  });



                    });
