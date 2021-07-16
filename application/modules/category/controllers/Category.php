<?php

class Category extends MX_Controller
{
    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $datacategory = $this->db->get('category');
        $this->load->view('template/header', $data,);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('index', $data);
        $this->load->view('template/footer', $data);
    }

    public function getData()
    {
        $data =  $this->db->get('category')->result_array();
        echo json_encode($data);
    }
}
