  <?php
    require_once('../db/database.php');
    $db=new DB();
    $conn=$db->connect();
    session_start();
    $output=[];
    //$today=date('Y-m-d');


    $output=[]; 
    $datalist=array();
    $AdvisorList = array();
    $AdvisorClientCountList = array();

    if(isset($_POST['advisor_start_date']) && isset($_POST['advisor_end_date'])){

        $advisor_start_date=htmlspecialchars($_POST['advisor_start_date']);
        $advisor_end_date=htmlspecialchars($_POST['advisor_end_date']);

        // $sql ="SELECT user_name, COUNT(*) FROM tbl_vehicle_details GROUP BY user_name ORDER BY COUNT(*) DESC ";
        $query="SELECT register_user_id, COUNT(*) FROM client_details WHERE DATE(client_datetime) BETWEEN '$advisor_start_date' AND '$advisor_end_date' GROUP BY register_user_id ORDER BY COUNT(*) DESC";
        $getServiceAdvisor=$conn->query($query);
        while ($gsa=$getServiceAdvisor->fetch_array()) {

          $AdvisorNameID=$gsa[0];
          

          $getUserName = $conn->query("SELECT * FROM users_login WHERE user_id = '$AdvisorNameID'");
            if($gun = $getUserName->fetch_array()){

                $AdvisorName=$gun[1];

                array_push($AdvisorList,$AdvisorName);

            }

                $AdvisorClientCount=$gsa[1];
                array_push($AdvisorClientCountList,$AdvisorClientCount);

            



          
      $obj=' 
            <tr>
                <td>'.$AdvisorName.'</td> 
                <td>'.$AdvisorClientCount.'</td>
            </tr>

          ';

          array_push($datalist,$obj);



      
    
    }

    $output['result']=true;
    $output['data']=$datalist;
    

    $output['advisorList'] = $AdvisorList;
    $output['advisorClientCountList'] = $AdvisorClientCountList;




    }else{
        $output['result']=false;
        $output['data']="Invalid request.";
    }






   


    echo json_encode($output);
    
    
    