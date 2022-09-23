<?php
    require_once('db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    date_default_timezone_set('Asia/Colombo');
    // $currentDate=date('Y-m-d');
    // $currentDate=date('Y-m-d H:i:s');


    if (isset($_SESSION['Logged']) && $_SESSION['Logged'] == true) 
    {

      $user_email = $_SESSION["email"];

      $getEmpQuery=$conn->query("SELECT user_id,name,email,role FROM users_login WHERE email='$user_email' ");
      while ($emp=$getEmpQuery->fetch_array()) {

        $user_id = $emp['0']; 
        $user_name = $emp['1']; 
        $user_email = $emp['2']; 
        $user_role = $emp['3']; 
        

      }
      
    }

    else
    {
        ?>

            <script type="text/javascript">
                window.location.href="login";
            </script>

        <?php
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link href="assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
    <?php include_once('controls/meta.php'); ?>
</head>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <?php include_once('controls/side_nav.php'); ?>

        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <div class="app-header">
                <?php include_once('controls/top_nav.php'); ?>
            </div>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="card todo-container">
                                    <div class="row">
                                        <div class="col-xl-4 col-xxl-3">
                                            <div class="todo-menu">

                                                <h5 class="todo-menu-title">Add Status</h5>
                                               <!--  <ul class="list-unstyled todo-status-filter">
                                                    <li><a href="#" class="active"><i class="material-icons-outlined">format_list_bulleted</i>All</a></li>
                                                    <li><a href="#"><i class="material-icons-outlined">done</i>Completed</a></li>
                                                    <li><a href="#"><i class="material-icons-outlined">pending</i>In Progress</a></li>
                                                    <li><a href="#"><i class="material-icons-outlined">delete</i>Deleted</a></li>
                                                </ul> -->
                                                <form id="Add-Todo" method="POST">
                                                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                                    <input type="text" name="subject" placeholder="Subject" class="form-control form-control-solid m-b-lg">
                                                    <textarea name="todo_message" class="form-control form-control-solid m-b-lg" placeholder="Message"></textarea>

                                                    <button type="submit" class="btn btn-primary d-block m-b-lg" style="width: -webkit-fill-available;" id="btn-add-todo">Create new</button>
                                                </form>
                                                
                                                
                                                <!-- <h5 class="todo-menu-title">Search</h5>
                                                <input type="text" class="form-control form-control-solid m-b-lg" placeholder="Type here.."> -->

                                                <!-- <h5 class="todo-menu-title">Labels</h5>
                                                <div class="todo-label-filter m-b-lg">
                                                    <a href="#" class="badge badge-style-light rounded-pill badge-light">general</a>
                                                    <a href="#" class="badge badge-style-light rounded-pill badge-primary">work</a>
                                                    <a href="#" class="badge badge-style-light rounded-pill badge-secondary">family</a>
                                                    <a href="#" class="badge badge-style-light rounded-pill badge-danger">education</a>
                                                    <a href="#" class="badge badge-style-light rounded-pill badge-info">side projects</a>
                                                    <a href="#" class="badge badge-style-light rounded-pill badge-success">personal</a>
                                                    <a href="#" class="badge badge-style-light rounded-pill badge-warning">other</a>
                                                </div> -->
                                                <!-- <h5 class="todo-menu-title">Preferences</h5>
                                                <div class="todo-preferences-filter">
                                                    <div class="todo-preferences-item">
                                                        <input class="form-check-input" type="checkbox" value="" id="createdByMeCheck">
                                                        <label class="form-check-label" for="createdByMeCheck">
                                                            Created by me
                                                        </label>
                                                    </div>
                                                    <div class="todo-preferences-item">
                                                        <input class="form-check-input" type="checkbox" value="" id="withoutDeadlineCheck">
                                                        <label class="form-check-label" for="withoutDeadlineCheck">
                                                            Without deadline
                                                        </label>
                                                    </div>
                                                    <div class="todo-preferences-item">
                                                        <input class="form-check-input" type="checkbox" value="" id="highPriorityCheck" checked>
                                                        <label class="form-check-label" for="highPriorityCheck">
                                                            High priority
                                                        </label>
                                                    </div>
                                                    <div class="todo-preferences-item">
                                                        <input class="form-check-input" type="checkbox" value="" id="recentActivity">
                                                        <label class="form-check-label" for="recentActivity">
                                                            Recent activity
                                                        </label>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-xxl-9">
                                            <div class="todo-list">
                                                <ul class="list-unstyled" id="todo-area">
                                                    <?php
                                                        $sql = "SELECT * FROM todo WHERE user_id='$user_id' ORDER BY todo_id DESC";
                                                        $rs=$conn->query($sql);
                                                        while($row =$rs->fetch_array())
                                                        {
                                                            $TodoId =$row[0];
                                                            $TodoUserId=$row[1];
                                                            $TodoSubject=$row[2];
                                                            $TodoMessage=nl2br($row[3]);
                                                            $TodoDatetime=$row[4];

                                                    ?>
                                                    <li class="todo-item">
                                                        <div class="todo-item-content">
                                                            <span class="todo-item-title"><?php echo $TodoSubject; ?><span class="badge badge-style-light rounded-pill badge-warning">other</span></span>
                                                            <span class="todo-item-subtitle"><?php echo nl2br($TodoMessage); ?></span>
                                                        </div>
                                                        <div class="todo-item-actions">
                                                            <a href="#" class="todo-item-delete"><i class="material-icons-outlined no-m">close</i></a>
                                                            <!-- <a href="#" class="todo-item-done"><i class="material-icons-outlined no-m">done</i></a> -->
                                                        </div>
                                                    </li>
                                                    <?php } ?>
                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


        <!-------Event Start------------>
        <div class="alert alert-success solid alert-dismissible fade" role="alert" id="success_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-check"></i> <strong>Success!</strong> <span id="success_msg"></span>
        </div>
        <!--------Event End----------->
                            
        <!-------Waiting  Upload Event Start------------>
        <div class="alert alert-warning solid alert-dismissible fade" role="alert" id="progress_upload_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> <strong>Please Wait...</strong>
            <div class="progress" style="height:20px">
                <div class="progress-bar bg-success" style="width:0%;" id="upload-bar"><span id="upload-bar-label">0%</span></div>
            </div>
        </div>
        <!--------Waiting Upload  Event End----------->                   
                            
        <!-------Waiting Event Start------------>
        <div class="alert alert-warning solid alert-dismissible fade" role="alert" id="progress_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-circle-o-notch fa-spin fa-fw"></i><span class="sr-only">Loading...</span> <strong>Please Wait...</strong>
        </div>
        <!--------Waiting Event End----------->
                            
        <!-------Error Event Start------------>
        <div class="alert alert-danger solid alert-dismissible fade" role="alert" id="danger_alert" style="position:fixed;bottom:20px;right:20px">
          <i class="fa fa-times"></i> <strong>Error!</strong> <span>Something went wrong...</span>
        </div>
        <!--------Error Event End----------->


    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>

    <script>
        
        $(document).on('submit', '#Add-Todo', function(e){
        e.preventDefault(); //stop default form submission

        $("#btn-add-todo").attr("disabled",true);

        var formData = new FormData($(this)[0]);

        $.ajax({
            
            
                beforeSend : function() {
                    $("#progress_alert").addClass('show'); 

                },

                url:"post/add_todo.php",
                type: 'POST',
                data: formData,
                //async: false,
                cache: false,
                contentType: false,
                processData: false,

                success: function (data) {
                    
                    $("#progress_alert").removeClass('show');
                    
                    var json=JSON.parse(data);
                    
                    if(json.result){

                       $("#todo-area").html(json.data);
                       $("#success_msg").html(json.msg);
                       $("#success_alert").addClass('show'); 
                       
                       setTimeout(function(){$("#success_alert").removeClass('show');  }, 1000);
                       $("#btn-add-todo").attr("disabled",false);
                        
                    }else{
                        $("#danger_alert").addClass('show');
                        setTimeout(function(){ $("#danger_alert").removeClass('show'); }, 1000);
                        $("#btn-add-todo").attr("disabled",false);
                     
                    }
                    
                }

            });

        return false;
        });
    </script>

</body>

</html>