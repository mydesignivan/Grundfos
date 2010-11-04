<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Categories_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function get_treeview(){
        $output = '<ul>';
        $output.= $this->_get_treeview();
        $output.= "</ul>";

        return $output;
    }

    public function create(){
        $json = json_decode($this->input->post('json'));
        $reference = normalize(trim($this->input->post('txtCategorie')));
        $data = array(
            'codlang'             => 1,
            'parent_id'           => $this->input->post('parent_id'),
            'categorie_name'      => trim($this->input->post('txtCategorie')),
            'reference'           => $reference,
            'categorie_content'   => $this->input->post('txtContent'),
            'level'               => $this->input->post('parent_id')>0 ? $this->_get_level() : 0,
            'order'               => $this->_get_num_order(TBL_CATEGORIES, array('parent_id'=>$this->input->post('parent_id'))),
            'date_added'          => strtotime(date('d-m-Y')),
            'last_modified'       => strtotime(date('d-m-Y'))
        );

        if( $this->input->post('optBannerShow')==1 ){
            $data = array_merge($data, array(
                'banner'              => $this->input->post('optBannerShow'),
                'banner_thumb'        => @$json->image_thumb->filename_image,
                'banner_thumb_width'  => @$json->image_thumb->thumb_width,
                'banner_thumb_height' => @$json->image_thumb->thumb_height
            ));
        }

        /*print_array($json);
        print_array($data, true);*/

        $this->db->trans_start(); // INICIO TRANSACCION
        if( $this->db->insert(TBL_CATEGORIES, $data) ){
            if( isset($json->image_thumb->href_image_full) ){
                if( !@copy(urldecode($json->image_thumb->href_image_full),  UPLOAD_PATH_BANNER.urldecode($json->image_thumb->filename_image)) ) return 'Error Nº2';
            }

        }else return "Error Nº1";
        $id = $this->db->insert_id();
        $this->db->trans_complete(); // COMPLETO LA TRANSACCION

        $this->load->helper('file');
        delete_files(UPLOAD_PATH_BANNER.".tmp");
         
        return "ok";
    }

    public function edit(){
        $json = json_decode($this->input->post('json'));
        $reference = normalize(trim($this->input->post('txtCategorie')));
        $data = array(
            'codlang'           => 1,
            'categorie_name'    => trim($this->input->post('txtCategorie')),
            'reference'         => $reference,
            'banner'            => $this->input->post('optBannerShow'),
            'categorie_content' => $this->input->post('txtContent'),
            'last_modified'     => strtotime(date('d-m-Y'))
        );

        /*print_array($json);
        print_array($data, true);*/

        if( $this->input->post('optBannerShow')==1 ){
            $data = array_merge($data, array(
                'banner_thumb'        => @$json->image_thumb->filename_image,
                'banner_thumb_width'  => @$json->image_thumb->thumb_width,
                'banner_thumb_height' => @$json->image_thumb->thumb_height
            ));
        }else{
            @unlink(urldecode($this->input->post('image_thumb_old')));
            $data = array_merge($data, array(
                'banner_thumb'        => '',
                'banner_thumb_width'  => 0,
                'banner_thumb_height' => 0
            ));
        }


        $this->db->trans_start(); // INICIO TRANSACCION
        $this->db->where('categories_id', $this->input->post('categories_id'));
        if( $this->db->update(TBL_CATEGORIES, $data) ) {
            if( isset($json->image_thumb->href_image_full) ){
                 if( !@copy(urldecode($json->image_thumb->href_image_full),  UPLOAD_PATH_BANNER.urldecode($json->image_thumb->filename_image)) ) return 'Error Nº2';
                 else @unlink(urldecode($this->input->post('image_thumb_old')));
            }

        }else return "Error Nº1";
        $this->db->trans_complete(); // COMPLETO LA TRANSACCION

         $this->load->helper('file');
         delete_files(UPLOAD_PATH_BANNER.".tmp");

        return "ok";
    }

    public function delete($id) {
        $this->load->model('products_panel_model');
        return $this->_delete(array(array('categories_id'=>$id)));
    }

    public function get_info($id) {
        $row = array();
        //echo $id."<br>";
        $row = $this->db->get_where(TBL_CATEGORIES, array('categories_id'=>$id))->row_array();

        $this->db->select('thumb, thumb_width, thumb_height');
        $row['bannergallery'] = $this->db->get_where(TBL_PRODUCTS, array('categorie_reference'=>$row['reference']))->result_array();

        return $row;
    }

    public function get_reference($id){
        $this->db->select('reference');
        $row = $this->db->get_where(TBL_CATEGORIES, array('categories_id' => $id))->row_array();
        return $row['reference'];
    }

    public function order(){
        $initorder = $this->input->post('initorder');
        $rows = json_decode($this->input->post('rows'));

        $res = $this->db->query('SELECT `order` FROM '.TBL_CATEGORIES.' WHERE categories_id='.$initorder)->row_array();
        $order = $res['order'];

        //print_array($rows, true);
        foreach( $rows as $row ){
            $id = substr($row, 2);
            $this->db->where('categories_id', $id);
            if( !$this->db->update(TBL_CATEGORIES, array('order' => $order)) ) return false;
            $order++;
        }

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

    private function _get_level(){
        $this->db->select('level');
        $row = $this->db->get_where(TBL_CATEGORIES, array('categories_id'=>$this->input->post('parent_id')))->row_array();
        return $row['level']+1;
    }

    private function _get_treeview($parent_id=0){

        $this->db->order_by('`order`', 'asc');
        $query = $this->db->get_where(TBL_CATEGORIES, array('parent_id'=> $parent_id));

        $output='';

        foreach( $query->result_array() as $row ){

            $output.= '<li id="li'. $row['categories_id'] .'">';

            $this->db->from(TBL_CATEGORIES);
            $this->db->where('parent_id', $row['categories_id']);
            $count_child = $this->db->count_all_results();

            $this->db->from(TBL_PRODUCTS);
            $this->db->where('categorie_reference', $row['reference']);
            $count_products = $this->db->count_all_results();

            $output.= '<span id="id'.$row['categories_id'].'" class="'. ($count_child==0 ? 'file' : "folder") .'">'.$row['categorie_name'].' ('.$count_products.')</span>';

            if( $count_child>0 ) {
                $output.= '<ul>';
                $output.= $this->_get_treeview($row['categories_id']);
                $output.= '</ul></li>';
            }
            else $output.= '</li>';

        }

        return $output;
    }

    private function _delete($arr){
        foreach( $arr as $row ){

            $info = $this->db->get_where(TBL_CATEGORIES, array('categories_id'=>$row['categories_id']))->row_array();

            $this->db->trans_start(); // INICIO TRANSACCION
            if( !$this->products_panel_model->delete($info['reference']) ) return false;
            if( !$this->db->delete(TBL_CATEGORIES, array('categories_id'=>$row['categories_id'])) ) return false;
            else @unlink(UPLOAD_PATH_BANNER.$info['banner_thumb']);

            $this->db->trans_complete(); // COMPLETO LA TRANSACCION

            $this->db->select('categories_id');
            $query = $this->db->get_where(TBL_CATEGORIES, array('parent_id'=>$row['categories_id']));
            if( $query->num_rows>0 ) {
                if( !$this->_delete($query->result_array()) ) return false;
            }

        }

        return true;
    }
    
}