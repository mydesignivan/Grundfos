<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Products_panel_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function get_list($categories_id){
        $this->db->select('reference');
        $row = $this->db->get_where(TBL_CATEGORIES, array('categories_id'=>$categories_id))->row_array();

        $this->db->order_by('order', 'asc');
        $query = $this->db->get_where(TBL_PRODUCTS, array('categorie_reference'=>$row['reference']));
        return $query->result_array();
    }

    public function get_info($id) {
        $row = array();
        $row = $this->db->get_where(TBL_PRODUCTS, array('products_id'=>$id))->row_array();
        
        return $row;
    }

    public function create() {
         $json = json_decode($this->input->post('json'));

         $data = array(
            'codlang'              => 1,
            'categorie_reference'  => $this->input->post('categorie_reference'),
            'product_name'         => $this->input->post('txtName'),
            'description'          => $this->input->post('txtDescription'),
            'product_content'      => $this->input->post('txtContent'),
            'reference'            => normalize($this->input->post('txtName')),
            'thumb'                => $json->image_thumb->filename_image,
            'thumb_width'          => $json->image_thumb->thumb_width,
            'thumb_height'         => $json->image_thumb->thumb_height,
            'order'                => $this->_get_num_order(TBL_PRODUCTS, array('categorie_reference'=>$this->input->post('categorie_reference'))),
            'date_added'           => strtotime(date('d-m-Y')),
            'last_modified'        => strtotime(date('d-m-Y'))
         );

         //print_array($data, true);

         $this->db->trans_start(); // INICIO TRANSACCION
         $path = UPLOAD_PATH_PRODUCTS . $this->input->post('categorie_reference')."/";

         if( $this->db->insert(TBL_PRODUCTS, $data) ){
             $id = $this->db->insert_id();

             if( !@copy(urldecode($json->image_thumb->href_image_full),  $path.urldecode($json->image_thumb->filename_image)) ) return false;

         }else return false;
         $this->db->trans_complete(); // COMPLETO LA TRANSACCION

         $this->load->helper('file');
         delete_files($path.".tmp");

         return true;
    }

    public function edit() {
         $json = json_decode($this->input->post('json'));

         $data = array(
            'codlang'              => 1,
            'categorie_reference'  => $this->input->post('categorie_reference'),
            'product_name'         => $this->input->post('txtName'),
            'description'          => $this->input->post('txtDescription'),
            'product_content'      => $this->input->post('txtContent'),
            'reference'            => normalize($this->input->post('txtName')),
            'order'                => $this->_get_num_order(TBL_PRODUCTS, array('categorie_reference'=>$this->input->post('categorie_reference'))),
            'last_modified'        => strtotime(date('d-m-Y'))
         );

         if( isset($json->image_thumb->filename_image) ){
            $data['thumb'] = $json->image_thumb->filename_image;
            $data['thumb_width'] = $json->image_thumb->thumb_width;
            $data['thumb_height'] = $json->image_thumb->thumb_height;
            @unlink(urldecode($this->input->post('image_thumb_old')));
         }

         //print_array($data, true);

         $path = UPLOAD_PATH_PRODUCTS . $this->input->post('categorie_reference')."/";

         //print_array($data, true);

         $this->db->trans_start(); // INICIO TRANSACCION

         $this->db->where('products_id', $this->input->post('products_id'));
         if( $this->db->update(TBL_PRODUCTS, $data) ){

             if( isset($json->image_thumb->filename_image) ){
                 if( !@copy(urldecode($json->image_thumb->href_image_full),  $path.urldecode($json->image_thumb->filename_image)) ) return false;
             }
         }else return false;
         
         $this->db->trans_complete(); // COMPLETO LA TRANSACCION

         $this->load->helper('file');
         delete_files($path.".tmp");

         return true;
    }

    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _get_num_order($tbl_name, $where=array()){
        $this->db->select_max('`order`');
        $this->db->where($where);
        $row = $this->db->get($tbl_name)->row_array();
        return is_null($row['order']) ? 1 : $row['order']+1;
    }

}