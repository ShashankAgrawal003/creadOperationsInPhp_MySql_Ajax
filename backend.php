<?php
$conn=mysqli_connect('localhost','root',"",'crudoperations');
extract($_POST);
if(isset($_POST['readrecord'])){
    $data='<table class="table table-bordered table-striped">
    <tr>
    <th>No.</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email Address</th>
    <th>Mobile Number</th>
    <th>Edit Action</th>
    <th>Delete Action</th></tr>';
    $displayquery="Select * from `crudtable`";
    $result=mysqli_query($conn,$displayquery);
    if(mysqli_num_rows($result)>0){
        $number=1;
        while($row=mysqli_fetch_array($result)){  // remember concat here ye backend se aarha hai
         $data .='<tr>
            <td>'.$number.'</td> 
            <td>'.$row['firstname'].'</td>
            <td>'.$row['lastname'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['mobile'].'</td>
            <td> <button onclick="getUserDetails('.$row['id'].')"
            class="btn btn-warning">Edit</button>
            </td>
            <td><button onclick="DeleteUser('.$row['id'].')" 
            class="btn btn-danger">Delete</button>
            </td>
            </tr>';
            $number++;

        }
    }
    $data.='</table>';
    echo $data;

    
}
if(isset($_POST['firstname']) && isset($_POST['lastname'])&& isset($_POST['email'])&&isset($_POST['mobile'])){
    $query="INSERT INTO `crudtable` (`firstname`, `lastname`, `email`, `mobile`) 
    VALUES ('$firstname','$lastname','$email','$mobile')";
    mysqli_query($conn,$query);

}

if(isset($_POST['deleteid'])){
    $userid=$_POST['deleteid'];
    $deletequery="delete from crudtable where id='$userid'";
    mysqli_query($conn,$deletequery);
}

// get userID for update.
if(isset($_POST['id'])&& isset($_POST['id'])!=""){
    $user_id=$_POST['id'];
    $query="Select * from crudtable where
    id='$user_id'";
    if(!$result=mysqli_query($conn,$query)){

        exit(mysqli_error());
    }
    $response=array(); // by default bhi array mein hi ata
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $response=$row;                        //array mein sab data jo edit pe dekhni hai stored
        }
    }
    else{
        $response['status']=200;
        $response['message']="Data not found!";
    }
    echo json_encode($response); // array obj ko json obj mein convert sended from here.
    }   
    else{ $response['status']=200;
        $response['message']="Invalid Request!";

    }

// update table

if(isset($_POST['hidden_user_idupd'])){
            $hidden_user_idupd=$_POST['hidden_user_idupd'];
            $firstnameupd=$_POST['firstnameupd'];
            $lastnameupd=$_POST['lastnameupd'];
            $emailupd=$_POST['emailupd'];
            $mobileupd=$_POST['mobileupd'];
            $query="UPDATE `crudtable` SET `firstname`
            ='$firstnameupd',`lastname`='$lastnameupd',`email`='$emailupd',
            `mobile`='$mobileupd' WHERE id='$hidden_user_idupd'";
            $query1="UPDATE `crudtable` SET `id`='$hidden_user_idupd',`firstname`='$firstnameupd',`lastname`='$lastnameupd',`email`='$emailupd',`mobile`='$mobileupd' where id='$hidden_user_idupd'";
            mysqli_query($conn,$query1);


}


?>