<?php
try {
/*Connect to the database*/
$dc = new PDO("mysql:host=localhost;dbname=autosave", 'autosavedb_user', '*****');

/*Get the posted values from the form*/
$title=&$_POST['title'];
$body=&$_POST['body'];
$gtmsg=&$_POST['gtmsg'];
/*Get user id*/
$user_id=1;

$stmt = $dc->query("SELECT * FROM autosave WHERE user='$user_id'");
$return_count = $stmt->rowCount();
if($return_count > 0){

    if(isset($title)){
    /*Update autosave*/
        $update_qry = $dc->prepare("UPDATE autosave SET msg_title='$title', msg_body='$body' WHERE user='$user_id'");
        $update_qry -> execute();
    } else {
    /*Get saved data from database*/
        $get_autosave = $dc->prepare("SELECT * FROM autosave WHERE user='$user_id'");
        $get_autosave->execute();
        while ($gt_v = $get_autosave->fetch(PDO::FETCH_ASSOC)) {
            $title=$gt_v['msg_title'];
            $body=$gt_v['msg_body'];
            echo json_encode(array('title' => $title, 'body' => $body));
        }
    }
} else {
/*Insert the variables into the database*/
    $insert_qry = $dc->prepare("INSERT INTO autosave (user, msg_title, msg_body) VALUES (?, ?, ?)");
    $insert_qry->execute(array($user_id, $title, $body));
}
} catch(PDOException $e) {
    echo $e->getMessage();
    }
?>
