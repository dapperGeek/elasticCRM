<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. B.
 * Date: 10/3/2019
 * Time: 11:45 AM
 */

include_once ('../includes/header.php');

<<<<<<< HEAD
    if ($myData['designation'] == 'IT/Software Developer'){
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $user = $database->getUser($id);
            ?>
            <h2><?php echo $user->fullname ; ?></h2>

            <div class="col-lg-6 top20 bottom20">

                <div class="borderedTable">

                    <table>
                        <tr>
                            <td>
                            <span class="pull-left">
                                Department :
                            </span>
                            </td>
                            <td>
                            <span class="pull-left">
                                <?php echo $user->Department ?>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span class="pull-left">
                                Position :
                            </span>
                            </td>
                            <td>
                            <span class="pull-left">
                                <?php echo $user->designation ?>
                            </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                            <td>
                                <span class="pull-left"></span>
                            </td>
                        </tr>
                    </table>

                </div>

            </div>

            <div class="col-lg-6 top20 bottom20">
                <div class="borderedTable">
                    <h3>Update Password</h3><br>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $id ?>">
                        <div class="form-group">
                            <?php
                            if(isset($ps_msg)){
                                echo "<p style='color:green;'>".$ps_msg."</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <input required="" name="password" placeholder="Enter Password" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <input name="update-pass" class="btn btn-primary btn-block" type="submit" value="Update Password">
                        </div>
                    </form>
                </div>
            </div>
            <?php

        }
        else{
            $allUsers = $database->getAllUsers();
            ?>

            <section>
                <!--for demo wrap-->
                <h1>All Staff Members</h1>

                <!--           <a href="--><?php ////echo $host . 'users/db/ops' ?><!--">Update Users queries</a>-->

                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <thead>
                        <tr>
                            <th width="30%">Name</th>
                            <th width="25%">Department</th>
                            <th>Position</th>
                            <th>Change</th>
                            <th>Change %</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                        <?php
                        foreach ($allUsers as $user){
                            ?>
                            <tr>
                                <td width="30%">
                                    <a href="<?php echo $host . 'users/' . $user->id ?>">
                                        <?php echo $user->fullname ?>
                                    </a>
                                </td>
                                <td width="30%"><?php echo $user->Department ?></td>
                                <td width="30%"><?php echo $user->designation ?></td>
                                <td width="30%"><?php //echo $user->fullname ?></td>
                                <td width="30%"><?php //echo $user->fullname ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </section>

            <?php
        }     
    }
=======
   if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $user = $database->getUser($id);
?>
        <h2><?php echo $user->fullname ; ?></h2>

        <div class="col-lg-6 top20 bottom20">

            <div class="borderedTable">

                <table>
                    <tr>
                        <td>
                            <span class="pull-left">
                                Department :
                            </span>
                        </td>
                        <td>
                            <span class="pull-left">
                                <?php echo $user->Department ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left">
                                Position :
                            </span>
                        </td>
                        <td>
                            <span class="pull-left">
                                <?php echo $user->designation ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                        <td>
                            <span class="pull-left"></span>
                        </td>
                    </tr>
                </table>

            </div>

        </div>

       <div class="col-lg-6 top20 bottom20">
           <div class="borderedTable">
               <h3>Update Password</h3><br>
               <form method="post">
                   <input type="hidden" name="id" value="<?php echo $id ?>">
                   <div class="form-group">
                       <?php
                           if(isset($ps_msg)){
                               echo "<p style='color:green;'>".$ps_msg."</p>";
                           }
                       ?>
                   </div>
                   <div class="form-group">
                       <input required="" name="password" placeholder="Enter Password" class="form-control" type="text">
                   </div>

                   <div class="form-group">
                       <input name="update-pass" class="btn btn-primary btn-block" type="submit" value="Update Password">
                   </div>
               </form>
           </div>
       </div>
<?php

    }
    elseif (isset($_GET['db'])){
        $database->updatePasswords();
    }
   else{
       $allUsers = $database->getAllUsers();
       ?>

       <section>
           <!--for demo wrap-->
           <h1>All Staff Members</h1>

<!--           <a href="--><?php ////echo $host . 'users/db/ops' ?><!--">Update Users queries</a>-->

           <div class="tbl-header">
               <table cellpadding="0" cellspacing="0" border="0">
                   <thead>
                   <tr>
                       <th width="30%">Name</th>
                       <th width="25%">Department</th>
                       <th>Position</th>
                       <th>Change</th>
                       <th>Change %</th>
                   </tr>
                   </thead>
               </table>
           </div>
           <div class="tbl-content">
               <table cellpadding="0" cellspacing="0" border="0">
                   <tbody>
                   <?php
                   foreach ($allUsers as $user){
                       ?>
                       <tr>
                           <td width="30%">
                               <a href="<?php echo $host . 'users/' . $user->id ?>">
                                   <?php echo $user->fullname ?>
                               </a>
                           </td>
                           <td width="30%"><?php echo $user->Department ?></td>
                           <td width="30%"><?php echo $user->designation ?></td>
                           <td width="30%"><?php //echo $user->fullname ?></td>
                           <td width="30%"><?php //echo $user->fullname ?></td>
                       </tr>
                       <?php
                   }
                   ?>
                   </tbody>
               </table>
           </div>

       </section>

       <?php
   }
>>>>>>> 48136f1b63a2e7fb659fed72c5bf93f60ec79592

include_once ('../includes/footer.php');



