<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contents_panel_model extends Model {

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

        $reference = normalize(trim($this->input->post('txtTitle')));
        $data = array(
            'codlang'        => 1,
            'parent_id'      => $this->input->post('parent_id'),
            'title'          => trim($this->input->post('txtTitle')),
            'reference'      => $reference,
            'content'        => $this->input->post('txtContent'),
            'level'          => $this->input->post('parent_id')>0 ? $this->_get_level() : 0,
            'order'          => $this->_get_num_order(TBL_CONTENTS, array('parent_id'=>$this->input->post('parent_id'))),
            'date_added'     => strtotime(date('d-m-Y')),
            'last_modified'  => strtotime(date('d-m-Y'))
        );

        /*print_array($json);
        print_array($data, true);*/

        $this->db->trans_start(); // INICIO TRANSACCION
        if( $this->db->insert(TBL_CONTENTS, $data) ){
            $id = $this->db->insert_id();
            if( !$this->_copy_images($json->gallery->images_new, $id) ) return "Error Nº2";

        }else return "Error Nº1";

        $this->db->trans_complete(); // COMPLETO LA TRANSACCION

        $this->load->helper('file');
        delete_files(UPLOAD_PATH_SIDEBAR.".tmp");

        return true;
    }

    public function edit(){
        $reference = normalize(trim($this->input->post('txtCategorie')));
        $data = array(
            'codlang'           => 1,
            'categorie_name'    => trim($this->input->post('txtCategorie')),
            'reference'         => $reference,
            'categorie_content' => $this->input->post('txtContent'),
            'last_modified'     => strtotime(date('d-m-Y'))
        );

        $this->db->trans_start(); // INICIO TRANSACCION
        $this->db->where('categories_id', $this->input->post('categories_id'));
        if( !$this->db->update(TBL_CATEGORIES, $data) ) return false;
        $this->db->trans_complete(); // COMPLETO LA TRANSACCION

        return true;
    }

    public function delete($id) {
        $this->load->model('products_panel_model');
        return $this->_delete(array(array('categories_id'=>$id)));
    }

    public function get_info($id) {
        $row = array();
        $row = $this->db->get_where(TBL_CONTENTS, array('content_id'=>$id))->row_array();
        
        return $row;
    }

    public function order(){
        $initorder = $this->input->post('initorder');
        $rows = json_decode($this->input->post('rows'));

        $res = $this->db->query('SELECT `order` FROM '.TBL_CONTENTS.' WHERE content_id='.$initorder)->row_array();
        $order = $res['order'];

        //print_array($rows, true);
        foreach( $rows as $row ){
            $id = substr($row, 2);
            $this->db->where('content_id', $id);
            if( !$this->db->update(TBL_CONTENTS, array('order' => $order)) ) return false;
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
        $row = $this->db->get_where(TBL_CONTENTS, array('content_id'=>$this->input->post('parent_id')))->row_array();
        return $row['level']+1;
    }

    private function _get_treeview($parent_id=0){

        $this->db->order_by('`order`', 'asc');
        $query = $this->db->get_where(TBL_CONTENTS, array('parent_id'=> $parent_id));

        $output='';

        foreach( $query->result_array() as $row ){

            $output.= '<li id="li'. $row['content_id'] .'">';

            $this->db->from(TBL_CONTENTS);
            $this->db->where('parent_id', $row['content_id']);
            $count_child = $this->db->count_all_results();

            $output.= '<span id="id'.$row['content_id'].'" class="'. ($count_child==0 ? 'file' : "folder") .'">'.$row['title'].'</span>';

            if( $count_child>0 ) {
                $output.= '<ul>';
                $output.= $this->_get_treeview($row['content_id']);
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

            $this->db->trans_complete(); // COMPLETO LA TRANSACCION

            $this->db->select('categories_id');
            $query = $this->db->get_where(TBL_CATEGORIES, array('parent_id'=>$row['categories_id']));
            if( $query->num_rows>0 ) {
                if( !$this->_delete($query->result_array()) ) return false;
            }

        }

        return true;
    }

    private function _copy_images($json, $id){
        $n=0;
        foreach( $json as $row ){
            $n++;
            $cp1 = @copy(UPLOAD_PATH_SIDEBAR.".tmp/".$row->image_full, UPLOAD_PATH_SIDEBAR . $row->image_full);
            $cp2 = @copy(UPLOAD_PATH_SIDEBAR.".tmp/".$row->image_thumb, UPLOAD_PATH_SIDEBAR . $row->image_thumb);

            if( $cp1 && $cp2 ){
                $data = array(
                    'gallery_id'  => $id,
                    'image'       => $row->image_full,
                    'thumb'       => $row->image_thumb,
                    'width'       => $row->width,
                    'height'      => $row->height
                );

                if( !is_numeric($this->input->post('content_id')) ) $data['order'] = $n;
                if( !$this->db->insert(TBL_GALLERY_CONTENTS, $data) ) return false;
            }else return false;
        }

        return true;
    }

}