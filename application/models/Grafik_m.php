<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grafik_m extends CI_Model {


    public function get_data_marketing($jenis_id)
    {
        
        $data = [
            'amin' => $this->db->get_where('tbl_trans_sp',['user_name' => 'amin' , 'jenis_id' => $jenis_id])->num_rows(),
            'elmas' => $this->db->get_where('tbl_trans_sp',['user_name' => 'elmas' , 'jenis_id' => $jenis_id])->num_rows(),
            'habib' => $this->db->get_where('tbl_trans_sp',['user_name' => 'habib' , 'jenis_id' => $jenis_id])->num_rows(),
            'ummu' => $this->db->get_where('tbl_trans_sp',['user_name' => 'ummu' , 'jenis_id' => $jenis_id])->num_rows()
        ];

        return $data;
    }

}