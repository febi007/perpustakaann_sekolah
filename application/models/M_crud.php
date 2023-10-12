<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: anash
 * Date: 10/18/2018
 * Time: 1:04 AM
 */

class M_crud extends CI_Model{




	public function get_data($table, $field, $where=null, $order=null, $group=null, $limit_sum=0, $limit_from=0){
        $this->db->select($field);
        $this->db->from($table);
        if($where != null){ $this->db->where($where); }
        if($order != null){ $this->db->order_by($order); }
        if($group != null){ $this->db->group_by($group); }
        if($limit_sum != 0){ $this->db->limit($limit_sum, $limit_from); }
        $data = $this->db->get();
		if($data->num_rows()>0){
			foreach ($data->result_array() as $row);
			return $row;
		} else{
			return null;
		}
	}
	public function join_data($table, $field, $table_join, $on, $where=null, $order=null, $group=null, $limit_sum=0, $limit_from=0, $having=null){
		$this->db->select($field);
		$this->db->from($table);
		if(is_array($table_join) && is_array($on)){
			$i = 0;
			foreach($table_join as $row){
				if (is_array($row)) {
					$this->db->join($row['table'], $on[$i], $row['type']);
				} else {
					$this->db->join($row, $on[$i]);
				}
				$i++;
			}
		} else {
			$this->db->join($table_join, $on);
		}
		if($where != null){ $this->db->where($where); }
		if($order != null){ $this->db->order_by($order); }
		if($group != null){ $this->db->group_by($group); }
		if($having != null){ $this->db->having($having); }
		if($limit_sum != 0){ $this->db->limit($limit_sum, $limit_from); }
		$data = $this->db->get();
		return $data->result_array();
	}
	public function count_data($table, $field, $where=null, $order=null, $group=null, $limit_sum=0, $limit_from=0, $having=null){
		$col = explode('.', $field);
		if (count($col) > 1) {
			$alias = $col[1];
		} else {
			$alias = $field;
		}
		$this->db->select("COUNT(".$field.") AS ".$alias."");
		$this->db->from($table);
		if($where != null){ $this->db->where($where); }
		if($order != null){ $this->db->order_by($order); }
		if($group != null){ $this->db->group_by($group); }
		if($having != null){ $this->db->having($having); }
		if($limit_sum != 0){ $this->db->limit($limit_sum, $limit_from); }
		$data = $this->db->get();
		foreach ($data->result_array() as $row);
		return $row[$alias];
	}

    public function count_join_data($table, $field, $table_join, $on, $where=null, $order=null, $group=null, $having=null){
        $this->db->select($field);
        $this->db->from($table);
        if(is_array($table_join) && is_array($on)){
            $i = 0;
            foreach($table_join as $row){
                if (is_array($row)) {
                    $this->db->join($row['table'], $on[$i], $row['type']);
                } else {
                    $this->db->join($row, $on[$i]);
                }
                $i++;
            }
        } else {
            $this->db->join($table_join, $on);
        }
        if($where != null){ $this->db->where($where); }
        if($order != null){ $this->db->order_by($order); }
        if($group != null){ $this->db->group_by($group); }
        if($having != null){ $this->db->having($having); }
        $data = $this->db->get();
        return $data->num_rows();
    }

	public function count_data_join($table, $field, $table_join, $on, $where=null, $order=null, $group=null, $limit_sum=0, $limit_from=0, $having=null){
		$col = explode('.', $field);
		if (count($col) > 1) {
			$alias = $col[1];
		} else {
			$alias = $field;
		}
		$this->db->select("COUNT(".$field.") AS ".$alias."");
		$this->db->from($table);
		if(is_array($table_join) && is_array($on)){
			$i = 0;
			foreach($table_join as $row){
				if (is_array($row)) {
					$this->db->join($row['table'], $on[$i], $row['type']);
				} else {
					$this->db->join($row, $on[$i]);
				}
				$i++;
			}
		} else {
			$this->db->join($table_join, $on);
		}
		if($where != null){ $this->db->where($where); }
		if($order != null){ $this->db->order_by($order); }
		if($group != null){ $this->db->group_by($group); }
		if($having != null){ $this->db->having($having); }
		if($limit_sum != 0){ $this->db->limit($limit_sum, $limit_from); }
		$data = $this->db->get();
		foreach ($data->result_array() as $row);
		return $row[$alias];
	}
	public function count_all($field, $table_join, $on, $table, $where = NULL, $order = NULL, $by = NULL){
		$this->db->select($field);
		$this->db->from($table);
		if (is_array($table_join) && is_array($on)) {
			$i = 0;
			foreach ($table_join as $row) {
				if (is_array($row)) {
					$this->db->join($row['table'], $on[$i], $row['type']);
				} else {
					$this->db->join($row, $on[$i], 'LEFT');
				}
				$i++;
			}
		} else {
			$this->db->join($table_join, $on, 'LEFT');
		}
		$where != "" ? $this->db->where($where) : NULL;
		$order != "" ?  $this->db->order_by($order, $by) : NULL;
		// $limit != "" ?  $this->db->limit($limit, $start) : NULL;
		// $or_like != "" ?  $this->db->or_like($or_like, $search) : NULL;
		$query = $this->db->get();
		return $query;
	}
	public function get_join_data($table, $field, $table_join, $on, $where=null, $order=null, $group=null, $limit_sum=0, $limit_from=0, $having=null){
		$this->db->select($field);
		$this->db->from($table);
		if(is_array($table_join) && is_array($on)){
			$i = 0;
			foreach($table_join as $row){
				if (is_array($row)) {
					$this->db->join($row['table'], $on[$i], $row['type']);
				} else {
					$this->db->join($row, $on[$i]);
				}
				$i++;
			}
		} else {
			$this->db->join($table_join, $on);
		}
		if($where != null){ $this->db->where($where); }
		if($order != null){ $this->db->order_by($order); }
		if($group != null){ $this->db->group_by($group); }
		if($having != null){ $this->db->having($having); }
		if($limit_sum != 0){ $this->db->limit($limit_sum, $limit_from); }
		$data = $this->db->get();
		
		if($data->num_rows()>0){
			foreach ($data->result_array() as $row);
			return $row;
		} else{
			return null;
		}
	}
	public function read_data($table, $field, $where=null, $order=null, $group=null, $limit_sum=0, $limit_from=0, $having=null){
		$this->db->select($field);
		$this->db->from($table);
		if($where != null){ $this->db->where($where); }
		if($order != null){ $this->db->order_by($order); }
		if($group != null){ $this->db->group_by($group); }
		if($having != null){ $this->db->having($having); }
		if($limit_sum != 0){ $this->db->limit($limit_sum, $limit_from); }
		$data = $this->db->get();
		return $data->result_array();
	}
    public function create_data($tabel, $data){
        $data = $this->db->insert($tabel, $data);
        return $data;
    }
	public function update_data($tabel, $data, $where){
		$data = $this->db->update($tabel, $data, $where);
		return $data;
	}
	public function delete_data($tabel, $where){
		$data = $this->db->delete($tabel, $where);
		return $data;
	}
    public function generate_kode($jenis, $status, $tanggal) {
        $kode_baru = '';
        if ($jenis == "PI") {
            $get_max_kode = $this->m_crud->get_data("tbl_master_peminjaman","MAX(SUBSTRING(kd_trx, 10, 4)) AS max_kode","(SUBSTRING(kd_trx, 15, 1) = '".$status."') AND (SUBSTRING(kd_trx, 4, 6) = '".$tanggal."')");
            $max_kode = $get_max_kode['max_kode'];
            $kode_baru = $jenis."-".$tanggal.sprintf('%04d', $max_kode+1)."-".$status;
        }
        else if ($jenis == "PE") {
            $get_max_kode = $this->m_crud->get_data("tbl_master_peminjaman","MAX(SUBSTRING(kd_trx, 10, 4)) AS max_kode","(SUBSTRING(kd_trx, 15, 1) = '".$status."') AND (SUBSTRING(kd_trx, 4, 6) = '".$tanggal."')");
            $max_kode = $get_max_kode['max_kode'];
            $kode_baru = $jenis."-".$tanggal.sprintf('%04d', $max_kode+1)."-".$status;
        }


        return $kode_baru;
    }
    function getKodeTrx($jenis){
        $q = $this->db->query("SELECT MAX(RIGHT(kd_trx,4)) AS kd_max FROM tbl_master_peminjaman WHERE DATE(tgl_pinjam)=CURDATE()");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%04s", $tmp);
            }
        }else{
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return $jenis.'-'.date('dmy').$kd;
    }
}