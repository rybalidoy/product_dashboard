<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function new() {
        $current_user_id = $this->session->userdata('user_id');
        $user_level = $this->session->userdata('user_level');

        if(!$current_user_id) {
            redirect('login');
        }
        else if($user_level == 9) {
            $this->load->view('products/new_product');
        }
    }
    public function process_new_product() {
        $result = $this->product->validate_product_input();

        if($result != null) {
            $this->session->set_flashdata('input_errors',$result);
        }
        else {
            $form_data = $this->input->post(null,true);
            $form_data['user_id'] = $this->session->userdata('user_id');
            $form_data['quantity_sold'] = 0;
            $this->product->create_product($form_data);
        }
        redirect('dashboard');
    }
    public function process_update_product() {
        $result = $this->product->validate_product_input();

        if($result != null) {
            $this->session->set_flashdata('input_errors',$result);
        }
        else {
            $form_data = $this->input->post(null,true);
            $form_data['user_id'] = $this->session->userdata('user_id');
            $this->product->update_product($form_data);
        }
        redirect('dashboard');
    }
    public function show($id) {
        $current_user_id = $this->session->userdata('user_id');
        if(!$current_user_id) { 
            $this->load->view('users/login');
        }
        else {
            $product['product_details'] = $this->product->get_product_by_id($id); 
            $product_reviews = $this->review->get_reviews_of_product($id);
            $inbox= array();
            $new_reply = array();
            foreach($product_reviews as $review) {
                $replies = $this->reply->get_all_replies_of_review($review['review_id']);
                foreach($replies as $reply) {
                    //Get time diff properly
                    $reply['reply_age'] = $this->review->get_time_diff($reply['reply_date']);
                    $new_reply[] = $reply;
                }
                $review['review_age'] = $this->review->get_time_diff($review['review_date']);
                $review['replies'] = $new_reply;
                $inbox[] = $review;
            }
        }
        $param = array(
            'first_name' => $this->session->userdata('first_name'),
            'product_details' => $product['product_details'],
            'inbox' => $inbox
        );
        $this->load->view('products/show',$param);
    }

    //Edit Product Information 
    public function edit($id) {
        $current_user_id = $this->session->userdata('user_id');
        if(!$current_user_id) {
            redirect('login');
        }
        else {
            $product['product_details'] = $this->product->get_product_by_id($id); 
            $this->load->view('products/edit_product',$product);
        }
    }
    
    public function remove($id) {
        $result = $this->product->remove_product($id);
        if($this->db->error()) {
            redirect('/');
        }
    }
}
?>