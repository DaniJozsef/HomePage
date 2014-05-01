    <div class="white-line">
      <div class="box">
        <div class="container">
        <form name="tireSizeCalculator"></form>
          <div class="box-four">
            <div class="element">
              <?php __('OriginalTireSizeTitle'); ?>
            </div>
            <div class="element">
              <div id="originTireFullsize">165/70 R14</div>
            </div>
            <div class="element timestamp">
              <b><?php __('WidthTiresize'); ?>: </b><br />
              <select name="originalTireSize-width">
                <?php TireSizeWidth(); ?>
              </select>
            </div>
            <div class="element timestamp">
              <b><?php __('HeightTiresize'); ?>: </b><br />
              <select name="originalTireSize-height">
                <?php TireSizeHeight(); ?>
              </select>
            </div>
            <div class="element timestamp">
              <b><?php __('ColTiresize'); ?>: </b><br />
              <select name="originalTireSize-col">
                <?php TireSizeCol(); ?>
              </select>
            </div>
            <div class="element timestamp">
              <div id="originalTireSize-Diameter" style="display: none;"></div>
            </div>
          </div>
          <div class="box-four">
            <div class="element timestamp">
              <?php __('NewTireSizeTitle'); ?>
            </div>
            <div class="element">
              <div id="newTireFullsize">165/70 R14</div>
            </div>
            <div class="element timestamp">
              <b><?php __('WidthTiresize'); ?>: </b><br />
              <select name="newTireSize-width">
                <?php TireSizeWidth(); ?>
              </select>
            </div>
            <div class="element timestamp">
              <b><?php __('HeightTiresize'); ?>: </b><br />
              <select name="newTireSize-height">
                <?php TireSizeHeight(); ?>
              </select>
            </div>
            <div class="element timestamp">
              <b><?php __('ColTiresize'); ?>: </b><br />
              <select name="newTireSize-col">
                <?php TireSizeCol(); ?>
              </select>
            </div>
            <div class="element timestamp">
              <div id="newTireSize-Diameter" style="display: none;"></div>
            </div>
          </div>
          <div class="box-two box-twoclear">
            <div class="element">
              <div id="matchTireDiameter" style="display: none;"></div>
              <div id="matchTireSpeed" style="display: none;"></div>
                <img src="/style/img/tyre_help.png" border="0" width="100%" />
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
    
    <?php 
    function TireSizeWidth(){
      echo'     <option value="5">5.00</option>
                <option value="6.4">6.4</option>
                <option value="6.5">6.5</option>
                <option value="7">7</option>
                <option value="7.5">7.5</option>
                <option value="9.5">9.5</option>
                <option value="10.5">10.5</option>
                <option value="11.5">11.5</option>
                <option value="12.5">12.5</option>
                <option value="17">17</option>
                <option value="27">27</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="32">32</option>
                <option value="33">33</option>
                <option value="35">35</option>
                <option value="125">125</option>
                <option value="135">135</option>
                <option value="145">145</option>
                <option value="155">155</option>
                <option value="165" selected="selected">165</option>
                <option value="175">175</option>
                <option value="185">185</option>
                <option value="195">195</option>
                <option value="205">205</option>
                <option value="215">215</option>
                <option value="225">225</option>
                <option value="235">235</option>
                <option value="245">245</option>
                <option value="255">255</option>
                <option value="265">265</option>
                <option value="275">275</option>
                <option value="285">285</option>
                <option value="295">295</option>
                <option value="305">305</option>
                <option value="315">315</option>
                <option value="325">325</option>
                <option value="335">335</option>
                <option value="345">345</option>
                <option value="355">355</option>
                <option value="500">500</option>
          ';
    }
    function TireSizeHeight(){
      echo'     <option value="6">6</option>
                <option value="7">7</option>
                <option value="8.5">8.5</option>
                <option value="9.5">9.5</option>
                <option value="10.5">10.5</option>
                <option value="11.5">11.5</option>
                <option value="12.5">12.5</option>
                <option value="12.5">12.5</option>
                <option value="15">15</option>
                <option value="25">25</option>
                <option value="30">30</option>
                <option value="31">31</option>
                <option value="35">35</option>
                <option value="40">40</option>
                <option value="45">45</option>
                <option value="50">50</option>
                <option value="55">55</option>
                <option value="60">60</option>
                <option value="65">65</option>
                <option value="70" selected="selected">70</option>
                <option value="75">75</option>
                <option value="80">80</option>
                <option value="82">82</option>
                <option value="85">85</option>
                <option value="100">100</option>
          ';
    }
    function TireSizeCol(){
      echo'     <option value="10">10</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14" selected="selected">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="16.5">16.5</option>
                <option value="17">17</option>
                <option value="18">18</option>
                <option value="19">19</option>
                <option value="20">20</option>
                <option value="21">21</option>
                <option value="22">22</option>
                <option value="23">23</option>
                <option value="24">24</option>
                <option value="26">26</option>
                <option value="28">28</option>
                <option value="30">30</option>
                <option value="70">70</option>
                <option value="400">400</option>
          ';
    }
    ?>