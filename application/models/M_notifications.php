<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_notifications extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function add($data)
  {
    $default = [
      'title' => '',
      'message' => '',
      'link' => null,
      'is_read' => 0,
      'type' => null,
      'meta' => null,
      'created_at' => date('Y-m-d H:i:s'),
    ];

    $insert = array_merge($default, $data);
    $this->db->insert('notifications', $insert);
    return $this->db->insert_id();
  }

  public function get_latest($limit = 5)
  {
    return $this->db->select('*')->from('notifications')->order_by('created_at', 'DESC')->limit($limit)->get()->result_array();
  }

  public function count_unread()
  {
    $row = $this->db->select('COUNT(*) total')->from('notifications')->where(['is_read' => 0])->get()->row_array();
    return isset($row['total']) ? intval($row['total']) : 0;
  }

  public function mark_read($id)
  {
    return $this->db->where(['id' => $id])->update('notifications', ['is_read' => 1]);
  }
}
