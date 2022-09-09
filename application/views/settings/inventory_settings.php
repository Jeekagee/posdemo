
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Setup Inventory for Service</h3>
        
        <div class="row mb">
        <div class="col-md-3"></div>
            <div class="col-lg-6">
                <div class="form-panel">
                        <h4 class="mb">Select Items for Services</h4>
                        <div id="delete_msg">
                        <?php
                            if ($this->session->flashdata('msg')) {
                            echo $this->session->flashdata('msg');
                            }
                        ?>
                        </div>
                        <div class="form-horizontal style-form">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Select Service</label>
                                <div class="col-sm-8">
                                    <select name="service" id="service" class="form-control">
                                        <option value="">Select Service</option>
                                        <?php
                                        foreach ($services as $service) {
                                            echo "<option value='$service->service_id'>$service->service</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div id="service_items">
                                        
                            </div>
                                            
                        </div>
                </div>
                </form>
            </div>
        <div class="col-md-3"></div>
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  