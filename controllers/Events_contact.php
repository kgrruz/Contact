<?php defined('BASEPATH') || exit('No direct script access allowed');


class Events_contact{

  private $CI;
  private $permissionView = 'Contact.Content.View';

 function __construct(){

    $this->CI =& get_instance();
    $this->CI->lang->load('contact/contact');
    $this->CI->load->helper('contact/contact');

 }


 public function _geral_search(&$data){

   $this->CI->load->model('contact/contact_model');

          if (has_permission($this->permissionView)) {

            $results = $this->CI->contact_model->search_general($data['term'],array('id_contact','email','slug_contact','display_name','phone'),12,$data['offset']);

            $html = array();

          foreach($results as $result){

            array_push($html,array('<hr><div class="media">
     <img class="mr-3" style="width:64px" src="'.contact_avatar($result->email, 64, null,false,null).'" alt="contact_photo">
     <div class="media-body">
       <h5 class="mt-0">'.anchor('contato/'.$result->slug_contact,$result->display_name).'</h5>'.
       $result->country.'</br>'.anchor('contact/edit/'.$result->slug_contact,'edit').'
     </div>
   </div>'));

          }

          $this->CI->db->like('display_name',$data['term']);
          $this->CI->db->where('deleted',0);
          $total = $this->CI->contact_model->count_all();

          array_push($data['data'],array('module_real'=>'contact','module'=>lang('contact_module_name'),'result'=>$html,'total'=>$total));

        }
      }

      function company_contacts(&$data){

      if($data['function'] == __FUNCTION__){

            $offset = $this->CI->uri->segment(3);

            $where = array('contact_meta.meta_key'=>'company','contact_meta.meta_value'=>$data['id_company']);

            $this->CI->db->select("*");
            $this->CI->db->from("contact_meta");
            $this->CI->db->join('contacts','contacts.id_contact = contact_meta.contact_id');
            $this->CI->db->group_by('contacts.id_contact');
            $this->CI->db->limit(12, $offset)->where($where);
            $contacts = $this->CI->db->get();

            $this->CI->load->library('pagination');

            $this->CI->pager['base_url']    = base_url()."sells/contact_purchase/";
            $this->CI->pager['per_page']    = 12;
            $this->CI->pager['total_rows']  = $this->CI->db->where($where)->count_all();
            $this->CI->pager['uri_segment'] = 3;

            $this->CI->pagination->initialize($this->CI->pager);

            $data['data_table'] = $contacts;

            $data['view_page'] = 'contact/company/index';

                }
      }


      public function _ajax_search(&$records){

       $this->CI->db->cache_on();

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
       $contacts = $this->CI->db->get();

       $this->CI->db->cache_off();

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
  }
