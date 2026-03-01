<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_product extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('M_app');
  }

  public function get_total_product()
  {
    $total = $this->db->select('count(*) total_product')
      ->from('products')->get()->row_array();
    if ($total) {
      return $total['total_product'];
    }

    return 0;
  }

  // integer $id product id
  // integer $category
  // bool $is_discount
  public function get_all_products($id, $category, $is_discount)
  {
    // legacy helper used by other controllers (detail, home etc.)
    // This method was intentionally simple and did not support
    // search/sorting so it shouldn't be used for filtered listings.
    $where = '';
    if ($id) {
      $where .= " AND id = $id";
    }
    if ($category) {
      $where .= " AND category = $category";
    }
    if ($is_discount) {
      $where .= " AND discount > 0";
    }

    $query = 'SELECT * FROM products WHERE 1=1' . $where;
    return $this->db->query($query)->result_object();
  }


  /**
   * Retrieve product list with optional filtering, search and sorting.
   *
   * @param mixed $category    Category id or name to filter. May be numeric or string.
   * @param string $search     Substring to match against product name.
   * @param string $sort       One of price_asc, price_desc, name_asc, name_desc.
   * @param bool   $is_discount If true only return products with discount > 0.
   * @return array             Array of result objects.
   */
  public function get_products($category = null, $search = null, $sort = null, $is_discount = false)
  {
    $this->db->select('*')->from('products');

    if ($is_discount) {
      $this->db->where('discount >', 0);
    }

    if (!empty($category)) {
      // we need to handle comma-separated category field
      // and allow matching by id or name
      $this->db->group_start();
      if (is_numeric($category)) {
        // match exact or within comma list
        $this->db->where('category', $category);
        // FIND_IN_SET returns position (0 if not found)
        $this->db->or_where("FIND_IN_SET(" . $this->db->escape_str($category) . ", category) > 0");
      } else {
        // case insensitive search on category text or within comma list
        $escaped = $this->db->escape_str(strtolower($category));
        $this->db->where("LOWER(category) = '$escaped'");
        $this->db->or_where("LOWER(category) LIKE '%$escaped%'");
      }
      $this->db->group_end();
    }

    if (!empty($search)) {
      $this->db->like('name', $search);
    }

    if (!empty($sort)) {
      switch ($sort) {
        case 'price_asc':
          $this->db->order_by('price', 'ASC');
          break;
        case 'price_desc':
          $this->db->order_by('price', 'DESC');
          break;
        case 'name_asc':
          $this->db->order_by('name', 'ASC');
          break;
        case 'name_desc':
          $this->db->order_by('name', 'DESC');
          break;
      }
    }

    return $this->db->get()->result_object();
  }

  public function data_prod($role)
  {
    $data = [
      'name' => ucwords($this->input->post('name')),
      'sku' => $this->input->post('sku'),
      'price' => $this->input->post('price'),
      'stock' => $this->input->post('stock'),
      'discount' => $this->input->post('discount'),
      // 'image' => $this->M_app->uploadFile('products', 'jpg|jpeg|png', 'file', 'default_image.png'),
      'image' => $this->M_app->uploadBase64('products', 'jpg|jpeg|png', 'base64_input', 'default_image.png'),
      'description' => $this->input->post('description'),
      'category' => $this->input->post('category'),
      'created_at' => $this->M_app->datetime(),
    ];

    return $data;
  }

  public function update_prod($foto, $foto_default)
  {
    $prod = [
      'name' => ucwords($this->input->post('name')),
      'sku' => $this->input->post('sku'),
      'price' => $this->input->post('price'),
      'stock' => $this->input->post('stock'),
      'discount' => $this->input->post('discount'),
      'image' => $this->M_app->updateBase64('products', $foto, 'jpg|jpeg|png', 'base64_input', $foto_default),
      'description' => $this->input->post('description'),
      // 'created_at' => $this->M_app->datetime(),
    ];

    $categories = $this->input->post('category');

    $prod['categories'] = implode(',', $categories);

    if (count($categories) == 1) {
      $prod['category'] = $categories[0];
    }

    return $prod;
  }

  public function save_product($role, $table, $activity)
  {
    $data = $this->data_prod($role);

    $this->db->trans_start();
    // $this->db->insert('product', $user);
    $this->db->insert($table, $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {

      //belum dibuat tabel nya
      // $this->M_app->log_activity(' menambahkan data baru ' . $activity . ' [' . $prod['id'] . ']');
      return true;
    } else {
      return false;
    }
  }

  public function update_product($foto_default, $table, $activity)
  {
    $id = $this->input->post('id');

    $foto = $this->input->post('foto_product');

    $data = $this->update_prod($foto, $foto_default);

    $this->db->trans_start();
    $this->db->where(['id' => $id]);
    $this->db->update($table, $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      // $this->M_app->log_activity(' mengubah data ' . $activity . ' [' . $id . ']');
      return true;
    } else {

      return false;
    }
  }

  public function insert_batch($prod, $identities, $datas, $table, $activity)
  {
    $this->db->trans_start();
    $this->db->insert_batch('product', $prod);
    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      // $this->M_app->log_activity(' import data baru ' . $activity);
      return true;
    } else {
      return false;
    }
  }

  public function hapus($id, $table, $activity)
  {
    $data = [
      'deleted_at' => $this->M_app->datetime(),
    ];

    $this->db->trans_start();
    $this->db->where(['id' => $id]);
    $this->db->update('product', $data);

    $this->db->trans_complete();

    if ($this->db->trans_status()) {
      // $this->M_app->log_activity($activity);
      return true;
    } else {
      return false;
    }
  }
}
