<?php 
  $IsLogin = GetLogin();
  if(!$IsLogin){
    include('module_login.php');
  }else{
    /**/ 
  }
?>

    <div class="green-line" id="userdatas">
      <div class="box">
        <div class="container">
          <div class="box-four">
            &nbsp;
          </div>
          <div class="box-four">
            &nbsp;
          </div>
          <div class="box-two box-twoclear">
            <b><?php __('UserDatasName'); ?>:</b> <span id="userdatas_name"></span><br />
            <b><?php __('UserDatasEmail'); ?>:</b> <span id="userdatas_email"></span><br />
            <b><?php __('UserDatasLastlog'); ?>:</b> <span id="userdatas_lastlog"></span><br />
            <b><?php __('UserDatasLogincount'); ?>:</b> <span id="userdatas_logincount"></span><br />
            <a class="alogin" href="/logout"><?php __('Logout'); ?></a>
          </div>
        </div>
      </div>
    </div>
    
<?php if($IsLogin){ ?>
    <div class="white-line">
      <div class="box">
        <div class="container">
          <?php include('module_torrentlist.php'); ?>
        </div>
       </div>
     </div>  
<?php } ?>