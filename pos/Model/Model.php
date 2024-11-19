<?php 

session_start();

require_once __DIR__ . '/../DB/Conection.php';
require_once __DIR__ . '/../Interface/Modelinterface.php';


abstract class Model extends Conection implements ModelInterface {
    public function create_data($datas, $table){
        $key = array_keys($datas);
        $value = array_values($datas);
        $key = implode(",", $key);
        $value = implode("','", $value);
        $query = "INSERT INTO $table ($key) VALUES ('$value')";
        $result = mysqli_query($this->db, $query);

        if($result){
            return $datas;
        } else {
            return false;
        }
    }

    public function all_data($table)
    {
        $query = "SELECT * FROM $table";
        $result = mysqli_query($this->db, $query);

        return $this->convert_data($result);
    }

    public function convert_data($datas)
    {
        $data = [];
        while( $row = mysqli_fetch_assoc($datas) ) {
            $data[] = $row;
        }
        return $data;
    }

    public function find_data($id, $colomn, $table)
    {
        $query = "SELECT * FROM $table WHERE {$colomn} = $id";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }

    public function update_data($id, $colomn, $datas, $table)
    {
        $key = array_keys($datas);
        $value = array_values($datas);
        $query = "UPDATE $table SET ";
        for($i = 0; $i < count($key); $i++) {
            $query .= $key[$i] . " = '" . $value[$i] . "'";
            if($i != count($key) - 1) {
                $query .= " , ";
            }
        }
        $query .= " WHERE {$colomn} = $id";
        $result = mysqli_query($this->db, $query);
        if($result){
            return $datas;
        } else {
            return false;
        }
    }

    public function delete_data($id, $colomn, $table)
    {
        $query = "DELETE FROM $table WHERE {$colomn} = $id";
        $result = mysqli_query($this->db, $query);   
        return $result;
    }

    public function search_data($keyword, $table){
        $query = "SELECT * FROM $table $keyword";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }

    public function paginate_data($start, $limit, $table)
    {
        $query = "SELECT * FROM $table LIMIT $start, $limit";
        $result = mysqli_query($this->db, $query);
        return $this->convert_data($result);
    }
}