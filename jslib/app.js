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
  
    
})