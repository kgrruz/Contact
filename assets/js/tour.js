$(document).ready(function(){

  var tour = new Tour({
    name: "tour_contacts",
    steps: [
    {
      orphan:true,
      backdrop: true,
      placement: 'top',
      title: "Contatos",
      content: "<strong>"+my_username+"</strong> seja bem vindo(a) ao módulo contatos. Este Tour irá te ajudar a..."
    },
    {
      element: '#table_contacts',
      placement: 'top',
      title: "Title of my step",
      content: "Content of my step"
    },
    {
      element: '#add_contact_nav',
      placement: 'top',
      title: "Title of my step",
      content: "Content of my step"
    },
    {
      element: '#add_contact_person',
      placement: 'top',
      title: "Title of my step",
      content: "Content of my step"
    }
    ],
    template: '<div class="popover p-0" style="width:300px" role="tooltip"> <div class="arrow"></div> <h3 class="popover-title bg-primary text-white"></h3> <div class="popover-content"></div> <div class="popover-navigation"> <div class="btn-group"> <button class="btn btn-sm btn-default" data-role="prev">&laquo; Prev</button> <button class="btn btn-sm btn-default" data-role="next">Next &raquo;</button> <button class="btn btn-sm btn-default" data-role="pause-resume" data-pause-text="Pause" data-resume-text="Resume">Pause</button> </div> <button class="btn btn-sm btn-default" data-role="end">End tour</button> </div> </div>'
  });

  tour.init();
  tour.start();

});
