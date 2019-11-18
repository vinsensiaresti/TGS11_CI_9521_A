<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserSparepart extends CI_Model
{
    private $table = 'spareparts';
    public $id;
    public $name;
    public $merk;
    public $jumlah;
    public $created_at;
    public $rule = 
    [
        [
            'field'=>'name',
            'label'=>'name',
            'rules'=>'required|alpha'
        ],
        [
            'field'=>'merk',
            'label'=>'merk',
            'rules'=>'required'
        ],
        [
            'field'=>'jumlah',
            'label'=>'jumlah',
            'rules'=>'required|numeric'
        ]
    ];
    
    public function Rules()
    { 
        return $this->rule;
    }
    
    public function getAll()
    {
        return $this->db->get('data_sparepart')->result();
    }
    
    public function store($request)
    {
        $this->name = $request->name;
        $this->merk = $request->merk; 
        $this->jumlah = $request->jumlah; 
        $this->created_at = $request->created_at;
        if($this->db->insert($this->table,$this)){
            return['msg'=>'Berhasil','error'=>false];
        }
        return['msg'=>'Gagal','error'=>true];
    }
    
    public function update($request,$id)
    {
        $updateData = ['name' => $request->name, 'merk' => $request->merk,'jumlah' => $request->jumlah];
        if($this->db->where('id',$id)->update($this->table, $updateData))
        {
            return['msg'=>'Berhasil','error'=>false];
        }
        return['msg'=>'Gagal','error'=>true];
    }
    
    public function destroy($id)
    {
        if(empty($this->db->select('*')->where(array('id'=>$id))->get($this->table)->row()))
            return ['msg'=>'Id tidak ditemukan','error'=>true];
        if($this->db->delete($this->table,array('id'=>$id)))
        {
            return ['msg'=>'Berhasil','error'=>false];
        }
        return['msg'=>'Gagal','error'=>true];
    }
}
?>