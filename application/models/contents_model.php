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

    public function get_content($ref=null){
        if( !is_null($ref) ){
            $where = array('reference'=>$ref);
        }else{
            $segs = $this->uri->segment_array();
            $level = count($segs);
            $where = array('reference'=>$segs[$level], 'level'=>$level-1);
        }

        $query = $this->db->get_where(TBL_CONTENTS, $where);
        $content="";
        if( $query->num_rows>0 ) {
            $content = array();
            $content = $query->row_array();

            // Extrae los contenidos hijos
            $this->db->order_by('order', 'asc');
            $query = $this->db->get_where(TBL_CONTENTS, array('parent_id'=>$content['content_id']));
            $content['lastchild'] = false;
            if( $query->num_rows>0 ) $content['childs'] = $query->result_array();
            else{
                if( $content['parent_id']>0 ){
                    $query = $this->db->get_where(TBL_CONTENTS, array('parent_id'=>$content['parent_id']));
                    $content['childs'] = $query->result_array();
                    $content['lastchild'] = true;
                }
            }

            // Extra la galeria de imagenes
            $this->db->order_by('order', 'asc');
            $query = $this->db->get_where(TBL_GALLERY_CONTENTS, array('content_id'=>$content['content_id']));
            if( $query->num_rows>0 ) $content['gallery'] = $query->result_array();

            $content['title'] = $this->_get_title($content['content_id']);
            if( count($content['title'])>1 ){
                array_pop($content['title']);
                $content['title'] = array_reverse($content['title']);
            }
            $content['title'] = implode(" &gt; ", $content['title']);
        }

        return $content;
    }

    public function get_menu(){
        $output = '<ul id="sf-menu" class="sf-menu">';
        $output.= $this->_get_menu();
        $output.= "</ul>";

        $i = strpos($output, '</li>', strpos($output, '>Productos<'));
        $part1 = substr($output, 0, $i);
        $part2 = substr($output, $i);

        $output = $part1 .'<ul class="hide">'. $this->_get_menu_catalog(). '</ul>'. $part2;

        return $output;
    }

    public function get_list(){
        $this->db->order_by('order', 'asc');
        $query = $this->db->get_where(TBL_CONTENTS);
        return $query->result_array();
    }

    /* PRIVATE FUNCTIONS
     **************************************************************************/
    private function _get_menu($parent_id=0, $reference_parent=''){

        $this->db->order_by('`order`', 'asc');
        $query = $this->db->get_where(TBL_CONTENTS, array('parent_id'=>$parent_id, 'exclusive'=>0));

        $j=0;
        $output='';

        foreach( $query->result_array() as $row ){
            $j++;

            $output.= $j==$query->num_rows ? '<li class="outline">' : '<li>';

            $this->db->from(TBL_CONTENTS);
            $this->db->where('parent_id', $row['content_id']);
            $count_child = $this->db->count_all_results();

            $href = $count_child>0 && $row['parent_id']==0 || $row['reference']=="productos" ? "#" : site_url($reference_parent."/".$row['reference']);
            $seg = $this->uri->segment(1);
            $class = $seg==$row['reference'] && $row['parent_id']==0 ? ' class="current"' : '';
            $output.= '<a href="'.$href.'"'.$class.'>'.$row['title'].'</a>';
            if( $row['parent_id']==0 ) $output.='<div class="line"></div>';

            if( $count_child>0 ) {
                $output.= '<ul class="hide">';
                $reference = $row['reference'];
                if( $reference_parent!='' ) $reference = $reference_parent .'/'. $row['reference'];
                $output.= $this->_get_menu($row['content_id'], $reference);
                $output.= '</ul></li>';
            }
            else $output.= '</li>';

        }

        return $output;
    }

    private function _get_menu_catalog($parent_id=0, $reference_parent='productos'){

        $this->db->distinct();
        $this->db->select(TBL_CATEGORIES.'.*', true);
        $this->db->from(TBL_CATEGORIES);
        $this->db->order_by(TBL_CATEGORIES.'.`order`', 'asc');
        $this->db->join(TBL_PRODUCTS, TBL_CATEGORIES.'.reference = '.TBL_PRODUCTS.'.categorie_reference');
        $this->db->where(TBL_CATEGORIES.'.parent_id', $parent_id);
        $query = $this->db->get();

        $j=0;
        $output='';

        foreach( $query->result_array() as $row ){
            $j++;

            $output.= $j==$query->num_rows ? '<li class="outline">' : '<li>';

            $this->db->from(TBL_CATEGORIES);
            $this->db->join(TBL_PRODUCTS, TBL_CATEGORIES.'.reference='.TBL_PRODUCTS.'.categorie_reference');
            $this->db->where(TBL_CATEGORIES.'.parent_id', $row['categories_id']);
            $count_child = $this->db->count_all_results();
            
            $reference = $reference_parent."/".$row['reference'];
            $href = site_url($reference);
            $seg = $this->uri->segment(1);
            $output.= '<a href="'.$href.'">'.$row['categorie_name'].'</a>';

            if( $count_child>0 ) {
                $output.= '<ul class="hide">';
                $output.= $this->_get_menu_catalog($row['categories_id'], $reference);
                $output.= '</ul></li>';
            }
            else $output.= '</li>';

        }

        return $output;
    }

    private function _get_title($id, &$title=array()){
        $this->db->select('title, parent_id');
        $row = $this->db->get_where(TBL_CONTENTS, array('content_id'=>$id))->row_array();

        $title[] = $row['title'];

        $childs = $this->db->get_where(TBL_CONTENTS, array('content_id'=>$row['parent_id']))->num_rows;
        if( $childs>0 ) $this->_get_title($row['parent_id'], $title);

        return $title;
    }
    
}