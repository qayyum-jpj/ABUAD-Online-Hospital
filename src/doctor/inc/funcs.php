<?php

#functions goes here

# CRUD Functions
#CRUD FUNCTIONS

function dbInsert($table,$param=array()){
    global $conn;
    $table_columns = implode(',', array_keys($param));
    $table_value = implode("','", $param);

    $query = mysqli_query($conn, "INSERT INTO $table($table_columns) VALUES('$table_value')");
    if($query){
        return 'success';
    }
    else{
        return 'error';
    }
}


function dbUpdate($table,$param=array(),$id){
    $args = array();
    global $conn;

    foreach ($param as $key => $value) {
        $args[] = "$key = '$value'";
    }

    $sql="UPDATE  $table SET " . implode(',', $args);

    $sql .=" WHERE $id";

    $query = mysqli_query($conn,$sql);
    if($query){
        return 'success';
    }
    else{
        return 'error '.mysqli_error($conn);
    }
}

function dbDelete($table,$id){
    global $conn;
    $sql="DELETE FROM $table";
    $sql.=" WHERE $id ";
    $sql;
    $query = mysqli_query($conn,$sql);
    if($query){
        return 'success';
    }
    else{
        return 'error';
    }
}


function dbSelect($table,$cols="*",$where = null, $order = null, $limit = null, $offset = null){
    global $conn;
    if ($where != null) {
        $sql="SELECT $cols FROM $table WHERE $where";
    }else{
        $sql="SELECT $cols FROM $table";
    }
    if($order != null){
        $sql .= ' ORDER BY '.$order;
    }
    if($limit != null){
        $sql .= ' LIMIT '.$limit;
    }
    if($offset != null){
        $sql .= ' OFFSET '.$offset;
    }

    $query = mysqli_query($conn,$sql);
    if($query){
        return $query;
    }
    else{
        return 'error';
    }
}

function logAction($msg, $user, $userType = 'admin', $color = 'success'){
    global $now;
    if(!empty($msg) && ($user != '' || $user > 0)){
        $q = dbInsert('act_logs',['user'=>$user, 'log'=>$msg, 'userType'=>$userType, 'color'=>$color, 'dc'=>$now]);
        if($q == 'success'){
            return 'logged';
        }
        else{
            return null;
        }
    }
    else{
        return null;
    }
}

function fancyTime($time){
    $timeDifference = time()  - $time;
    if($timeDifference < 1){
        return '-1 sec ago';
    }
    $timeVars = [
        12 * 30 * 24 * 60 * 60  => 'yr',
        30 * 24 * 60 * 60       => 'month',
        24 * 60 * 60            => 'day',
        60 * 60                 => 'hr',
        60                      => 'min',
        1                       => 'sec'
    ];
    foreach($timeVars as $seconds => $name){
        $difference = $timeDifference/$seconds;
        if($difference >= 1){
            $roundedTime = round($difference);
            return $roundedTime." ".$name.($roundedTime > 1 ? 's' : '').' ago';
        }
    }
}

function dbTruncate($table){
    global $conn;
    $sql="TRUNCATE TABLE $table";
    $query = mysqli_query($conn,$sql);
    if($query){
        return 'success';
    }
    else{
        return 'error';
    }
}


function getColumnVal($table,$id,$col='name'){
    global $conn;
    if (!empty($table) && !empty($id)) {
        $q = mysqli_query($conn,"SELECT $col FROM $table WHERE id=$id");
        if($q){
            $row = mysqli_fetch_array($q);
            // Check if $row is valid before accessing the array key
            return $row ? $row[$col] : null; 
        }
        else{
            return null;
        }
    }
    else{
        return null;
    }
}

function getColumnValWh($table,$id,$role,$col='name'){
    global $conn;
    if (!empty($table) && !empty($id)) {
        $q = mysqli_query($conn,"SELECT $col FROM $table WHERE id=$id AND role=$role");
        if($q){
            $row = mysqli_fetch_array($q);
            // Check if $row is valid before accessing the array key
            return $row ? $row[$col] : null; 
        }
        else{
            return null;
        }
    }
    else{
        return null;
    }
}

function cntRows($tbl,$col,$where=null){
    global $conn;
    if($where != null)
        $q = mysqli_query($conn, "SELECT $col FROM $tbl WHERE $where");
    else
        $q = mysqli_query($conn, "SELECT $col FROM $tbl");
    
    if($q)
        return mysqli_num_rows($q);
    else
        return 0;
}

function changeStatus($table, $id, $newStatus = 'active'){
    global $now;
    if(!empty($table) && !empty($id)){
        $q = dbUpdate($table,['status'=>$newStatus, 'du'=>$now],"id=".$id);
        if($q == 'success'){
            return 'changed';
        }
        else{
            return 'failed';
        }
    }
    else{
        return 'failed';
    }
}

function resetPwd($table, $id, $col = 'password'){
    global $now, $defPwd; $pwd = md5($defPwd);
    $dbPwd = getColumnVal($table,$id,$col);
    if(!empty($table) && !empty($id)){
        if($dbPwd != $pwd){
            $q = dbUpdate($table,[$col=>$pwd, 'du'=>$now],"id=".$id);
            if($q == 'success'){
                return 'ok';
            }
            else{
                return 'failed';
            }
        }else{
            return 'same';
        }
    }
    else{
        return 'failed';
    }
}

function formatStatus($status){
    if(!empty($status))
        if($status == 'active')
            $color = 'success';
        elseif($status == 'pending')
            $color = 'warning';
        elseif($status == 'inactive')
            $color = 'danger';
        else
            $color = 'secondary';
    return $color;
}

function preventDuplicateID($tbl,$idVal,$col='userID'){
    $q = dbSelect($tbl,$col,"$col='$idVal'");
    if(mysqli_num_rows($q) > 0){
        return 'exist';
    }
    else{
        return 'ok';
    }
}

function renderDBData($data,$type = 'str'){
    if(!empty($data)){
        if($type == 'str'){
            return null;
        }
    }
}

$checkEmail = fn($e) => match(true) {
    empty($e) => "value expected",
    !filter_var($e, FILTER_VALIDATE_EMAIL) => "Invalid email format.",
    default => null
};