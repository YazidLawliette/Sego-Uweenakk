<?php

require_once __DIR__ . '/Model.php';

class User extends Model
{

    protected $table = 'users';
    protected $primary_key = 'id_user';
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
        return parent::find_data($id, $this->primary_key, $this->table);
    }

    public function update($id, $datas)
    {
        return parent::update_data($id, $this->primary_key, $datas, $this->table);
    }

    public function delete($id)
    {
        return parent::delete_data($id, $this->primary_key, $this->table);
    }

    public function register($datas)
    {
        $email = $datas['post']['email'];
        $name = $datas['post']['name'];
        $password = $datas['post']['password'];

        $query = "SELECT * FROM {$this->table} WHERE email = '$email'";
        $result = mysqli_query($this->db, $query);
        if (mysqli_num_rows($result) > 0) {
            return "Email already exists!";
        }

        $nama_file = $datas['files']['avatar']['name'];
        $tmp_name = $datas['files']['avatar']['tmp_name'];
        $ekstensi_file = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_allowed = ['jpg', 'png', 'jpeg', 'heic', 'heif', 'raw', 'bmp', 'tiff', 'gif'];
        if (!in_array($ekstensi_file, $ekstensi_allowed)) {
            return false;
        }

        if ($datas['files']['avatar']['size'] > 5120000) {
            return "Kegedean Ga Muat!";
        }

        $nama_file = random_int(1000, 9999) . "." ;
        move_uploaded_file($tmp_name, "../public/img/users/" );
        $password = base64_encode($password);

        $query_register = "INSERT INTO {$this->table} (name, email, password, avatar) VALUES ('$name', '$email', '$password', '$nama_file')";
        $result = mysqli_query($this->db, $query_register);

        if (!$result) {
            return "Failed to register user!";
        }

        $user = mysqli_fetch_assoc($result);
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['avatar'] = $nama_file;

        $detail_user = [
            'name' => $name,
            'avatar' => $nama_file,
            'email' => $email
        ];

        return $detail_user;
    }
    public function login($email, $password)
    {
        $query = "SELECT * FROM {$this->table} WHERE email = '$email'";
        $result = mysqli_query($this->db, $query);

        if (mysqli_num_rows($result) == 0) {
            return "User not found!";
        }

        $user = mysqli_fetch_assoc($result);

        if (base64_decode($user['password'], false) == $password) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['avatar'] = $user['avatar'];
            
            $detail_user = [
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'avatar' => $user['avatar']
            ];
            return $detail_user;
        } else {
            return "Wrong password!";
        }
    }

    public function logout()
    {
        session_destroy();
        return "Logged out!";
    }

    public function updatePassword($id, $old_pass, $new_pass)
    {
        $query = "SELECT * FROM {$this->table} WHERE id_user = '$id'";
        $result = mysqli_query($this->db, $query);
        if (mysqli_num_rows($result) == 0) {
            return "User not found!";
        }

        $user = mysqli_fetch_assoc($result);
        if (base64_decode($user['password'], false) !== $old_pass) {
            return "Old password is incorrect!";
        }

        $new_pass = base64_encode($new_pass);
        $query_update = "UPDATE {$this->table} SET password = '$new_pass' WHERE id_user = '$id'";
        $resultUpdate = mysqli_query($this->db, $query_update);
        if ($resultUpdate == false) {
            return "Failed to update password!";
        }
        return [
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'avatar' => $user['avatar']
        ];
    }
}
