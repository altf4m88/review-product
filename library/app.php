<?php

class App
{              
    public function login($connect, $table, $username, $password, $redirect)
    {
        session_start();
        $query = "SELECT * FROM $table WHERE username='$username' AND password='$password'";
        $result = mysqli_num_rows(mysqli_query($connect, $query));

        echo "$result";

        if ($result) {
            $_SESSION['user']=$username;
            echo "
            <script>
                alert('Welcome $username');
                document.location.href='$redirect';
            </script>";
        } else {
            echo "
            <script>
                alert('Failed login attempt, please check your username & password');
                document.location.href='index.php';
            </script>";
        }
    }

    public function create($connect, $table, array $field, $redirect)
    {
        $query = "INSERT INTO $table SET ";

        foreach($field as $key => $value)
        {
            $query.=" $key = '$value',";
        }

        $query = rtrim($query, ',');

        $execute = mysqli_query($connect, $query);

        if($execute){
            $_SESSION['is_success'] = 'true';
            echo "
            <script>
                document.location.href='$redirect';
            </script>";
        } else {
            $_SESSION['is_success'] = 'false';
            echo "
            <script>
                document.location.href='$redirect';
            </script>";
        }
    }

    public function get($connect, $table)
    {
        $query = "SELECT * FROM $table";
        $execute = mysqli_query($connect, $query);
        while($result = mysqli_fetch_assoc($execute))
        {
            $data[] = $result;
        }
        return $data;
    }

    public function delete($connect, $table, $params, $redirect){
        $query = "DELETE FROM $table WHERE $params";
        $execute = mysqli_query($connect, $query);
        if ($execute) {
            echo "
            <script>
            alert('Data successfully deleted');
            document.location.href='$redirect'
            </script>";
        } else {
            echo "
            <script>
            alert('Failed to delete data');
            document.location.href='$redirect'
            </script>";
        }
    }

    function detail($connect, $table, $params){
        $query = "SELECT * FROM $table WHERE $params";
        $execute = mysqli_query($connect, $query);
        $result = mysqli_fetch_assoc($execute);
        return $result;
    }

    public function update($connect, $table, array $field, $params, $redirect){
        $query = "UPDATE $table SET ";
        foreach($field as $key => $value){
            $query.= " $key = '$value',";
        }
        $query = rtrim($query, ',');
        $query.= " WHERE $params";
        $execute = mysqli_query($connect, $query);

        if($execute){
            $_SESSION['is_success'] = 'true';
            echo "
            <script>
                document.location.href='$redirect';
            </script>";
        } else {
            $_SESSION['is_success'] = 'false';
            echo "
            <script>
                document.location.href='$redirect';
            </script>";
        }
    }

    public function upload($image, $location){
        $filename = $image['tmp_name'];
        $destination = $image['name'];
        move_uploaded_file($filename, "$location/$destination");
        return $filename;
    }
}