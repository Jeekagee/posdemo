<aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="profile.html"><img src="<?php echo base_url(); ?>assets/img/aclogo.png" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $username; ?></h5>

          <li class="mt">
            <a href="<?php echo base_url(); ?>Dashboard">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>

          <?php
            $user_level = $this->session->user_level;
            $CI =& get_instance();
            //user_level menu id
            $main_menu = $CI->Dashboard_model->menu($user_level);

            foreach ($main_menu as $menu) {
              $menu_id = $menu->menu_id;
              $main_menu_data = $CI->Dashboard_model->main_menu($menu_id);
              
              if ($main_menu_data->menu_name === $nav) {
                $navactive = "active";
              }
              else{
                $navactive = "";
              }

              ?>
                <li class="sub-menu">
                  <a class="<?php echo $navactive; ?>" href="javascript:;">
                    <i class="<?php echo $main_menu_data->menu_icon; ?>"></i>
                    <span><?php echo $main_menu_data->menu_name; ?></span>
                    </a>
                      <ul class="sub">
                      <?php
                        $sub_menu = $CI->Dashboard_model->sub_menu($user_level,$menu_id);
                        foreach ($sub_menu as $s_menu) {
                          $sub_menu_id = $s_menu->sub_menu_id;
                          $sub_menu_data = $CI->Dashboard_model->sub_menu_data($sub_menu_id);

                            if ($sub_menu_data->name === $subnav) {
                              $subactive = "active";
                            }
                            else{
                              $subactive = "";
                            }
                          ?>
                            <li class="<?php echo $subactive; ?>">
                              <a href="<?php echo base_url().$sub_menu_data->url; ?>">
                                <i class="<?php echo $sub_menu_data->icon; ?>"></i> 
                                <span><?php echo $sub_menu_data->name; ?></span>
                              </a>
                            </li>
                          <?php
                        }
                      ?>
                    </ul>
                </li>
              <?php
            }
          ?>
        </ul>
        <!-- sidebar menu end-->
      </div>
</aside>