    <div class="white-line">
      <!-- +BOX THREE-->
      <div class="box">
        <span class="green-title"><?php __('TimestampDecoder'); ?></span><br /><br />
        <div class="container">
          <div class="box-three">
            <input type="textbox" class="tstamp-input" value="<?php echo time(); ?>" name="tstamp" />
          </div>
          <div class="box-three">
            <input type="button" class="tstamp-button" value="<?php __('TimestampDecode'); ?>" id="timestampDecoder" />
          </div>
          <div class="box-three">
            <div id="timestampDecoderResult">2014.04.14 - 23:44:15</div>
          </div>
        </div>
      </div>
      <!-- -BOX THREE END-->
    </div>

    <div class="blue-line">
      <div class="box">
        <span class="green-title"><?php __('TimestampEncoder'); ?></span><br /><br />
        <div class="container">
          <div class="box-six">
            <div class="element">
              <b><?php __('Year'); ?>:</b>
            </div>
            <div class="element timestamp">
              <select name="year">
                <?php 
                  for($YearOption=1990; $YearOption<2040; $YearOption++){
                    $YearSelected =  ($YearOption == date('Y')) ? 'selected="selected" ' : '';
                    print '<option ' . $YearSelected . 'value="' . $YearOption . '">' . $YearOption . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="box-six">
            <div class="element">
              <b><?php __('Month'); ?>:</b>
            </div>
            <div class="element timestamp">
              <select name="month">
                <?php 
                  for($MonthOption=1; $MonthOption<13; $MonthOption++){
                    $MonthOption = strlen($MonthOption)<2 ? '0' . $MonthOption : $MonthOption;
                    $MonthSelected =  ($MonthOption == date('m')) ? 'selected="selected" ' : '';
                    print '<option ' . $MonthSelected . 'value="' . $MonthOption . '">' . $MonthOption . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="box-six box-twoclear">
            <div class="element">
              <b><?php __('Day'); ?>:</b>
            </div>
            <div class="element timestamp">
              <select name="day">
                <?php 
                  for($DayOption=1; $DayOption<32; $DayOption++){
                    $DayOption = strlen($DayOption)<2 ? '0' . $DayOption : $DayOption;
                    $DaySelected =  ($DayOption == date('d')) ? 'selected="selected" ' : '';
                    print '<option ' . $DaySelected . 'value="' . $DayOption . '">' . $DayOption . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="box-six">
            <div class="element">
              <b><?php __('Hour'); ?>:</b>
            </div>
            <div class="element timestamp">
              <select name="hour">
                <?php 
                  for($HourOption=0; $HourOption<24; $HourOption++){
                    $HourOption = strlen($HourOption)<2 ? '0' . $HourOption : $HourOption;
                    $HourSelected =  ($HourOption == date('H')) ? 'selected="selected" ' : '';
                    print '<option ' . $HourSelected . 'value="' . $HourOption . '">' . $HourOption . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="box-six box-twoclear">
            <div class="element">
              <b><?php __('Min'); ?>:</b>
            </div>
            <div class="element timestamp">
              <select name="min">
                <?php 
                  for($MinOption=0; $MinOption<60; $MinOption++){
                    $MinOption = strlen($MinOption)<2 ? '0' . $MinOption : $MinOption;
                    $MinSelected =  ($MinOption == date('i')) ? 'selected="selected" ' : '';
                    print '<option ' . $MinSelected . 'value="' . $MinOption . '">' . $MinOption . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="box-six">
            <div class="element">
              <b><?php __('Sec'); ?>:</b>
            </div>
            <div class="element timestamp">
              <select name="sec">
                <?php 
                  for($SecOption=0; $SecOption<60; $SecOption++){
                    $SecOption = strlen($SecOption)<2 ? '0' . $SecOption : $SecOption;
                    $SecSelected =  ($SecOption == date('s')) ? 'selected="selected" ' : '';
                    print '<option ' . $SecSelected . 'value="' . $SecOption . '">' . $SecOption . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="box">
            <div class="container">
              <div class="box-two">
                <div class="element element-padding">
                  <div id="timestampEncoderResult">1234567890</div>
                </div>
              </div>
              <div class="box-two box-twoclear right">
                <br />
                <b><?php __('TimeZone'); ?>:</b> <?php echo TIMEZONE; ?>
                <br /><br />
                <input type="button" class="timestamp-button" value="<?php __('TimestampEncode'); ?>" id="timestampEncoder" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('module_clientdata.php'); ?>