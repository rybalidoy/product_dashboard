<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends CI_Controller {

    public function add_review() {
        $post = $this->input->post(null,true);
        $result = $this->review->validate_review();
        if($result != 'success') {
            $this->session->set_flashdata('input_errors', $result);
        }
        else {
            $this->review->add_review($post);
        }
        redirect("products/show/".$post['product_id']);
    }

    public function add_reply() {
        $post = $this->input->post(null,true);

        $result = $this->reply->validate_reply();
        if($result != 'success') {
            $this->session->set_flashdata('input_errors', validation_errors());
        }
        else {
            $this->reply->add_reply($post);
        }
        redirect("products/show/". $post['product_id']);
    }
}
?>