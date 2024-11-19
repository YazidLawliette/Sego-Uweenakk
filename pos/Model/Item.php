<?php 

require_once __DIR__ . '/Model.php';

class Item extends Model {
    
    protected $table = 'items';
    protected $primary_key = 'id_item';

    public function create($datas)
    {
        $nama_file = $datas['files']['attachment']['name'];
        $tmp_name = $datas['files']['attachment']['tmp_name'];
        $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_allowed = ['jpg', 'png', 'jpeg', 'heic', 'heif', 'raw', 'bmp', 'tiff', 'gif', 'avif'];

        if (!in_array($ekstensi_file, $ekstensi_allowed)) {
            return false;
        }

        if ($datas['files']['attachment']['size'] > 5120000) {
            return "Kegedean Ga Muat!";
        }

        $nama_file = uniqid() . "_" . $nama_file; // Unique file naming to avoid collisions
        if (!move_uploaded_file($tmp_name, "../public/img/items/" . $nama_file)) {
            return "File upload failed.";
        }

        $datas = [
            'name_item' => $datas['post']['name_item'],
            'attachment' => $nama_file,
            'price' => $datas['post']['price'],
            'category_id' => $datas['post']['category_id'],
        ];

        return parent::create_data($datas, $this->table);
    }

    public function all()
    {
        return parent::all_data($this->table);
    }

    public function find($id)
    {
        return parent::find_data($id, $this->primary_key, $this->table);
    }

    public function update($id, $datas)
{
    if (isset($datas['files']['attachment']) && $datas['files']['attachment']['error'] === UPLOAD_ERR_OK) {
        $nama_file = $datas['files']['attachment']['name'];
        $tmp_name = $datas['files']['attachment']['tmp_name'];
        $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_allowed = ['jpg', 'png', 'jpeg', 'heic', 'heif', 'raw', 'bmp', 'tiff', 'gif'];

        if (!in_array($ekstensi_file, $ekstensi_allowed)) {
            return "Invalid file type!";
        }

        if ($datas['files']['attachment']['size'] > 5120000) {
            return "File size exceeds the limit!";
        }

        $nama_file = uniqid() . "_" . $nama_file;
        if (!move_uploaded_file($tmp_name, "../public/img/items/" . $nama_file)) {
            return "File upload failed.";
        }
        $attachment = $nama_file;
    } else {
        $attachment = $datas['post']['attachment'] ?? null;
    }

    $datas = [
        'name_item' => $datas['post']['name_item'],
        'price' => $datas['post']['price'],
        'category_id' => $datas['post']['category_id'],
    ];
    
    if (!empty($attachment)) {
        $datas['attachment'] = $attachment;
    }

    return parent::update_data($id, $this->primary_key, $datas, $this->table);
}

    public function delete($id)
    {
        return parent::delete_data($id, $this->primary_key, $this->table);
    }

    public function search($keyword)
    {
        $keyword = " WHERE name LIKE '%" . mysqli_real_escape_string($this->db, $keyword) . "%'";
        return parent::search_data($keyword, $this->table);
    }

    public function paginate($start, $limit)
    {
        return parent::paginate_data($start, $limit, $this->table);
    }

    public function all2($start, $limit)
    {
        $query = "SELECT * FROM items JOIN categories ON items.category_id = categories.id_category ORDER BY items.id_item DESC LIMIT $start, $limit";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }
}
