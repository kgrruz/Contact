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


         var map = $("#geocomplete_contact").geocomplete({
           map: ".map_canvas",
           details: "#details",
           types: ["geocode", "establishment"],
           mapOptions: {
           scrollwheel: true
         }

         });

         map.geocomplete("find",{lat: parseFloat($('#lat').val()), lng: parseFloat($('#lng').val()) });



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
