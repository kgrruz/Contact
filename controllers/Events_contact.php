<?php defined('BASEPATH') || exit('No direct script access allowed');


class Events_contact{

  private $CI;
  private $permissionView = 'Contact.Content.View';

 function __construct(){

    $this->CI =& get_instance();
    $this->CI->load->model('contact/contact_model');
    $this->CI->load->model('contact/group_model');
    $this->CI->lang->load('contact/contact');
    $this->CI->lang->load('contact/group');
    $this->CI->load->helper('contact/contact');


 }


 public function _geral_search(&$data){

          if (has_permission($this->permissionView)) {

            $results = $this->CI->contact_model->search_general($data['term'],array('id_contact','email','slug_contact','display_name','phone','contact_type'),12,$data['offset']);

            $html = array();

          foreach($results as $result){

            $type = ($result->contact_type == 1)? '<i class="fa fa-user" aria-hidden="true"></i> ':'<i class="fa fa-building" aria-hidden="true"></i> ';
            $key  = (isset($result->is_user))? '<i class="fa fa-key"></i> ':' ';

            array_push($html,array('<div class="media border-bottom p-3">
     <img class="mr-3" style="width:64px" src="'.contact_avatar($result->email, 64, null,false,null).'" alt="contact_photo">
     <div class="media-body row d-flex h-100">
        <div class="col-sm-9">
     <h5 class="my-0">'.$type.$key.anchor('contato/'.$result->slug_contact,$result->display_name).'</h5>
     </div><div class="col-sm-3 my-auto" >'.anchor('contact/edit/'.$result->slug_contact,'<i class="fa fa-edit"></i>','class=""').'</div>
   </div></div>'));

          }

          $this->CI->db->like('display_name',$data['term']);
          $this->CI->db->where('deleted',0);
          $total = $this->CI->contact_model->count_all();

          array_push($data['data'],array('module_real'=>'contact','module'=>lang('contact_module_name'),'result'=>$html,'total'=>$total));

        }
      }

      public function _tour_link(&$data){

           if (has_permission($this->permissionView)) {

        array_push($data['tours'],array('text'=>lang('contact_tour_register'),'link'=>'contact/create/2#at_tour'));

       }
      }

      public function _config_link(&$data){

        if ($this->CI->db->table_exists('groups')){

           if (has_permission($this->permissionView) and !$this->CI->group_model->count_by('deleted',0)) {

        array_push($data['configs'],array('text'=>lang('group_config_new_group'),'link'=>'contact/group/create'));

        }
        }
      }

      public function _kanban(&$data){



      }

      public function _card_related_contact(&$data){

          if($idc = $this->CI->user_model->find_contact_user($data['user'])){

          $data['contact'] = $this->CI->contact_model->find($idc);

       $data['html'] =  $this->CI->load->view("contact/card_related_contact",$data,true);

     }

      }

      function company_contacts(&$data){

      if($data['function'] == __FUNCTION__){

            $offset = $this->CI->uri->segment(4);

            $where = array('company'=>$data['id_contact']);

            $this->CI->contact_model->select("
              MAX(CASE WHEN meta_key = 'is_user' THEN meta_value END) AS 'is_user',
              MAX(CASE WHEN meta_key = 'company' THEN meta_value END) AS 'company',
              MAX(CASE WHEN meta_key = 'job_role' THEN meta_value END) AS 'cargo',
              MAX(CASE WHEN meta_key = 'resp_equip' THEN meta_value END) AS 'resp_equip',
              id_contact,display_name,contact_type,slug_contact,phone,email,contacts.created_on as created_on");
            $this->CI->contact_model->join('contact_meta','contact_meta.contact_id = contacts.id_contact','left');
            $this->CI->contact_model->group_by('contacts.id_contact');
            $this->CI->contact_model->having($where);
            $this->CI->contact_model->limit(12, $offset);
            $contacts = $this->CI->contact_model->find_all();

            $this->CI->load->library('pagination');

            $this->CI->pager['base_url']    = base_url()."contato/".$data['slug']."/company_contacts/";
            $this->CI->pager['per_page']    = 12;
            $this->CI->contact_model->select("MAX(CASE WHEN meta_key = 'company' THEN meta_value END) AS 'company'");
            $this->CI->contact_model->join('contact_meta','contact_meta.contact_id = contacts.id_contact','left');
            $this->CI->contact_model->group_by('contacts.id_contact');
            $this->CI->pager['total_rows']  = $this->CI->contact_model->having($where)->count_all();
            $this->CI->pager['uri_segment'] = 4;

            $this->CI->pagination->initialize($this->CI->pager);

            $data['data_table'] = $contacts;
            $data['contact_type'] = array(2);

            $data['view_page'] = 'contact/company/index';


          }
      }


      public function _ajax_search(&$records){

       $this->CI->db->select("
       MAX(IF({$this->CI->db->dbprefix}contact_meta.meta_key='lat',{$this->CI->db->dbprefix}contact_meta.meta_value,0)) AS lat,
       MAX(IF({$this->CI->db->dbprefix}contact_meta.meta_key='lng',{$this->CI->db->dbprefix}contact_meta.meta_value,0)) AS lng,
       MAX(IF({$this->CI->db->dbprefix}contact_meta.meta_key='adress',{$this->CI->db->dbprefix}contact_meta.meta_value,0)) AS adress,
       MAX(IF({$this->CI->db->dbprefix}contact_meta.meta_key='city',{$this->CI->db->dbprefix}contact_meta.meta_value,0)) AS city,
       MAX(IF({$this->CI->db->dbprefix}contact_meta.meta_key='neibor',{$this->CI->db->dbprefix}contact_meta.meta_value,0)) AS neibor,
       MAX(IF({$this->CI->db->dbprefix}contact_meta.meta_key='num_adress',{$this->CI->db->dbprefix}contact_meta.meta_value,0)) AS num_adress,
       id_contact,email,display_name,phone");
       $this->CI->db->from('contacts');
       $this->CI->db->join('contact_meta','contact_meta.contact_id = contacts.id_contact','left');
       $this->CI->db->like('display_name',$this->CI->input->get('query'));
       $this->CI->db->group_by("id_contact");
       $this->CI->db->limit(5);
       $contacts = $this->CI->db->get();


       $result = array();

       foreach($contacts->result() as $contact){

         $coord = (isset($contact->lat) and !empty($contact->lat))? $contact->lat.', '.$contact->lng:0;
         $address = (isset($contact->adress) and !empty($contact->adress))? $contact->adress: 'Endereço incompleto.';
         $city = (isset($contact->city) and !empty($contact->city))? $contact->city: 'Endereço incompleto.';
         $neibor = (isset($contact->neibor) and !empty($contact->neibor))? $contact->neibor: 'Endereço incompleto.';
         $num_address = (isset($contact->num_adress) and !empty($contact->num_adress))? $contact->num_adress: 'Endereço incompleto.';


       array_push($result,array(
       'url'=>'',
       'id' => $contact->id_contact,
       'idc'=> $contact->id_contact,
       'name'=> $contact->display_name,
       'email'=> $contact->email,
       'phone'=> $contact->phone,
       'address'=> $address,
       'city'=> $city,
       'neibor'=> $neibor,
       'num_address'=> $num_address,
       'lat'=> $num_address,
       'num_address'=> $num_address,
       'coord'=> $coord,
       'lat'=>$contact->lat,
       'lng'=>$contact->lng
       ));


       }

       array_push($records,$result);

      }

      public function _form_widget(&$html){

        Assets::add_module_js('contact', 'contact.js');

        if(isset($html['contact_type'])){

          $this->CI->contact_model->where('contact_type',$html['contact_type']);

        }

        $this->CI->contact_model->where('deleted',0);

        if(isset($html['contact_id'])){ $data['contact_id'] = $html['contact_id']; };

        $data['contacts'] = $this->CI->contact_model->find_all();

        $data['label'] = $html['label'];

        $html['html'] =  $this->CI->load->view('contact/form_widget',$data,true);

      }

      function _show_widget_button(){

      if (has_permission($this->permissionView)) {
            return anchor('contact/create/2','<i class="fa fa-plus"></i><i class="fa fa-user"></i>','class="btn btn-success"');

          }
      }

      public function get_user_notif(&$payload){

          $this->CI->lang->load('contact/contact');

          $notifications = $this->CI->notification_model->get_user_notifications('contact');

          foreach($notifications->result() as $not){

            array_push($payload['data'],
            array(
            'photo_avatar'=>$not->photo_avatar,
            'activity'=>$not->activity,
            'display_name'=>$not->display_name,
            'email'=>$not->email,
            'created_on'=>$not->created_on,
            'username'=>$not->username
          ));

          }

        }

        function _get_markersbound(&$data_json){

          array_push($data_json['markers'],$this->CI->contact_model->get_markersbound($data_json['north'],$data_json['south'],$data_json['east'],$data_json['west']));

        }

        function _get_marker_list(&$data_json){

          array_push($data_json['markers'],$this->CI->contact_model->search_locs($data_json['search']));

        }
  }
