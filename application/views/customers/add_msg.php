
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper site-min-height">
        <h3>Add New Message</h3>
        <div class="row mt">
            <div class="col-lg-12">
            <!-- page end-->
            </div>
          </div>
        </div>
        <form action="<?php echo base_url(); ?>Customers/insert_msg" method="post">
        <div style="width: 90%; margin: auto;">
          <?php //echo $sql;?>
          <div style="margin-bottom: 10px;">
          <textarea id="msg" placeholder="Type your Text here..." class="form-control" id="msg" name="msg" rows="5" maxlength="350"></textarea>
            
          </div>
          <div>
            <input type="submit" name="submit" value="Save" class="btn btn-success">
          </div>
        </div>
        </form>

        <div class="container">
            <h2>Default Messages</h2>
            <p>Do actions on your Messages</p>            
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                    $i =1;
                    foreach ($default_msg as $msg){
                      ?>
                        <tr class="gradeX">
                          <td><?php echo $i; ?></td>
                          <td><?php echo $msg->msg; ?></td>
                          <td><a href="<?php echo base_url(); ?>Customers/delete_msg/<?php echo $msg->msg_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a></td>
                        </tr>
                      <?php
                      $i++;
                    }
                ?>
              </tbody>
            </table>
          </div>
      </section>
      
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
    <!--footer start-->
    <?php require 'footer.php'; ?>
    <!--footer end-->
  </section>