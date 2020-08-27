<?php

    include("database_connection.php");
    session_start();

    // fetch all user details except currently logged in user
    $query = "SELECT * FROM login WHERE user_id != '".$_SESSION['user_id']."'";
    $statement = $connect -> prepare($query);
    $statement -> execute();
    $result = $statement -> fetchAll();
    $output = '
        <table class="table table-bordered table-striped">
            <tr>
                <th width="70%">Username</th>    
                <th width="20%">Status</th>    
                <th width="10%">Action</th>    
            </tr>
    ';
    
    foreach($result as $row) {
        $status = '';
        $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
        $current_timestamp = date('Y-m-d H:i:s', $current_timestamp);
        $user_last_activity = fetch_user_last_activity($row['user_id'], $connect);

        if($user_last_activity > $current_timestamp) {      // user online
            $status = '<span class="label label-success">Online</span>';
        }
        else {      // user offline
            $status = '<span class="label label-danger">Offline</span>';
        }

        $output .= '
            <tr>
                <td>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</td>
                <td>'.$status.'</td>
                <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td>
            </tr>
        '; 
    }

    $output .= '</table>';
    echo $output;

?>