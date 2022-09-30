
<!--main content start-->
<?php $CI =& get_instance(); ?>
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-9 main-chart">
            <!--CUSTOM CHART START -->
            <div class="border-head">
              <h3>INCOME
              <input type="submit" class="btn btn btn-block btn-flat btn-primary" data-toggle="modal" data-target="#modal-default" value="Opening Balance" style="width:20%; float: right;"></h3>
            </div>
            <div class="modal fade" id="modal-default" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Opening Balance</h4>
                  </div>
                  <form action="<?php echo base_url(); ?>Dashboard/insert_obalance" method="POST">
                    <div class="modal-body">
                      <div class="form-group">
                        <input type="number"  class="form-control" name="balance" placeholder="Enter opening balance...">
                          <div class="row">
                            <div class="col-sm-6" style="margin-top:20px;">
                              <span style="font-weight: 600;">Cash in Hand</span><input type="number"  class="form-control" name="cash" placeholder="Enter cash balance..."> 
                            </div> 
                            <div class="col-sm-6" style="margin-top:20px;">
                              <span style="font-weight: 600;">Cash in Bank</span><input type="number"  class="form-control" name="bank" placeholder="Enter bank balance..."> 
                            </div> 
                          </div> 
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                      <input type="submit" class="btn btn-primary" value="Save">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="custom-bar-chart">
              <ul class="y-axis">
                <li><span>32</span></li>
                <li><span>16</span></li>
                <li><span>8</span></li>
                <li><span>4</span></li>
                <li><span>2</span></li>
                <li><span>0</span></li>
              </ul>
              <div class="bar" style="margin-right: 2%;">
                <div class="title">JAN</div>
                <div class="value tooltips" data-original-title="0" data-toggle="tooltip" data-placement="top">0%</div>
              </div>
              <div class="bar" style="margin: 0px 2%;">
                <div class="title">FEB</div>
                <div class="value tooltips" data-original-title="0" data-toggle="tooltip" data-placement="top">0%</div>
              </div>
              <div class="bar" style="margin: 0px 2%;">
                <div class="title">MAR</div>
                <div class="value tooltips" data-original-title="0" data-toggle="tooltip" data-placement="top">0%</div>
              </div>
              <div class="bar" style="margin: 0px 2%;">
                <div class="title">APR</div>
                <div class="value tooltips" data-original-title="0" data-toggle="tooltip" data-placement="top">0%</div>
              </div>
              <div class="bar" style="margin: 0px 2%;">
                <div class="title">MAY</div>
                <div class="value tooltips" data-original-title="0" data-toggle="tooltip" data-placement="top">0%</div>
              </div>
              <div class="bar" style="margin: 0px 2%;">
                <div class="title">JUN</div>
                <div class="value tooltips" data-original-title="0" data-toggle="tooltip" data-placement="top">0%</div>
              </div>
              <div class="bar" style="margin: 0px 2%;">
                <div class="title">JUL</div>
                <div class="value tooltips" data-original-title="0" data-toggle="tooltip" data-placement="top">0%</div>
              </div>
              <div class="bar" style="margin: 0px 2%;">
                <div class="title">AUG</div>
                <div class="value tooltips" data-original-title="5.500" data-toggle="tooltip" data-placement="top">55%</div>
              </div>
            </div>

        <style>
          .small-box {
              border-radius: 5px;
              box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
              display: block;
              margin-bottom: 20px;
              position: relative;
          }

          .small-box > .inner {
              padding: 10px;
          }

          .col-lg-3 .small-box h3, .col-md-3 .small-box h3, .col-xl-3 .small-box h3 {
              font-size: 25px;
          }

          .small-box h3 {
              font-size: 25px;
              font-weight: 700;
              margin: 0 0 10px;
              padding: 0;
              white-space: nowrap;
          }


          .small-box p {
              font-size: 18px;
          }
p {
    margin-top: 0;
    margin-bottom: 10px;
}
*, ::after, ::before {
    box-sizing: border-box;
}
.small-box > .small-box-footer {
    background-color: rgba(0,0,0,.1);
    color: rgba(255,255,255,.8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    z-index: 10;
}
.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
}

.bg-info, .bg-info > a {
    color: #fff !important;
}
.bg-info {
    background-color: #17a2b8 !important;
}

.bg-success, .bg-success > a {
    color: #fff !important;
}
.bg-success {
    background-color: #28a745 !important;
}
.bg-warning, .bg-warning > a {
    color: #1f2d3d !important;
}
.bg-warning {
    background-color: #ffc107 !important;
}
.bg-danger, .bg-danger > a {
    color: #fff !important;
}
.bg-danger {
    background-color: #dc3545 !important;
}
.bg-pink{
  background-color: #e83e8c !important;
}
.bg-pink, .bg-pink > a {
    color: #1f2d3d !important;
}
.bg-orange, .bg-orange > a {
    color: #fff !important;
}
.bg-orange{
  background-color: #fd7e14 !important;
}
        </style>

      <form action="Dashboard" method="POST">
        <!-- <h4 class="mb" style="font-weight: bold; padding-left: 2%;">PROFIT & LOST REPORT</h4> -->
        <label class="text-right" style="padding-left: 10%; font-weight: bold;">From Date 
          <input type="date" name="from_date" id="from_date" value="" class=""></label>
        <label class="text-right" style="padding-left: 12%; font-weight: bold;">To Date 
          <input type="date" name="to_date" id="to_date" value="" class=""></label>
        <label style="padding-left: 2%;"></label>

          <input class= "btn btn-primary" type="submit" name="submit" value="filter">
      </form><br>

            <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 style="font-size:25px;"><?php echo $total_item_income; ?>.00</h3>

                <p style="font-size:18px;">Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $total_expense; ?>.00</h3>

                <p>Expenses</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $total_purchase; ?>.00</h3>

                <p>Purchase</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>0</h3>

                <p>New Customers</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3><?php echo $orders_total; ?></h3>

                <p>New Orders</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-pink">
              <div class="inner">
                <h3>0</h3>

                <p>New Bookings</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
          </div>
          <!-- /col-lg-9 END SECTION MIDDLE -->
          <!-- **********************************************************************************************************************************************************
              RIGHT SIDEBAR CONTENT
              *********************************************************************************************************************************************************** -->
          <div class="col-lg-3 ds">
            <!-- RECENT ACTIVITIES SECTION -->
            <h4 class="centered mt">RECENT ACTIVITY</h4>
            <?php
              foreach ($recent_orders as $rorder) {
                ?>
                  <!-- First Activity -->
                  <div class="desc">
                    <div class="thumb">
                      <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                    </div>
                    <div class="details">
                      <p>
                        <muted>
                          <?php
                          echo $date = date('Y-m-d h:i:sa', strtotime($rorder->created));
                          ?>
                        </muted>
                        <br/>
                        <a href="<?php base_url() ?>Orders">Bill No -<?php echo $rorder->bill_no; ?> </a><br/>
                      </p>
                    </div>
                  </div>
                <?php
              }
            ?>

            <!-- <div id="calendar" class="mb">
              <div class="panel green-panel no-margin">
                <div class="panel-body">
                  <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                    <div class="arrow"></div>
                    <h3 class="popover-title" style="disadding: none;"></h3>
                    <div id="date-popover-content" class="popover-content"></div>
                  </div>
                  <div id="my-calendar"></div>
                </div>
              </div>
            </div> -->
            <!-- / calendar -->
          </div>
          <!-- /col-lg-3 -->
        </div>
        <!-- /row -->

      </section>
    </section>
    <!--main content end-->
    <!--footer start-->

