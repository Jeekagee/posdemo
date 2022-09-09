
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Message</h3>
        <div class="row mb">
          <!-- page start-->
          <form action="<?php echo base_url(); ?>Customers/Send_msg" method="post">
          <div class="content-panel" style="padding:20px 20px 2px 20px;">
            <div class="adv-table">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center" width="100">
                        <input type="checkbox" id="select_all"> All
                    </th>
                    <th>#</th>
                    <th>Customer Name</th>
                    <th>Contact Number</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($customers as $customer){
                    ?>
                      <tr class="gradeX">
                        <td class="text-center">
                                <input type="checkbox" name="check[]" value="<?php echo $customer->mobile; ?>">
                        </td>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $customer->fname; ?></td>
                        <td><?php echo $customer->mobile; ?></td>
                      </tr>
                    <?php
                    $i++;
                  }
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- page end-->
        </div>
        <!-- /row -->
      </section>

      <section style="margin-bottom:20px;">
        <div style="width: 90%; margin: auto;">
          <div>
            
          </div>
          <div style="margin-bottom: 10px;" class="row">
              <div>
                    <?php
                      if ($this->session->flashdata('sent_msg')) {
                        echo $this->session->flashdata('sent_msg');
                      }
                    ?>
              </div>
          	<div class="col-md-10">
              
          		<select class="form-control" onchange="default()">
	          		<option value="">Select Your Default Messages</option>
	          		<?php 
                  foreach ($default_msg as $msg){
                     echo  "<option value='$msg->msg'>$msg->msg</option>";
                  }
                ?>
	          	</select>
          	</div>
          	<div class="col-md-2">
          		<a href="<?php echo base_url(); ?>Customers/Add_msg" class="btn btn-primary">Add More</a>
          	</div>
          	
          </div>
            <textarea id="msg" placeholder="Type your Text here..." class="form-control" id="msg" name="msg" rows="5" maxlength="350"></textarea>
            <div style="margin-top:10px;">
              <input class="btn btn-success pull-right" type="submit" name="send" value="Send Message">
              
          </form>
            <button onclick="clear_txt()" class="btn btn-danger">Clear</button>
          </div>
          
        </div>
      </section>
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  