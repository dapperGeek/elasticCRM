<?php
/**
 * Created by PhpStorm.
 * User: Uthman A. Bakar
 * Date: 26-Feb-20
 * Time: 9:48 AM
 */
?>
<div class="row">

    <div class="container-fluid">
        <!-- begin col-3 -->
        <div class="col-lg-3">

            <div class="widget red-bg box-shadow">

                <div class="row">
                    <div class="col-xs-4 text-center">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span>NC</span>

                        <h2 class="font-bold"><?php $database->getAllContractsByNC();?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- begin col-3 -->
        <div class="col-lg-3">
            <div class="widget aqua-bg box-shadow">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-database fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> FMSA </span>

                        <h2 class="font-bold"><?php $database->getAllContractsByFMSA();?></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- begin col-3 -->
        <div class="col-lg-3">
            <div class="widget aqua-bg box-shadow">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-line-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> AMC </span>

                        <h2 class="font-bold"><?php $database->getAllContractsByAMC();?></h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- begin col-3 -->
        <div class="col-lg-3">
            <div class="widget red-bg box-shadow">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span>MPS</span>

                        <h2 class="font-bold"><?php $database->getAllContractsByMPS();?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

