<?php

class Auth extends NoAuth_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Login Web Api';
            $this->load->view('template/auth_header', $data);
            $this->load->view('template/auth_footer');
            $this->load->view('login');
        } else {

            $this->login();
        }
    }
    private function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        // dd($user);
        // die;
        if ($user) {
            //usernya aktif / ada
            // $data = [
            //     'email' => $this->$user['email'],
            //     'role_id' => $this->$user['role_id']
            // ];

            // $this->session->set_userdata($data);

            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('auth/admin');
                    }
                    redirect('auth/user');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                this email has not been actived
              </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            e-mail is not registered
          </div>');
            redirect('auth');
        }
    }


    public function registration()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|trim|valid_email|is_unique[user.email]',
            [
                'is_unique' => 'e-mail already used'
            ]
        );
        $this->form_validation->set_rules(
            'password1',
            'Password1',
            'required|trim|min_length[3]|matches[password2]',
            [
                'matches' => 'Password dont macth!',
                'min_length' => 'Password to shoort'
            ]
        );
        $this->form_validation->set_rules('password2', 'Password2', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {

            $data['title'] = 'Registration Web Api';
            $this->load->view('template/auth_header', $data);
            $this->load->view('template/auth_footer');
            $this->load->view('registration');
        } else {

            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'address' => htmlspecialchars($this->input->post('address', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];
            // dd($data);
            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            you have successfully registered, please Login !
          </div>');
            redirect('auth');
        }
    }

    public function logout()
    {

        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        you have been logged out !
      </div>');
        redirect('auth');
    }
}
