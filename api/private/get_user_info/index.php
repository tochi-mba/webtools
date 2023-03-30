<?php
require "../private.php";
require "../../../connect.php";

if(isset($_POST['api_token']) && isset($_POST['uid'])){
    
    $data = array();
    $data['api_token'] = $_POST['api_token'];
    $data['uid'] = $_POST['uid'];
    require "../spam.php";
    $query = "SELECT first_name, last_name, username, api_token FROM users WHERE uid = '".$data['uid']."' AND api_token = '".$data['api_token']."'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $data['first_name'] = $row['first_name'];
        $data['last_name'] = $row['last_name'];
        $data['username'] = $row['username'];
        $data['api_token'] = $row['api_token'];
        echo json_encode($data);
    } else {
        echo json_encode(array('message' => 'Failure'));
    }
} else {
    echo json_encode(array('message' => 'Fields not filled'));
}

?>