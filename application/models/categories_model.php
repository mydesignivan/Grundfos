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
        $reference = normalize(trim($this->input->post('txtCategorie')));
        $data = array(
            'codlang'           => 1,
            'parent_id'         => $this->input->post('parent_id'),
            'categorie_name'    => trim($this->input->post('txtCategorie')),
            'reference'         => $reference,
            'categorie_content' => $this->input->post('txtContent'),
            'level'             => $this->input->post('parent_id')>0 ? $this->_get_level() : 0,
            'order'             => $this->_get_num_order(TBL_CATEGORIES, array('parent_id'=>$this->input->post('parent_id'))),
            'date_added'        => strtotime(date('d-m-Y')),
            'last_modified'     => strtotime(date('d-m-Y'))
        );

        $this->db->trans_start(); // INICIO TRANSACCION
        if( !$this->db->insert(TBL_CATEGORIES, $data) ) return false;
        $id = $this->db->insert_id();
        $this->db->trans_complete(); // COMPLETO LA TRANSACCION

        return $id;
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

        $where = array('categories_id'=>$id);
        $row = $this->db->get(TBL_CATEGORIES, $where);
        $this->db->delete(TBL_CATEGORIES, $where);

        return true;
    }

    public function get_info($id) {
        $row = array();
        $row = $this->db->get_where(TBL_CATEGORIES, array('categories_id'=>$id))->row_array();
        
        return $row;
    }

    public function get_reference($id){
        $this->db->select('reference');
        $row = $this->db->get_where(TBL_CATEGORIES, array('categories_id' => $id))->row_array();
        return $row['reference'];
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

        $this->db->distinct();
        $this->db->select(TBL_CATEGORIES.'.*', true);
        $this->db->from(TBL_CATEGORIES);
        $this->db->order_by(TBL_CATEGORIES.'.`order`', 'asc');
        $this->db->where(TBL_CATEGORIES.'.parent_id', $parent_id);
        $query = $this->db->get();

        $output='';

        foreach( $query->result_array() as $row ){

            $output.= '<li>';

            $this->db->from(TBL_CATEGORIES);
            $this->db->where(TBL_CATEGORIES.'.parent_id', $row['categories_id']);
            $count_child = $this->db->count_all_results();

            $output.= '<span id="id'.$row['categories_id'].'" class="'. ($count_child==0 ? 'file' : "folder") .'">'.$row['categorie_name'].'</span>';

            if( $count_child>0 ) {
                $output.= '<ul>';
                $output.= $this->_get_treeview($row['categories_id']);
                $output.= '</ul></li>';
            }
            else $output.= '</li>';

        }

        return $output;
    }

    private function _delete(){

    }
    
}