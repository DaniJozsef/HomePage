    <div class="white-line">
    <form method="post" id="messageform">
      <!-- +BOX FOUR CONNECT FORM-->
      <div class="box">
      <span class="green-title"><?php __('Connect') ?></span>
        <br /><br />
        <div class="container content-form-line">
          <div class="element element-form-line-text">
            <?php __('ConnectContentText') ?>
            <div class="clear"></div>
          </div>
        </div>
        <div class="container content-form-line">
          <div class="box-two">
            <div class="element element-form-line element-text">
              <?php __('Name') ?><span class="require">*</span>: &nbsp;
            </div>
          </div>
          <div class="box-two box-twoclear">
            <div class="element element-form-line">
              <input type="text" name="name" class="hash-input" value="" maxlength="50" placeholder="<?php __('Name') ?>..." />
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="container content-form-line">
          <div class="box-two">
            <div class="element element-form-line element-text">
              <?php __('Email') ?><span class="require">*</span>: &nbsp;
            </div>
          </div>
          <div class="box-two box-twoclear">
            <div class="element element-form-line">
              <input type="text" name="email" class="hash-input" value="" maxlength="50" placeholder="<?php __('Email') ?>..." />
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="container content-form-line">
          <div class="box-two">
            <div class="element element-form-line element-text">
              <?php __('Phone') ?>: &nbsp;
            </div>
          </div>
          <div class="box-two box-twoclear">
            <div class="element element-form-line">
              <input type="text" name="phone" class="hash-input" value="" maxlength="50" placeholder="<?php __('Phone') ?>..." />
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="container content-form-line">
          <div class="element element-form-line">
            <?php __('Message') ?><span class="require">*</span>:
            <textarea name="text"></textarea>
            <div class="clear"></div>
          </div>
        </div>
        <div class="container content-form-line">
          <div class="box-two">
            <div class="element element-form-line element-text">
              <?php __('Client') ?>: &nbsp;
            </div>
          </div>
          <div class="box-two box-twoclear">
            <div class="element element-form-line">
              <select name="client">
                <option value="newclient"><?php __('NewClient') ?></option>
                <option value="oldclient"><?php __('OldClient') ?></option>
                <option value="noclient"selected="selected"><?php __('NoClient') ?></option>
              </select>
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="container content-form-line">
          <div class="box-two">
            <div class="element element-form-line element-text">
              <?php __('CaptchaCode') ?>: &nbsp;
            </div>
          </div>
          <div class="box-two box-twoclear">
            <div class="element element-form-line">
              <img src="<?php print CAPTCHADIR ?>captchaimage.php" border="0" width="170" height="70" name="captchaimage" />
              <img border=0 src="/style/icons/gray/32x32/refresh.png" title="<?php print __('CaptchaRefresh') ?>" id="captchaRefresh" />
            </div>
          </div>
          <div class="box-two">
            <div class="element element-form-line element-text">
              <?php __('CaptchaValue') ?>: &nbsp;
            </div>
          </div>
          <div class="box-two box-twoclear">
            <div class="element element-form-line">
              <input type="text" name="captchavalue" class="hash-input" value="" maxlength="10" placeholder="<?php __('CaptchaValue') ?>..." />
            </div>
          </div>
          <div class="clear"></div>
        </div>
        <div class="container right">
          <div class="element">
            <br />
            <input type="submit" name="connectsubmit" class="hash-button" value="<?php __('SendMessage') ?>" />
            <div id="newmessage">
              <a href="/<?php __('connect'); ?>"><?php __('NewConnectMessage'); ?></a>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <!-- -BOX FOUR CONNECT FORM END-->
    </form>
    </div>