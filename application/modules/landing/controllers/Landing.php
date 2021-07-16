<?php

class Landing extends MX_Controller
{
    function index()
    {
        // dd(_db('product')->first());
        $data = $this->db->get('category');
        $data_category['data_category'] = $data->result_array();

        // dd($data_category);
        $this->load->view('template_landing/header');
        $this->load->view('template_landing/navbar');
        $this->load->view('template_landing/sidebar');
        $this->load->view('landing', $data_category);
        $this->load->view('template_landing/footer', $data_category);
    }

    public function getData()
    {
        $data = $this->db->get('products')->result_array();
        // dd($data);
        echo json_encode($data);
    }

    public function addData()
    {
        $upload_gambar = $_FILES['image'];
        if ($upload_gambar) {
            $config['upload_path']   = './assets/img';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 5000;
            $config['file_name'] = $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $image_baru = $this->upload->data('file_name');
                $this->db->set('image', $image_baru);
            }
        } else {
            echo $this->upload->display_errors();
        }
        $data = [
            'nama_category' => $this->input->post('nama_category'),
            'nama_product' => $this->input->post('nama_product'),
            'stok' => $this->input->post('stok'),
            'harga' => $this->input->post('harga'),
            'deskripsi' => $this->input->post('deskripsi')

        ];

        // dd($data);
        $this->db->insert('products', $data);
        echo json_encode($data);
    }

    public function ambilDataById()
    {
        $id_product = $this->input->post('id');
        $data = $this->db->get_where('products', ['id' => $id_product])->row_array();
        echo json_encode($data);
    }

    public function updateData()
    {
        $id = $this->input->post('id_product');
        $upload_gambar = $_FILES['image'];
        if ($upload_gambar) {
            $config['upload_path']   = './assets/img';
            $config['allowed_types'] = 'jpg|png';
            $config['max_size'] = 5000;
            $config['file_name'] = $_FILES['image']['name'];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $image_baru = $this->upload->data('file_name');
                $this->db->set('image', $image_baru);
            }
        }
        $data = [
            'nama_category' => $this->input->post('nama_category'),
            'nama_product' => $this->input->post('nama_product'),
            'harga' => $this->input->post('harga'),
            'deskripsi' => $this->input->post('deskripsi')

        ];

        // dd($data);
        $this->db->where('id', $id);
        $this->db->update('products', $data);
        echo json_encode($data);
    }

    public function hapus()
    {
        $id = $this->input->post('id');
        $this->db->delete('products', ['id' => $id]);
    }
}
