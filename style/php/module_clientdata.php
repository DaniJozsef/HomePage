    <div class="white-line">
      <div class="box">
        <div class="container">
          <div class="box-four">
            <div class="element">
              <b><?php __('LocalTimeZone'); ?>:</b>
            </div>
            <div class="element">
              <div id="LocalTimeZone"></div>
            </div>
            <div class="element">
              <b><?php __('LocalDateTime'); ?>:</b>
            </div>
            <div class="element">
              <div id="LocalDateTime"></div>
            </div>
            <div class="element">
              <div id="NameDay"></div>
            </div>
          </div>
          <div class="box-four">
            <div class="element ">
              <div class="tooltip" title="<?php __('BissextileTooltip'); ?>">
                <img class="footer-small-icons" src="style/icons/gray/16x16/help_icon.gif" />
                <b><?php echo date('Y') . ' ' . __('BissextileThis', TRUE); ?>:</b>
              </div>
            </div>
            <div class="element">
              <div id="bissextile"></div>
            </div>
            <div class="element">
              <b><?php __('OS'); ?>:</b>
            </div>
            <div class="element">
              <?php echo GetOS(); ?>
            </div>
          </div>
          <div class="box-four box-twoclear">
            <div class="element">
              <b><?php __('RealAgent'); ?>:</b>
            </div>
            <div class="element">
               <?php 
                $GetBrowser = GetBrowser(); 
                $BrowserImage = dirname(__FILE__) . '/../img/' . $GetBrowser["Name"] . '.png';
                $BrowserIcon = file_exists($BrowserImage) ? $GetBrowser["Name"] : 'traveler';
                $BrowserIcon = '<img width="16" src="/style/img/' . $BrowserIcon . '.png" border="0" />';
                echo $BrowserIcon. ' ' . $GetBrowser["Name"] . '<br /><b>' . __('Version', TRUE) . ':</b> ' . $GetBrowser["Version"];
              ?>
            </div>
            <div class="element">
              <b><?php __('IPAddress'); ?>: </b><?php echo GetIP(); ?>
            </div>
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
          <div class="box-four">
            <div class="element">
              <?php echo GetAgent(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>