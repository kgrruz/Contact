  $(document).on('ready', function() {


                $("input[name='phone']").inputmask({
                      mask: ["(99) 9999-9999", "(99) 99999-9999"],
                      keepStatic: true,
                      placeholder: ""
                });

                $("input[name='cpf']").inputmask('999.999.999-99');
                $("input[name='num_adress']").inputmask('*****', {"placeholder": ""});



if($('#geocomplete_contact').length){

  if(edit_mode){

      var coordinates = $('#lat').val() + ', ' + $('#lng').val();

       var map = $("#geocomplete_contact").geocomplete({
         map: ".map_canvas",
         details: "#details",
         location: coordinates,
         types: ["geocode", "establishment"]

       });

}else{


  var map = $("#geocomplete_contact").geocomplete({
    map: ".map_canvas",
    details: "#details",
    location: $("#geocomplete_contact").val(),
    types: ["geocode", "establishment"],
    detailsAttribute: "data-geo"

  });

}

}






    });
