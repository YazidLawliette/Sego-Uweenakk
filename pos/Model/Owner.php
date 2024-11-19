<?php 

require_once __DIR__ . '/Model.php';

class Owner extends Model {
    
    protected $table = 'owners';
    protected $primary_key = 'id_sale';
    public function create($datas)
    {
        return parent::create_data($datas, $this->table);
    }

    public function all()
    {
        return parent::all_data($this->table);
    }

    public function find($id)
    {
        return parent::find_data($id, $this->primary_key,  $this->table);
    }

    public function update($id, $datas)
    {
        return parent::update_data($id, $this->primary_key, $datas, $this->table);
    }

    public function delete($id)
    {
        return parent::delete_data($id, $this->primary_key, $this->table);
    }
    
}