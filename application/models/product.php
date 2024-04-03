<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model {

    function get_all_products() {
        return $this->db->query('SELECT * FROM products')->result_array();
    }
    function get_product_by_id($id) {
        $query = 'SELECT * FROM products WHERE id = ?';
        return $this->db->query($query,$id)->row_array();
    }
    function create_product($data) {
        $query = 'INSERT INTO products
                  (name,description,price,inventory_count,quantity_sold,created_at,updated_at,users_id)
                  VALUES(?,?,?,?,?,now(),now(),?)';
        $values = array(
            $this->security->xss_clean($data['name']), 
            $this->security->xss_clean($data['description']), 
            $this->security->xss_clean($data['price']), 
            $this->security->xss_clean($data["inventory_count"]),
            $this->security->xss_clean($data["quantity_sold"]),
            $this->security->xss_clean($data["user_id"])
        );
        return $this->db->query($query,$values);
    }
    function update_product($data) {
        $query = 'UPDATE products SET name = ?, description = ?, price = ?, inventory_count = ?,
                  updated_at = now() WHERE id = ?';
        $values = array(
            $this->security->xss_clean($data['name']), 
            $this->security->xss_clean($data['description']), 
            $this->security->xss_clean($data['price']), 
            $this->security->xss_clean($data["inventory_count"]),
            $this->security->xss_clean($data["id"])
        );
        return $this->db->query($query,$values);
    }
    function remove_product($id) {
        //Foreign key checks -- disabled for now
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $result = $this->db->query('DELETE FROM products WHERE id=?',$id);
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        return $result;
    }

    function validate_product_input() {
        $this->form_validation->set_error_delimiters('<p>','</p');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price','Price','required|numeric');        
        $this->form_validation->set_rules('inventory_count', 'Inventory Count', 'required|numeric');

        if(!$this->form_validation->run()) {
            return validation_errors();
        }
    }
}
?>