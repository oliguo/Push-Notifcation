<?php 

require 'mysql.php';
//mysql
$register_id='';
$register_id=$_POST['registerID'];
$device='';
$device=$_POST['device'];
if(isset($_POST['submit'])&&$_POST['submit']==='olisubmit'){
    if($device==='Android'){
        $insertGCM_sql="insert into push(push_device,push_idGoogle,push_tokenApple)values('".
        $device."','".$register_id."','')";
    }else{
        $insertGCM_sql="insert into push(push_device,push_tokenApple,push_idGoogle)values('".
        $device."','".$register_id."','')";
    }
    $idExist=IDEXIST($register_id,$device);
    if(!$idExist){
if(mysql_query($insertGCM_sql)){
    echo 'register!';
}
    }else{
        echo 'exist!';
    }
    
}

function IDEXIST($register_id,$device){
    $select='';
    if($device==='Android'){
          $select="select * from push where push_idGoogle='".$register_id."'";
    }else{
           $select="select * from push where push_tokenApple='".$register_id."'";
    }
    $result=mysql_query($select);
    while($row=mysql_fetch_assoc($result)){
        if(empty($row['push_id'])){
            return false;
        }else{
            return true;
        }
    }
}
?>