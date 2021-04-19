<?php  include 'config.php';
if(isset($_GET['verify']))
{   
    $tableName = "customer";
    $colunmName = '*';
    $whereValue["access_token"] = base64_decode($_GET['verify']);
    $data = $coreModel->selectData($colunmName, $tableName, $whereValue);

    $past = $data[0]['time_diff'];
    $time = date("Y-m-d H:i:s",strtotime($past." +20 minutes"));
    $now = date("Y-m-d H:i:s");

    if ($now < $time) 
    {
        $columnValue['status'] = 'Active';
        $queryResult = $coreModel->updateData($tableName, $columnValue, @$whereValue);
        $_SESSION['cust_id'] =   $data[0]['customer_id'];
        $_SESSION['cust_name'] = $data[0]['cust_name'];
        $_SESSION['mgs'] ='
                    <div class="alert alert-success fade in col-md-6 col-md-offset-3">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         Your have successfully verified your account!
                    </div>
                    ';
        header("Location:index.php");
    }
    else
    {
        $_SESSION['mgs'] = '
                    <div class="alert alert-danger fade in col-md-6 col-md-offset-3">
                        <button type="button" class="close close-sm" data-dismiss="alert">
                            <i class="fa fa-times"></i></button>
                         Your password reset link expired!
                    </div>
                    ';
        header("Location:index.php");

    }
}
?>