<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Contents_model extends Model {

    /* CONSTRUCTOR
     **************************************************************************/
    function  __construct() {
        parent::Model();
    }

    /* PUBLIC FUNCTIONS
     **************************************************************************/
    public function save(){
        $data = array(
            'content'       => $_POST['content'],
            'last_modified' => date('Y-m-d H:i:s')
        );
        $this->db->where('reference', $_POST['reference']);
        return $this->db->update(TBL_CONTENTS, $data);
    }

    public function get_content($ref){
        $query = $this->db->get_where(TBL_CONTENTS, array('reference'=>$ref));
        $content="";
        if( $query->num_rows>0 ) {
            $row = $query->row_array();
            $content = $row['content'];
        }
        return $content;
    }

    public function get_menu(){
        $output = '<ul id="sf-menu" class="sf-menu">';
        $output.= $this->_get_menu();
        $output.= "</ul>";
        return $output;
    }

    public function get_list(){
        $query = $this->db->get_where(TBL_CONTENTS);
        return $query->result_array();
    }

    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _get_menu($parent_id=0, &$output=''){

        $this->db->order_by('`order`', 'asc');
        $query = $this->db->get_where(TBL_CONTENTS, array('parent_id'=>$parent_id, 'exclusive'=>0));

        $j=0;

        foreach( $query->result_array() as $row ){
            $j++;

            $output.= $j==$query->num_rows ? '<li class="outline">' : '<li>';

            $this->db->from(TBL_CONTENTS);
            $this->db->where('parent_id', $row['content_id']);
            $count_child = $this->db->count_all_results();

            $href = $count_child>0 && $row['parent_id']==0 ? "#" : site_url($row['reference']);
            $class = $this->uri->segment(1)==$row['reference'] && $row['parent_id']==0 ? ' class="current"' : '';
            $output.= '<a href="'.$href.'"'.$class.'>'.$row['title'].'</a>';
            if( $row['parent_id']==0 ) $output.='<div class="line"></div>';

            if( $count_child>0 ) {
                $output.= '<ul class="hide">';
                $output.= $this->_get_menu($row['content_id']);
                $output.= '</ul></li>';
            }
            else $output.= '</li>';

        }

        return $output;
    }
    
}