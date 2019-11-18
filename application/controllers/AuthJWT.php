<?php
use Restserver\Libraries\REST_Controller ;

Class AuthJWT extends REST_Controller{
    
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->model('UserModel');    
        $this->load->library('form_validation');
        $this->load->helper(['jwt','authorization']);
    }
    
    public function Rules() 
    { 
        return [
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required|valid_email'
            ],
            [
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required'
            ]
        ]; 
    }
    
    public function index_post()
    {
        $validation = $this->form_validation;
        $rule = $this->Rules();
        $validation->set_rules($rule);
		if (!$validation->run()) {
			return $this->response($this->form_validation->error_array());
        }
        $user = new Data();
        $user->email = $this->post('email');
        $user->password = $this->post('password');
        
        if($result = $this->UserModel->userlogin($user))
        {
            $token = AUTHORIZATION::generateToken(['id'=>$result['id'],'name'=>$result['name']]);
            $status = parent::HTTP_OK;
            $response = ['status' => $status, 'token' => $token];
            return $this->response($response, $status);
        }else
        {
            return $this->response('gagal');
        }
    }
}
Class Data
{
    public $name;
    public $email;
    public $password;
}
?>