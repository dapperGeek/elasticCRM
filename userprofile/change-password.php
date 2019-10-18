<?php
/**
 * Created by PhpStorm.
 * User: BAKAR U.A.
 * Date: 16-Oct-19
 * Time: 11:08 AM
 */

    include_once ('../includes/header.php');
?>

    <h2>Change Your Password</h2>

    <form method="post" name="edit_password" class="form-horizontal">

        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
                <?php if($err!= ""){$database->showMsg('Error',$err,1);}
                else if($msg!=""){
                    header("Refresh:5; url=logout.php");
                    $database->showMsg('Success',$msg,2);}?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Old password:</label>
            <div class="col-sm-6">
                <input type="password" value="" name="txtpass1" placeholder="Enter old password"
                       required class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">New Password:</label>
            <div class="col-sm-6">
                <input type="password" value="" name="txtpass2" placeholder="Enter new password"
                       required class="form-control" id="txtpass2">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Re-enter password</label>
            <div class="col-sm-6">
                <input type="password" value="" name="txtpass3" placeholder="Re-enter new password"
                       required class="form-control" id="txtpass3">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-6">
                <button name="btnEditPassword" class="btn btn-primary col-lg-12" type="submit">Edit Password</button>

            </div>
        </div>


    </form>

<?php
    include_once ('../includes/footer.php');