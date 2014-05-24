$(function() {
  
  if($('.tooltip')){
    $('.tooltip').tooltipster();
  }
  //LOCAL DATE
  date = new Date;
  if($("#LocalTimeZone")){
    $("#LocalTimeZone").html(dateFormat("timeZone"));
  }
  if($("#LocalDateTime")){
    var DateTime = dateFormat("date") + '<br />' + dateFormat("time");
    $("#LocalDateTime").html(DateTime);
  }
  if($("#NameDay")){
    $("#NameDay").html(dateFormat("nameDay") + ' ' + LANG_NAMEDAY);
  }
  if($("#bissextile")){
    $("#bissextile").html(bissextile() ? LANG_BISSEXTILEYES : LANG_BISSEXTILENO);
  }
  
  //FANCYBOX WINDOW
  var fancyboxOpen = function(alertText, type){
    var type = type ? type : 'warning';
    fancyboxImage = '<p align="center"><img src="' + IMG_PATH + type +'.png" border="0" /></p>';
    CloseButton = '<div class="closebutton"><span>' + LANG_BTN_OK + '</span></div>';
    $.fancybox('<div style="padding-bottom: 20px;">' + fancyboxImage + alertText + CloseButton + '</div>', {
      closeBtn: false, 
      openEffect: 'elastic',
      scrolling: false,
      autoSize: false,
      maxWidth: '350px',
      height: 'auto',
      padding: [10, 10, 5, 10]
    });
    $(".closebutton span").click(function(){
      $.fancybox.close(true);
    });
  }  
  
  //FANCYBOX AJAXLOADER
  var fancyboxLoader = function(){
    $.fancybox('<div id="loading">' +
                 '<div class="text">' + LANG_LOADING + '<span class="basecolor">...</span></div>' +
               '</div>', {
      closeBtn: false, 
      openEffect: 'elastic',
      scrolling: false,
      autoSize: false,
      maxWidth: '350px',
      height: 'auto',
      padding: [10, 10, 5, 10]
    });
  }
 
  //BOOKMARK AND SETHOMEPAGE IN IE WORKING ONLY
  if(navigator.userAgent.toLowerCase().indexOf('msie') < 0){
    $("a#addbookmark").parent().hide();
    $("a#sethomepage").parent().hide();
  }
  
  //ADD TO BOOKMARK
  $("a#addbookmark").click(function(event){
    event.preventDefault();
    var bookmarkUrl = this.href;
    var bookmarkTitle = PAGE_TITLE;
    if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1 || navigator.userAgent.toLowerCase().indexOf('firefox') > -1){ 
      fancyboxOpen(LANG_ADDBOOKMARK_NOT_WORK_IN_CHROME);
    }else if( window.external || document.all){
      window.external.AddFavorite(bookmarkUrl, bookmarkTitle);          
    }else if(window.opera){
      $("a.bookmark").attr("href",bookmarkUrl);
      $("a.bookmark").attr("title",bookmarkTitle);
      $("a.bookmark").attr("rel","sidebar");
    }else{
      fancyboxOpen(LANG_ADDBOOKMARK_NOT_WORK);
      return false;
    }
  });
  //SET HOMEPAGE
  $("a#sethomepage").click(function(event){
    document.body.style.behavior='url(#default#homepage)';
    document.body.setHomePage(this.href);
  });
  

  //HASH ENCODE/DECODE
  $("input[name='hashsubmit']").click(function(){
    hashInput = $("input[name='hash']");
    if(hashInput.val().length == 0){
      fancyboxOpen(LANG_HASH_STRING_REQUIRED);
      hashInput.addClass("input-required-error");
      hashInput.focus();
    }else{
      $.ajax({
        type: "POST",
        url: AJAX_PATH + "ajax" + AJAX_EXT + '/hash',
        data: { 
          string: hashInput.val(), 
          type: $("select[name='type']").val()
        },
        beforeSend: function( xhr ) {
          xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          fancyboxLoader();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#loading").hide("slow");
          $.fancybox.close(true);
          fancyboxOpen(LANG_ERROR + ': ' + XMLHttpRequest.status + '/' + XMLHttpRequest.statusText + '/n' + LANG_CONNECT_FAILED);
          hashInput.addClass("input-required-error");
          $(".hash-box").addClass("input-required-error");
        },
        success: function(){
          hashInput.removeClass("input-required-error");
          $(".hash-box").removeClass("input-required-error");
        }       
      })
      .done(function( responseData ) {
        var datas = JSON.parse(responseData);
        switch ($("select[name='type']").val()){
          case 'string':
            activetype1 = 'hash-result-activetype'; activetype2 = ''; activetype3 = '';
            break;
          case 'md5':  
            activetype2 = 'hash-result-activetype'; activetype1 = ''; activetype3 = '';
            break;
          case 'sha1': 
            activetype3 = 'hash-result-activetype'; activetype1 = ''; activetype2 = '';
            break;
        }
        var resultHtml = '<div class="hash-result-line ' + activetype1 + '"><b>String:</b> ' + datas.returnData.string + '</div>' +
                         '<div class="hash-result-line ' + activetype2 + '"><b>md5 hash:</b> ' + datas.returnData.md5 + '</div>' +
                         '<div class="hash-result-line ' + activetype3 + '"><b>sha1 hash:</b> ' + datas.returnData.sha1 + '</div>';
        if(datas.post.type == 'md5' || datas.post.type == 'sha1'){
          if(datas.returnData.message_code == 2){
            resultHtml = '<div class="hash-result-line-failed">' + LANG_DECODE_FAILED + '</div>' + resultHtml;
          }else{
            resultHtml = '<div class="hash-result-line-success">' + LANG_DECODE_SUCCESS + '</div>' + resultHtml;
          }
        }
        $("#hash-result").html( resultHtml );
        $('#loading').hide("slow");
        $.fancybox.close(true);
        $("#hash-result").show();
      });
    }
  });
  
  //LOADING LAYER CLICK HIDE
  $("#loading").click(function(){
    $("#loading").hide("slow");
  });
  
  //CAPTCHA REFRESH
  $("#captchaRefresh").click(function(){
    captchaimage.src= LIB_PATH + 'class/captcha/captchaimage' + AJAX_EXT + '?' + Math.random();
  });
  
  //EMAIL VALIDATION
  var isValidEmailAddress = function (emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
  };
  
  //CONNECT FORM VALIDATION CHECK
  $("input[name='connectsubmit']").click(function(){
    //Valid email
    var formErrorText = '';
    var inputEmailValue = $("input[name='email']").val();
    if(!isValidEmailAddress(inputEmailValue)){
      formErrorText += LANG_MESSAGEFORM_ERROR_NOVALID_EMAIL;
      var formError1 = true;
    }
    formError1=false;
    //Require name
    if($("input[name='name']").val().length < 2){
      formErrorText += LANG_MESSAGEFORM_ERROR_NAME_LEN;
      var formError2 = true;
    }
    //Require message
    if($("textarea[name='text']").val().length < 10){
      formErrorText += LANG_MESSAGEFORM_ERROR_TEXT_LEN;
      var formError3 = true;
    }
    //Require captcha
    if($("input[name='captchavalue']").val().length < 1){
      formErrorText += LANG_MESSAGEFORM_ERROR_NOCAPTCHA;
      var formError4 = true;
    }
    
    if(formError1 || formError2 || formError3 || formError4){
      event.preventDefault();
      fancyboxOpen(formErrorText, 'error');
    }else{
      event.preventDefault();
      $.ajax({
        type: "POST",
        url: AJAX_PATH + "ajax" + AJAX_EXT + '/message',
        data: { 
          messageFormName: $("input[name='name']").val(),
          messageFormEmail: $("input[name='email']").val(),
          messageFormPhone: $("input[name='phone']").val(),
          messageFormText: $("textarea[name='text']").val(),
          messageFormClient: $("select[name='client']").val(),
          messageFormCaptcha: $("input[name='captchavalue']").val()
        },
        beforeSend: function( xhr ) {
          xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          fancyboxLoader();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#loading").hide("slow");
          $.fancybox.close(true);
          fancyboxOpen(LANG_ERROR + ': ' + XMLHttpRequest.status + '/' + XMLHttpRequest.statusText + '/n' + LANG_CONNECT_FAILED);
        }       
      })
      .done(function( responseData ) {
        $.fancybox.close(true);
        var datas = JSON.parse(responseData);
        if(datas.ErrorStatus == 1){
          ErrorMessage = datas.ErrorMessage.substring(0,datas.ErrorMessage.length-1);
          var ErrorInfo = ErrorMessage.split(',');
          var ErrorOutput = '';
          for (ErrorInfoIndex = 0; ErrorInfoIndex < ErrorInfo.length; ++ErrorInfoIndex) {
            ErrorOutput = ErrorOutput + '<li>' + ErrorInfo[ErrorInfoIndex] + '</li>';
          }
          fancyboxOpen('<ul>' + ErrorOutput + '</ul>', 'error');
        }else{
          $("input[name='name'], input[name='email'], input[name='phone'], textarea[name='text'], select[name='client'], input[name='captchavalue']").attr("disabled", "disabled");
          $("input[name='connectsubmit']").hide();
          $("#newmessage").show();
          fancyboxOpen(LANG_MESSAGE_SEND_OK, 'success');
        } 
      });
    }
  });
  
  //TIMESTAMP DECODE
  $("#timestampDecoder").click(function(){
    TimestampInput = $("input[name='tstamp']");
    if(TimestampInput.val().length == 0){
      fancyboxOpen(LANG_TIMESTAMP_NUM_REQUIRED);
      TimestampInput.addClass("input-required-error");
      TimestampInput.focus();
    }else{
      $.ajax({
        type: "POST",
        url: AJAX_PATH + "ajax" + AJAX_EXT + '/TimestampDecoder',
        data: { 
          TimeStamp: TimestampInput.val()
        },
        beforeSend: function( xhr ) {
          xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          fancyboxLoader();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#loading").hide("slow");
          $.fancybox.close(true);
          fancyboxOpen(LANG_ERROR + ': ' + XMLHttpRequest.status + '/' + XMLHttpRequest.statusText + '/n' + LANG_CONNECT_FAILED);
          TimestampInput.addClass("input-required-error");
        },
        success: function(){
          TimestampInput.removeClass("input-required-error");
        }       
      })
      .done(function( responseData ) {
        var datas = JSON.parse(responseData);
        if(datas.ErrorStatus == 1){
          fancyboxOpen('<ul><li>' + datas.ErrorMessage + '</li></ul>', 'error');
          TimestampInput.addClass("input-required-error");
          TimestampInput.focus();
        }else{
          $("#timestampDecoderResult").html( datas.date );
          $('#loading').hide("slow");
          $.fancybox.close(true);
          $("#timestampDecoderResult").show();
        }
      });
    }
  });
  //TIMESTAMP ENCODE
  $("#timestampEncoder").click(function(){
    if(!parseInt($("select[name='month']").val()) || !parseInt($("select[name='day']").val()) || !parseInt($("select[name='year']").val())){
      fancyboxOpen(LANG_TIMESTAMP_NUM_REQUIRED);
    }else{
      $.ajax({
        type: "POST",
        url: AJAX_PATH + "ajax" + AJAX_EXT + '/TimestampEncoder',
        data: { 
          Hour: $("select[name='hour']").val(),
          Min: $("select[name='min']").val(),
          Sec: $("select[name='sec']").val(),
          Month: $("select[name='month']").val(),
          Day: $("select[name='day']").val(),
          Year: $("select[name='year']").val()
        },
        beforeSend: function( xhr ) {
          xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
          fancyboxLoader();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          $("#loading").hide("slow");
          $.fancybox.close(true);
          fancyboxOpen(LANG_ERROR + ': ' + XMLHttpRequest.status + '/' + XMLHttpRequest.statusText + '/n' + LANG_CONNECT_FAILED);
        },
        success: function(){
          
        }       
      })
      .done(function( responseData ) {
        var datas = JSON.parse(responseData);
        if(datas.ErrorStatus == 1){
          fancyboxOpen('<ul><li>' + datas.ErrorMessage + '</li></ul>', 'error');
        }else{
          $("#timestampEncoderResult").html( datas.timestamp );
          $('#loading').hide("slow");
          $.fancybox.close(true);
          $("#timestampEncoderResult").show();
        }
      });
    }
  });
  
  //GUMIMÉRET ÁTVÁLTÓ
  $("select[name='originalTireSize-width'], select[name='newTireSize-width']," +
  	"select[name='originalTireSize-height'], select[name='newTireSize-height']," +
  	"select[name='originalTireSize-col'], select[name='newTireSize-col']").change(function (){
    $("#originTireFullsize").html(
      $("select[name='originalTireSize-width']").val() + '/' + $("select[name='originalTireSize-height']").val() + ' R' + $("select[name='originalTireSize-col']").val()
    );
    $("#newTireFullsize").html(
      $("select[name='newTireSize-width']").val() + '/' + $("select[name='newTireSize-height']").val() + ' R' + $("select[name='newTireSize-col']").val()
    );
    TrireCalc();
  });
    
  var TrireCalc = function() {
    originalTireSizeWidth = $("select[name='originalTireSize-width']").val();
    newTireSizeWidth = $("select[name='newTireSize-width']").val();
    originalTireSizeHeight = $("select[name='originalTireSize-height']").val();
    newTireSizeHeight = $("select[name='newTireSize-height']").val();
    originalTireSizeCol = $("select[name='originalTireSize-col']").val();
    newTireSizeCol = $("select[name='newTireSize-col']").val();
    
    if(originalTireSizeWidth && originalTireSizeHeight && originalTireSizeCol &&
       newTireSizeWidth && newTireSizeHeight && newTireSizeCol) {
      var originTire, newTire, sizeDiff, differentTiresize, differentTiresize2, sign, Percent;
      originTire = originalTireSizeCol*25.4+2*(originalTireSizeHeight*(originalTireSizeWidth/100));
      newTire = newTireSizeCol*25.4+2*(newTireSizeHeight*(newTireSizeWidth/100));    
      var goodDiff = (originTire*3)/100, //elfogadható differencia
          sizeDiff = (newTire-originTire);
    
      if (Math.abs(sizeDiff) > goodDiff) {
        $("#matchTireDiameter").removeClass("hash-result-line-success");
        $("#matchTireDiameter").addClass("hash-result-line-failed");
        var includeDiffComment = LANG_DIFF_COMMENT_BADDIFF;
      } else {
        $("#matchTireDiameter").addClass("hash-result-line-success");
        $("#matchTireDiameter").removeClass("hash-result-line-failed");
        var includeDiffComment = LANG_DIFF_COMMENT_GOODDIFF;
      }
      
      if(originTire == null && newTire == null) {
        differentTiresize = 0 + 'mm';
        differentTiresize2 = 0 + 'km/h';
      }
      else {
        sign = (sizeDiff>0) ? '+' : '';
        differentTiresize = sizeDiff;  
        Percent = (sizeDiff*100)/originTire;
        differentTiresize2 = (100-Percent);
      }
      includeDiffComment = (originTire == newTire) ? LANG_DIFF_COMMENT_EXCELLENTDIFF : includeDiffComment;
      var carSpeedComment = LANG_MATCH_TIRE_SPEED_COMMENT.replace('%SPEED%', String(Math.round(differentTiresize2)) + 'km/h');   
      $("#matchTireDiameter").html(includeDiffComment + '<br />' + sign + String(Math.round(differentTiresize)) + 'mm (' + String(Math.round(Percent)) + '%)');
      $("#matchTireSpeed").html(carSpeedComment);
      $("#originalTireSize-Diameter").html(LANG_DIAMETER + ': ' + String(Math.round(originTire)) + 'mm');
      $("#newTireSize-Diameter").html(LANG_DIAMETER + ': ' + String(Math.round(newTire)) + 'mm');
      $("#originalTireSize-Diameter, #newTireSize-Diameter, #matchTireDiameter, #matchTireSpeed").show();
    }
  };
  
  //VOLLEYBALL NEWS
  /*SLIDE OPTIONS
  $(".rslides").responsiveSlides({
    auto: true,             // Boolean: Animate automatically, true or false
    speed: 500,             // Integer: Speed of the transition, in milliseconds
    timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
    pager: false,           // Boolean: Show pager, true or false
    nav: false,             // Boolean: Show navigation, true or false
    random: false,          // Boolean: Randomize the order of the slides, true or false
    pause: false,           // Boolean: Pause on hover, true or false
    pauseControls: true,    // Boolean: Pause when hovering controls, true or false
    prevText: "Previous",   // String: Text for the "previous" button
    nextText: "Next",       // String: Text for the "next" button
    maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
    navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
    manualControls: "",     // Selector: Declare custom pager navigation
    namespace: "rslides",   // String: Change the default namespace used
    before: function(){},   // Function: Before callback
    after: function(){}     // Function: After callback
  });*/
  /*
  if($(".rslides")){
    var volleyBallDatas ='';
    $.ajax({
      type: 'post',
      url: AJAX_PATH + 'interface' + AJAX_EXT + '/finoroak',
      dataType: 'json',
      success: function(data){
        $.each(data, function(index, value) {
          volleyBallDatas = volleyBallDatas + '<li style="background: url(\'' + value.img + '\')">' +
                          '<div class="newslayer"><div class="newstext">' +
                          '<a href="' + value.url + '" target="_blank">' + value.title + '</a><br />' +
                          value.short + '<div align="right">' + value.date + '</div>' +
                          '</div></div>' +
                          '</li>';
        });
        $(".rslides").html(volleyBallDatas);
        $(".rslides").responsiveSlides({
          timeout: 8000
        });
      }
    });
  }
  */
  
  //LOGIN & LOGINDATA
  if(USERNAME != ''){
    $("#userdatas_name").html(USERNAME);
    $('#userdatas').show();
  }
  
  if($("#loginsubmit")){
    $("#loginsubmit").click(function(){
      NameInput = $("input[name='user']");
      PassInput = $("input[name='pass']");
      AutologInput = $("input[name='autologin']");
      if(NameInput.val().length == 0){
        fancyboxOpen(LANG_LOGIN_NAME_REQUIRED);
        NameInput.addClass("input-required-error");
        NameInput.focus();
      }else if(PassInput.val().length == 0){
        fancyboxOpen(LANG_LOGIN_PASS_REQUIRED);
        PassInput.addClass("input-required-error");
        PassInput.focus();
      }else{
        $.ajax({
          type: "POST",
          url: AJAX_PATH + "ajax" + AJAX_EXT + '/Login',
          data: { 
            User: NameInput.val(),
            Pass: PassInput.val(),
            Auto: ((AutologInput.is(":checked")) ? 1 : 0)
          },
          beforeSend: function( xhr ) {
            xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            fancyboxLoader();
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#loading").hide("slow");
            $.fancybox.close(true);
            fancyboxOpen(LANG_ERROR + ': ' + XMLHttpRequest.status + '/' + XMLHttpRequest.statusText + '/n' + LANG_CONNECT_FAILED);
            NameInput.addClass("input-required-error");
          },
          success: function(){
            NameInput.removeClass("input-required-error");
            PassInput.removeClass("input-required-error");
          }       
        })
        .done(function( responseData ) {
          var datas = JSON.parse(responseData);
          if(datas.ErrorStatus == 1){
            fancyboxOpen('<ul><li>' + datas.ErrorMessage + '</li></ul>', 'error');
            NameInput.addClass("input-required-error");
            NameInput.focus();
          }else{
            $('#loginform').hide("slow");
            $.fancybox.close(true);
            $("#userdatas_name").html(datas.username);
            $('#userdatas').show();
          }
        });
      }
    });
  }
    
})