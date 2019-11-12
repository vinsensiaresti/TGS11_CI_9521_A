<?php
use Restserver \Libraries\REST_Controller;

Class Sparepart extends REST_Controller{
    
    public function __construct()
    {
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Methods:GET,OPTIONS,POST,DELETE");
        header("Access-Control-Allow-Headers:Content-Type,Content-Length,Accept-Encoding");
        parent::__construct();
        $this->load->model('UserSparepart');
        $this->load->library('form_validation');
    }
    
    public function index_get()
    {
        return $this->returnData($this->db->get('sparepart')->result(),false);
    }
    
    public function index_post($id=null)
    {
        $validation=$this->form_validation;
        $rule=$this->UserSparepart->rules();
        if($id==null){
            array_push($rule,[
                'field'=>'id',
                'label'=>'id',
                'rules'=>'id'
            ],
            [
                'field'=>'name',
                'label'=>'name',
                'rules'=>'required'
            ],
            [
                'field'=>'merk',
                'label'=>'merk',
                'rules'=>'merk'
            ],
            [
                'field'=>'jumlah',
                'label'=>'jumlah',
                'rules'=>'required|numeric'
            ],
            [
                'field'=>'created_at',
                'label'=>'created_at',
                'rules'=>'required'
            ]

        );
        }else
        {
            array_push($rule,
            [
                'field'=>'merk',
                'label'=>'merk',
                'rules'=>'required'

            ],
            [
                'field'=>'jumlah',
                'label'=>'jumlah',
                'rules'=>'required|numeric'
                
            ],
            [
                'field'=>'created_at',
                'label'=>'created_at',
                'rules'=>'required'

            ]

            );
        }
        $validation->set_rules($rule);
        if(!$validation->run())
        {
            return $this->returnData($this->form_validation->error_array(),true);
        }
        $sparepart = new UserData();
        $sparepart->id = $this->post('id');
        $sparepart->name = $this->post('name');
        $sparepart->merk = $this->post('merk');
        $sparepart->jumlah = $this->post('jumlah');

        date_default_timezone_set('Asia/Jakarta');
        $now = date ('Y/m/d H:i:s');
        $sparepart->created_at = $now;
        if($id==null)
        {
            $response=$this->UserSparepart->store($sparepart);
        }else
        {
            $response=$this->UserSparepart->update($sparepart,$id);
        }
        return $this->returnData($response['msg'],$response['error']);
    }
    
    public function index_delete($id=null)
    {
        if($id==null){
            return $this->returnData('Parameter Id Tidak Ditemukan',true);
        }
        $response=$this->UserSparepart->destroy($id);
        return $this->returnData($response['msg'],$response['error']);
    }
    
    public function returnData($msg,$error)
    {
        $response['error']=$error;
        $response['message']=$msg;return$this->response($response);
    }

}

Class UserData{
    public $id; 
    public $name; 
    public $merk;
    public $jumlah;
    public $created_at;
}