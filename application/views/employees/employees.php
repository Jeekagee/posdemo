
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Employees</h3>
        <div id="delete_msg">
          <?php
            if ($this->session->flashdata('delete')) {
              echo $this->session->flashdata('delete');
            }
          ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Employees/Add" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
        <div class="row mb">
            
          <!-- page start-->
          <div class="content-panel" style="padding:20px 20px 2px 20px;">
            <div class="adv-table">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Salary(LKR)</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($employees as $employee){
                    ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $employee->emp_id; ?></td>
                        <td><?php echo $employee->emp_name; ?></td>
                        <td><?php echo $employee->emp_salary; ?></td>
                        <td>
                        <?php
                        if ($employee->status == 1) {
                            echo "<span class='label label-success'>Active</span>";
                        }
                        else{
                            echo "<span class='label label-warning'>Inactive</span>";
                        }
                        ?>
                        
                        </td>
                        <td class="text-center">
                          <?php
                          if ($employee->status == 1) {
                              ?>
                                <a href="<?php echo base_url(); ?>Employees/inactive/<?php echo $employee->id; ?>" class="btn btn-warning btn-xs">Inactive</a>
                              <?php
                          }
                          else{
                              ?>
                                <a href="<?php echo base_url(); ?>Employees/active/<?php echo $employee->id; ?>" class="btn btn-success btn-xs">Active</a>
                              <?php
                          }
                          ?>
                          <a href="<?php echo base_url(); ?>Employees/edit/<?php echo $employee->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                          <a href="<?php echo base_url(); ?>Employees/delete/<?php echo $employee->id; ?>/<?php echo $employee->emp_name; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                          
                        </td>
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
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  