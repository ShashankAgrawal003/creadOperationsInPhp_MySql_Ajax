<!DOCTYPE html>
<html>

<head>
    <title>Cread Operation with PHP, Mysql using Ajax call.
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    

</head>
<body> 
    <div class="container">
        <h1 class="text-center text-primary">AJAX CRUD OPERATION WITH PHP AND MYSQL</h1>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="emptyModel()">Open modal</button>
        </div>
        <h2>All Records</h2>
        <div id="records_contant">
        </div>
        <!-- modal-->
        <div class="modal fade" id="myModal"> 
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">AJAX CRUD OPERATION</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="firstname">Firstname:-</label>
                            <input type="text" name="firstname" id="firstname" class="form-control"
                                placeholder="First Name">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Lastname:-</label>
                            <input type="text" name="lastname" id="lastname" class="form-control"
                                placeholder="Last Name">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Id:-</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="mobile">Mobile:-</label>
                            <input type="text" name="mobile" id="mobile" class="form-control"
                                placeholder="Mobile Number">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal"
                            onclick="addRecord()">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>



                </div>
            </div>
        </div>
        <!-- update -->

        <div class="modal fade" id="update_user_modal">
            <div class="modal-dialog">
                <div class="modal-content">


                    <div class="modal-header">
                        <h4 class="modal-title">AJAX CRUD OPERATION</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update_firstname">update_Firstname:-</label>
                            <input type="text" id="update_firstname" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="update_lastname">update_Lastname:-</label>
                            <input type="text" id="update_lastname" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="update_email">update_Email address:-</label>
                            <input type="email" id="update_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="update_mobile">update_Mobile:-</label>
                            <input type="text" id="update_mobile" class="form-control">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal"
                            onclick="updateuserdetail()">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <!-- extra input field to know which id is to be updated -->
                        <input type="hidden" name="" id="hidden_user_id">
                        
                    </div>



                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() { // page pura hote hi table dekh jaye sab pahle
        readRecords();
    });
    function emptyModel(){
        // $('#myModal').html("");
        $('#firstname').val()="";
        $('#lastname').val()="";
        $('#email').val()="";
        $('#mobile').val()="";
    }

    function readRecords() {       // addrecords ka success
                                     
        var readrecord = "";
        $.ajax({
            url: "backend.php",   // or form.attr("action")
            type: "POST",
            data: {
                readrecord: readrecord,
            },
            success: function(data, status) {
                $('#records_contant').html(data);
            }
        });

    }

    function addRecord() {


        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var mobile = $('#mobile').val();
        $.ajax({
            url: "backend.php", // where to send
            type: 'post', // method of sending
            data: { // what to send
                firstname: firstname,
                lastname: lastname,
                email: email,
                mobile: mobile
            },
            success: function(data, status) {
                readRecords();
            },
            error: function(e) {
                console.log(e.message);
            }
        });
    }

    // delete user
    function DeleteUser(deleteid) {
        var conf = confirm("Are you sure, You want to delete this "+deleteid);
        if (conf == true) {
            $.ajax({
                url: 'backend.php',
                type: 'post',
                data: {
                    deleteid: deleteid,    // delete id send krdega
                },
                success: function(data, status) {
                    readRecords();
                }
            });
        }

    }

    function getUserDetails(id) {
        $('#hidden_user_id').val(id);
        $.post("backend.php", {
            id: id,
        }, function(data, status) {
            var user = JSON.parse(data); // json readed which come from $response ko javascript object mein changed.
            $('#update_firstname').val(user.firstname);  
            $('#update_lastname').val(user.lastname);
            $('#update_email').val(user.email);
            $('#update_mobile').val(user.mobile);
            $('#update_user_modal').modal("show");
        });
       
    }

    function updateuserdetail() {
        var firstnameupd = $('#update_firstname').val();
        var lastnameupd = $('#update_lastname').val();
        var emailupd = $('#update_email').val();
        var mobileupd = $('#update_mobile').val();
        var hidden_user_idupd = $('#hidden_user_id').val();

        $.post("backend.php", {
                hidden_user_idupd: hidden_user_idupd,
                firstnameupd: firstnameupd,
                lastnameupd: lastnameupd,
                emailupd: emailupd,
                mobileupd: mobileupd,
            },
            function(data, status) {
                $('#update_user_model').modal("hide");
                readRecords();
            });
    }
    </script>
</body>

</html>