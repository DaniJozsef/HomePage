    <div class="white-line">
      <div class="box">
        <div class="container">
          <div class="box-four">
            <div class="element">
              <b>Timezone</b>
            </div>
            <div class="element">
              Local/UTC
            </div>
          </div>
          <div class="box-four">
            <div class="element">
              <b><?php __('IPAddress'); ?>:</b>
            </div>
            <div class="element">
              <?php echo GetIP(); ?>
            </div>
          </div>
          <div class="box-four box-twoclear">
            <div class="element">
              <b><?php __('RealAgent'); ?>:</b>
            </div>
            <div class="element">
              <?php echo GetAgent(); ?>
            </div>
          </div>
          <div class="box-four">
            <div class="element">
              <b><?php __('DeviceDetect'); ?>:</b>
            </div>
            <div class="element">
              <?php
                $MobileDetect = new Mobile_Detect;
                echo ($MobileDetect->isMobile() ? ($MobileDetect->isTablet() ? $Lang['MobileTablet'] : $Lang['MobilePhone']) : $Lang['MobileComputer']);
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>