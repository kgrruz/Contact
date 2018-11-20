$(document).ready(function(){

  $.i18n({
          locale: lang_user
      });


    $.i18n().load({
      portuguese_br: {
        'next': 'Próximo',
        'previous': 'Anterior',
        'end' : 'Fim',
        'contact-step1-title' : 'Cadastrando seus clientes',
        'contact-step1-content' : "<strong>$1</strong> seja bem vindo(a) ao módulo contatos. Este Tour irá te ajudar a cadastrar seus contatos, seja ele um cliente ou apenas um novo contato. Vamos lá?",
        'contact-step2-title' : 'Pessoa física(Pessoa) ou Jurídica(Empresa)?',
        'contact-step2-content' : "Os contatos estão divididos em pessoas ou/e empresas. Uma pessoa pode ser uma empresa, mesmo assim a mesma deve ser cadastrada como empresa.",
        'contact-step3-title' : 'Um exemplo de Empresa',
        'contact-step3-content' : "Para ilustrar, vamos cadastrar a empresa ABC Internacional. A seguir os seus dados:",
        'contact-step4-title' : 'Nome da Empresa',
        'contact-step4-content' : "Preencha com: ABC INTERNACIONAL",
        'contact-step5-title' : 'Razão social',
        'contact-step5-content' : "Preencha com:  ABC indústrias",
        'contact-step6-title' : 'CNPJ',
        'contact-step6-content' : "Preencha com:  99333333933",
        'contact-step7-title' : 'Cidade',
        'contact-step7-content' : "Preencha com:  Belo horizonte",
        'contact-step8-title' : 'Registro completo',
        'contact-step8-content' : "Pronto. Registro da empresa completo. Envie o formulário.",
        'contact-step9-title' : 'Perfil do contato',
        'contact-step9-content' : "Contato registrado. Estamos agora no perfil do mesmo..."
      },
      english: {
         'next': 'Next',
         'previous': 'Previous',
         'end': 'End',
         'contact-step1-title': 'Registering your clients',
         'contact-step1-content': "<strong> $1</strong> Welcome to the contacts module This Tour will help you to register your contacts, be it a customer or just a new contact. ",
         'contact-step2-title': 'Individual (Person) or Legal (Company)?',
         'contact-step2-content': "Contacts are divided into persons and / or companies. A person may be a company, even though it must be registered as a company.",
         'contact-step3-title': 'An example Company',
         'contact-step3-content': "To illustrate, we will register the company ABC International. Here's your information: <br/> Name: ABC INTERNACIONAL <br/> Corporate name: ABC Industries <br/> CNPJ: 99333333933- 99 <br/> City: Belo horizonte. "
      },
      es: {
        'welcome': 'hola mundo'
      }

    });

});
