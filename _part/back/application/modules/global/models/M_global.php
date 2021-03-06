<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_global extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function count_data_all($table, $join = NULL, $where = NULL, $where_e = NULL, $group = NULL)
    {
        $this->db->select("count(*) as jumlah")->from($table);

        if(!is_null($join)){
            foreach ($join as $rows) {
                $tipe = (@$rows['tipe'] != '') ? $rows['tipe'] : 'INNER';
                $this->db->join($rows['table'], $rows['on'], $tipe);
            }
        }

        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');

        $query  = $this->db->get();
        $result = $query->row();

        return $result->jumlah;
    }

    public function get_data_all($table, $join = NULL, $where = NULL, $select = '*', $where_e = NULL, $order = NULL, $start = 0, $tampil = NULL, $group = NULL)
    {
        $this->db->select($select)->from($table);

        if(!is_null($join)){
            foreach ($join as $rows) {
                $tipe = (@$rows['tipe'] != '') ? $rows['tipe'] : 'INNER';
                $this->db->join($rows['table'], $rows['on'], $tipe);
            }
        }

        (!is_null($order) ? $this->db->order_by($order[0], $order[1]) : '');
        (!is_null($tampil) ? $this->db->limit($tampil, $start) : '');
        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');
        (!is_null($group) ? $this->db->group_by($group, NULL, FALSE) : '');

        $query  = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function insert($table, $data = NULL)
    {
        $result    = $this->db->insert($table, $data);
        if($result == TRUE){
            $result = [];
            $result['status'] = TRUE;
            $result['id']     = $this->db->insert_id();
        }else{
            $result = [];
            $result['status'] = FALSE;
        }

        return $result;
    }

    public function update($table, $data = NULL, $where = NULL, $where_e = NULL)
    {
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');
        $result    = $this->db->update($table, $data, $where);
        return $result;
    }

    public function delete($table, $where = NULL, $where_e = NULL)
    {
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');
        $result    = $this->db->delete($table, $where);
        return $result;
    }

    public function validation($table, $where, $where_e = NULL)
    {
        $this->db->select('*')->from($table);
        
        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');

        $query  = $this->db->get();
		
        $result = $query->num_rows();
		if($result > 0){
            $result = FALSE;
        }else{
            $result = TRUE;
        }
        return $result;

    }
	public function validation_pass($table, $where, $where_e = NULL)
    {
        $this->db->select('*')->from($table);
        
        (!is_null($where) ? $this->db->where($where) : '');
        (!is_null($where_e) ? $this->db->where($where_e, NULL, FALSE) : '');

        $query  = $this->db->get();
		
        $result = $query->num_rows();
		if($result > 0){
            $result = TRUE;
        }else{
            $result = FALSE;
        }
        return $result;

    }

    function getData($id){
        $sql = "SELECT * FROM eoffice_circulation_attachment where attachment_id = {$this->db->escape($id)}";
        $act = $this->db->query($sql)->result();
        return $act;
    }

    // End Core Model
}

/* End of file m_global.php */
/* Location: ./application/modules/global/models/m_global.php */