<?php
$RootDir = '';
$includeurl = false;
$startdir = './../torrent';
$TorrentfileDir = $startdir.'/torrentFiles/auto/';
$IconFolder = '/style/icons/filetype-16x16/';
$memorylimit = false; // Integer
$showdirs = true;
$forcedownloads = false;
$hide = array(
    'dlf',
    'index.php',
    'Thumbs',
    '.htaccess',
    '.htpasswd'
);
$displayindex = false;
$allowuploads = true;
$overwrite = false;
$indexfiles = array (
  'index.phtml',
  'index.html',
  'index.htm',
  'index.php',
  'index.php3',
  'default.htm',
  'default.html',
  'default.phtml'
);
$filetypes = array (
  'accdb' => 'accdb.png',
  'avi' => 'avi.png',
  'bin' => 'bin.png',
  'bmp' => 'bmp.png',
  'browser' => 'browser.png',
  'cfg' => 'cfg.png',
  'code' => 'code.png',
  'conf' => 'conf.png',
  'css' => 'css.png',
  'csv' => 'csv.png',
  'dat' => 'dat.png',
  'dir' => 'dir.png',
  'dll' => 'dll.png',
  'doc' => 'doc.png',
  'docx' => 'docx.png',
  'downloads' => 'downloads.png',
  'email' => 'email.png',
  'exe' => 'exe.png',
  'facebook' => 'facebook.png',
  'favour' => 'favour.png',
  'fla' => 'fla.png',
  'fon' => 'fon.png',
  'gif' => 'gif.png',
  'google' => 'google.png',
  'gz' => 'gz.png',
  'hlp' => 'hlp.png',
  'htm' => 'htm.png',
  'html' => 'html.png',
  'ico' => 'ico.png',
  'inc' => 'inc.png',
  'ini' => 'ini.png',
  'jad' => 'jad.png',
  'jar' => 'jar.png',
  'jpeg' => 'jpeg.png',
  'jpg' => 'jpg.png',
  'js' => 'js.png',
  'log' => 'log.png',
  'mdb' => 'mdb.png',
  'mid' => 'mid.png',
  'mov' => 'mov.png',
  'mp3' => 'mp3.png',
  'mp4' => 'mp4.png',
  'mpeg' => 'mpeg.png',
  'mpg' => 'mpg.png',
  'msi' => 'msi.png',
  'nfo' => 'nfo.png',
  'ogg' => 'ogg.png',
  'otf' => 'otf.png',
  'outlook' => 'outlook.png',
  'page' => 'page.png',
  'pdf' => 'pdf.png',
  'php' => 'php.png',
  'php3' => 'php3.png',
  'pif' => 'pif.png',
  'png' => 'png.png',
  'ppt' => 'ppt.png',
  'pptx' => 'pptx.png',
  'psd' => 'psd.png',
  'rar' => 'rar.png',
  'routing' => 'routing.png',
  'rtf' => 'rtf.png',
  'sethome' => 'sethome.png',
  'swf' => 'swf.png',
  'tar' => 'tar.png',
  'tif' => 'tif.png',
  'tmp' => 'tmp.png',
  'torrent' => 'torrent.png',
  'tpl' => 'tpl.png',
  'ttf' => 'ttf.png',
  'twitter' => 'twitter.png',
  'txt' => 'txt.png',
  'vba' => 'vba.png',
  'waw' => 'waw.png',
  'xls' => 'xls.png',
  'xlsm' => 'xlsm.png',
  'xlsx' => 'xlsx.png',
  'xml' => 'xml.png',
  'xmlx' => 'xmlx.png',
  'xsl' => 'xsl.png',
  'xslx' => 'xslx.png',
  'zip' => 'zip.png',
);
	

if($includeurl){
  $includeurl = preg_replace("/^\//", "${1}", $includeurl);
  if(substr($includeurl, strrpos($includeurl, '/')) != '/') $includeurl.='/';
}

error_reporting(0);
if(!function_exists('imagecreatetruecolor')){
  $showthumbnails = false;
}
if($startdir){
  $startdir = preg_replace("/^\//", "${1}", $startdir);
}
$leadon = $startdir;
if($leadon=='.'){
  $leadon = '';
}
if((substr($leadon, -1, 1)!='/') && $leadon!=''){
  $leadon = $leadon . '/';
}
$startdir = $leadon;

if($_GET['dir']) {
  //check this is okay.

  if(substr($_GET['dir'], -1, 1)!='/') {
    $_GET['dir'] = strip_tags($_GET['dir']) . '/';
  }

  $dirok = true;
  $dirnames = split('/', strip_tags($_GET['dir']));
  for($di=0; $di<sizeof($dirnames); $di++) {

    if($di<(sizeof($dirnames)-2)) {
      $dotdotdir = $dotdotdir . $dirnames[$di] . '/';
    }

    if($dirnames[$di] == '..') {
      $dirok = false;
    }
  }

  if(substr($_GET['dir'], 0, 1)=='/') {
    $dirok = false;
  }

  if($dirok) {
    $leadon = $leadon . strip_tags($_GET['dir']);
  }
}

if($_GET['download'] && $forcedownloads) {
  $file = str_replace('/', '', $_GET['download']);
  $file = str_replace('..', '', $file);

  if(file_exists($includeurl . $leadon . $file)) {
    header("Content-type: application/x-download");
    header("Content-Length: ".filesize($includeurl . $leadon . $file));
    header('Content-Disposition: attachment; filename="'.$file.'"');
    readfile($includeurl . $leadon . $file);
    die();
  }
  die();
}

if($allowuploads && $_FILES['file']){
  $upload = true;
  if(!$overwrite) {
    if(file_exists($leadon.$_FILES['file']['name'])){
      $upload = false;
    }
  }

  if($uploadtypes){
    if(!in_array(substr($_FILES['file']['name'], strpos($_FILES['file']['name'], '.')+1, strlen($_FILES['file']['name'])), $uploadtypes))
    {
      $upload = false;
      $uploaderror = "<strong>ERROR: </strong> You may only upload files of type ";
      $i = 1;
      foreach($uploadtypes as $k => $v)
      {
        if($i == sizeof($uploadtypes) && sizeof($uploadtypes) != 1){
          $uploaderror.= ' and ';
        }else if($i != 1){
          $uploaderror.= ', ';
        }
        $uploaderror.= '.'.strtoupper($v);
        $i++;
      }
    }
  }

  if($upload) {
    $UploadDir = $includeurl.$leadon;
    move_uploaded_file($_FILES['file']['tmp_name'], $includeurl.$leadon . $_FILES['file']['name']);
    if($UploadDir == $TorrentfileDir){  
      $SqlInsertTorrent = "INSERT INTO " . DB_PREFIX . "torrents (userid, torrentfile, ins_dt) VALUES ('" . $_SESSION['userid'] . "', '" . $_FILES['file']['name'] . "', " . time() . ")";
      $DB->query($SqlInsertTorrent);
    }
  }
}

$opendir = $includeurl.$leadon;
if(!$leadon){
  $opendir = '.';
}
if(!file_exists($opendir)) {
  $opendir = '.';
  $leadon = $startdir;
}

clearstatcache();
if ($handle = opendir($opendir)) {
  while (false !== ($file = readdir($handle))) {
    //first see if this file is required in the listing
    if ($file == "." || $file == "..")  continue;
    $discard = false;
    for($hi=0;$hi<sizeof($hide);$hi++){
      if(strpos($file, $hide[$hi])!==false){
        $discard = true;
      }
    }

    if($discard){
      continue;
    }
    if (@filetype($includeurl.$leadon.$file) == "dir"){
      if(!$showdirs){
        continue;
      }

      $n++;
      if($_GET['sort']=="date"){
        $key = @filemtime($includeurl.$leadon.$file) . ".$n";
      }else {
        $key = $n;
      }
      $dirs[$key] = $file . "/";
    }
    else {
      $n++;
      if($_GET['sort']=="date"){
        $key = @filemtime($includeurl.$leadon.$file) . ".$n";
      }elseif($_GET['sort']=="size"){
        $key = @filesize($includeurl.$leadon.$file) . ".$n";
      }else {
        $key = $n;
      }
      	
      if($showtypes && !in_array(substr($file, strpos($file, '.')+1, strlen($file)), $showtypes)) unset($file);
      if($file) $files[$key] = $file;
      	
      if($displayindex){
        if(in_array(strtolower($file), $indexfiles)){
          header("Location: $leadon$file");
          die();
        }
      }
    }
  }
  closedir($handle);
}

//sort our files
if($_GET['sort']=="date") {
  @ksort($dirs, SORT_NUMERIC);
  @ksort($files, SORT_NUMERIC);
}elseif($_GET['sort']=="size") {
  @natcasesort($dirs);
  @ksort($files, SORT_NUMERIC);
}else {
  @natcasesort($dirs);
  @natcasesort($files);
}

//order correctly
if($_GET['order']=="desc" && $_GET['sort']!="size"){
  $dirs = @array_reverse($dirs);
}
if($_GET['order']=="desc"){
  $files = @array_reverse($files);
}
$dirs = @array_values($dirs); 
$files = @array_values($files);

?>


  <div id="breadcrumbs">
  <?php
 	 $breadcrumbs = split('/', str_replace($startdir, '', $leadon));
 	  echo '<a href="?dir=">HOME</a>';
  	if(($bsize = sizeof($breadcrumbs))>0) {
  		$sofar = '';
  		for($bi=0;$bi<($bsize-1);$bi++) {
			 $sofar = $sofar . $breadcrumbs[$bi] . '/';
			 echo '/<a href="'.$RootDir.'?dir='.urlencode($sofar).'">'.$breadcrumbs[$bi].'</a>';
		  }
  	}
  
	$baseurl = $RootDir . '?dir='.strip_tags($_GET['dir']) . '&amp;';
	$fileurl = 'sort=name&amp;order=asc';
	$sizeurl = 'sort=size&amp;order=asc';
	$dateurl = 'sort=date&amp;order=asc';
	
	switch ($_GET['sort']) {
		case 'name':
			if($_GET['order']=='asc') $fileurl = 'sort=name&amp;order=desc';
			break;
		case 'size':
			if($_GET['order']=='asc') $sizeurl = 'sort=size&amp;order=desc';
			break;
			
		case 'date':
			if($_GET['order']=='asc') $dateurl = 'sort=date&amp;order=desc';
			break;  
		default:
			$fileurl = 'sort=name&amp;order=desc';
			break;
	}
  ?>
  </div>
  <div id="listingcontainer">
    <div id="listingheader"> 
	<div id="headerfile"><a href="<?php echo $baseurl . $fileurl;?>"><?php __('FileTypeFile'); ?></a></div>
	<div id="headersize"><a href="<?php echo $baseurl . $sizeurl;?>"><?php __('FileSize'); ?></a></div>
	<div id="headermodified"><a href="<?php echo $baseurl . $dateurl;?>"><?php __('FileDate'); ?></a></div>
	</div>
    <div id="listing">
	<?php
	$class = 'b';
	if($dirok) {
	?>
	<div><a href="<?php echo $RootDir.'?dir='.urlencode($dotdotdir);?>" class="<?php echo $class;?>"><img src="<?php echo $IconFolder; ?>/dirup.png" alt="Folder" /><strong>..</strong> <em>&nbsp;</em>&nbsp;</a></div>
	<?php
		if($class=='b') $class='w';
		else $class = 'b';
	}
	$arsize = sizeof($dirs);
	for($i=0;$i<$arsize;$i++) {
    if(strlen($dirs[$i])>43) {
      $DirName = substr($dirs[$i], 0, 40) . '...';
      $Tooltip = TRUE;
    }else{
      $DirName = $dirs[$i];
      $Tooltip = FALSE;
    }
    $TooltipText = '&lt;b&gt;' . __('FileTypeDir', true) . ': &lt;/b&gt;' . $dirs[$i];
	?>
	<div  class="<?php echo $Tooltip ? 'tooltip' : ''; ?>" title="<?php echo $Tooltip ? $TooltipText : ''; ?>"><a href="<?php echo $RootDir.'?dir='.urlencode(str_replace($startdir,'',$leadon).$dirs[$i]);?>" class="<?php echo $class;?>"><img src="<?php echo $IconFolder; ?>/dir.png" alt="<?php echo $dirs[$i];?>" /><strong><?php echo $DirName;?></strong> <em>-</em> <?php echo GetFileDate($includeurl.$leadon.$dirs[$i]); ?></a></div>
	<?php
		if($class=='b') $class='w';
		else $class = 'b';	
	}
	
	$arsize = sizeof($files);
	for($i=0;$i<$arsize;$i++) {
		$icon = 'unknown.png';
		$ext = strtolower(substr($files[$i], strrpos($files[$i], '.')+1));
		$supportedimages = array('gif', 'png', 'jpeg', 'jpg');
		$thumb = '';
		
		if($showthumbnails && in_array($ext, $supportedimages)) {
			$thumb = '<span><img src="dlf/trans.gif" alt="'.$files[$i].'" name="thumb'.$i.'" /></span>';
			$thumb2 = ' onmouseover="o('.$i.', \''.urlencode($leadon . $files[$i]).'\');" onmouseout="f('.$i.');"';
			
		}
		
		if($filetypes[$ext]) {
			$icon = $filetypes[$ext];
		}
		
		$filename = $files[$i];
		if(strlen($filename)>43) {
			$filename = substr($files[$i], 0, 40) . '...';
			$Tooltip = TRUE;
		}else{
      $Tooltip = FALSE;
    }
		
		$fileurl = $includeurl . $leadon . $files[$i];
		if($forcedownloads) {
			$fileurl = $RootDir . '?dir=' . urlencode(str_replace($startdir,'',$leadon)) . '&download=' . urlencode($files[$i]);
		}
		
		$TooltipText = '&lt;b&gt;' . __('FileTypeFile', true) . ': &lt;/b&gt;' . $files[$i];

	?>
	<div class="<?php echo $Tooltip ? 'tooltip' : ''; ?>" title="<?php echo $Tooltip ? $TooltipText : ''; ?>"><a href="<?php echo $fileurl;?>" class="<?php echo $class;?>"<?php echo $thumb2;?>><img src="<?php echo $IconFolder.$icon;?>" alt="<?php echo $files[$i];?>" /><strong><?php echo $filename;?></strong> <em><?php echo GetFileSize($includeurl.$leadon.$files[$i]); ?></em> <?php echo GetFileDate($includeurl.$leadon.$files[$i]); ?><?php echo $thumb;?></a></div>
	<?php
		if($class=='b') $class='w';
		else $class = 'b';	
	}	
	?></div>
	<?php
	if($allowuploads) {
		$phpallowuploads = (bool) ini_get('file_uploads');		
		$phpmaxsize = ini_get('upload_max_filesize');
		$phpmaxsize = trim($phpmaxsize);
		$last = strtolower($phpmaxsize{strlen($phpmaxsize)-1});
		switch($last) {
			case 'g':
				$phpmaxsize *= 1024*1024*1024;
			case 'm':
				$phpmaxsize *= 1024*1024;
		}
	
	?>
	<div id="upload">
		<div id="uploadtitle">
			<strong><?php __('FileUploadTitle'); ?></strong> (<?php __('FileUploadMaxfilesize'); ?>: <?php echo GetFileSize($phpmaxsize);?>)
			
			<?php if($uploaderror) echo '<div class="upload-error">'.$uploaderror.'</div>'; ?>
		</div>
		<div id="uploadcontent">
			<?php
			if($phpallowuploads) {
      $TorrentExtensionOnly = ($TorrentfileDir == $leadon) ? ' accept=".torrent"' : '';
			?>
			<form method="post" action="?dir=<?php echo urlencode(str_replace($startdir,'',$leadon));?>" enctype="multipart/form-data">
			<input type="file" name="file"<?php echo $TorrentExtensionOnly; ?> /> <input type="submit" value="<?php __('FileUpload'); ?>" />
			</form>
			<?php
			}
			else {
			?>
			File uploads are disabled in your php.ini file. Please enable them.
			<?php
			}
			?>
		</div>
		
	</div>
	<?php
	}
	?>
  </div>
  
  <?php 
  function GetFileSize($File){
    if(filesize($File)){
      if(($Filesize = filesize($File)/1024/1024/1024) >= 1){
        return round($Filesize) . 'GB';
      }else if(($Filesize = filesize($File)/1024/1024) >= 1){
        return round($Filesize) . 'MB';
      }else if(($Filesize = filesize($File)/1024) >= 1){
        return round($Filesize) . 'KB';
      }else{
        return round(filesize($File)) . 'B';
      }
    }else{
      if(($Filesize = $File/1024/1024/1024) >= 1){
        return round($Filesize) . 'GB';
      }else if(($Filesize = $File/1024/1024) >= 1){
        return round($Filesize) . 'MB';
      }else if(($Filesize = $File/1024) >= 1){
        return round($Filesize) . 'KB';
      }else{
        return round($File) . 'B';
      }
    }
  }
  
  function GetFileDate($File){
    return DateFormat(filemtime($File));
  }
  
  function SeedTime($Time){
    $CalcTime = time()-$Time; //Second
    //echo $CalcTime;
    if(($SeedTime = $CalcTime/(60*60*24*7)) >= 1) return round($SeedTime) . ' ' . __('Week', TRUE);
    else if(($SeedTime = $CalcTime/(60*60*24)) >= 1) return round($SeedTime) . ' ' .__('Day', TRUE);
    else if(($SeedTime = $CalcTime/(60*60)) >= 1) return round($SeedTime) . ' ' .__('Hour', TRUE);
    else if(($SeedTime = $CalcTime/(60)) >= 1) return round($SeedTime) . ' ' .__('Min', TRUE);
    else return $CalcTime . ' ' .__('Sec', TRUE);
  }
  
  /*----------------------------------------------------------------------------------------------*/
  //RUN TORRENTS
  echo "<br /><br />";
  if($OpenDir = opendir($TorrentfileDir)) {
    $Dirs = array();
    $DirCount = str_replace("Resource id #", "", $OpenDir);
    while (FALSE !== ($DirName = readdir($OpenDir))){
      if ($DirName != "." && $DirName != ".." && !in_array($DirName, $DirException) && substr($DirName, 0, 1) != '.'){
        $Type = (filetype($TorrentfileDir.$DirName) == "dir") ? __('FileTypeDir', true) : __('FileTypeFile', true);
        $DType = (filetype($TorrentfileDir.$DirName) == "dir") ? 'dir' : 'file';
        if(strlen($DirName)>43) {
          $OutDirName = substr($DirName, 0, 40) . '...';
        }else{
          $OutDirName = $DirName;
        }
        
        $TorrentSelect = "SELECT t.*, u.username FROM " . DB_PREFIX . "torrents t JOIN users AS u ON u.id=t.userid WHERE t.torrentfile='" . $DirName . "' ORDER BY ins_dt DESC LIMIT 0,1";
        $DBTorrentData = $DB->query($TorrentSelect, "OBJ");   
        $SeedTime = SeedTime($DBTorrentData['data'][0]->ins_dt);
  
        $Dirs[] = array (
            $OutDirName,
            GetFileSize($TorrentfileDir.$DirName),
            $Type,
            str_replace('./../', '' , $TorrentfileDir.$OutDirName),
            GetFileDate($TorrentfileDir.$DirName),
            $DType,
            $DirName,
            DateFormat($DBTorrentData['data'][0]->ins_dt),
            $DBTorrentData['data'][0]->username,
            $SeedTime
        );
      }
    }
    closedir($TorrentfileDir);
  }else{
    $Dirs = FALSE;
  }
  $Rownum = 1;
  if($Dirs){
    foreach($Dirs as $DirData){
      if($DirData[5]== 'file'){
        $OwnerStyle = ($_SESSION['username'] == $DirData[8]) ? 'font-weight: bold;' : '';
        $FileIcon = '/style/icons/filetype-16x16/torrent.png';
        $TooltipText = '&lt;b&gt;' . __('FileSize', TRUE) . ': &lt;/b&gt;' . $DirData[1] . ' ('. $DirData[2] .') &lt;br /&gt;';
        $TooltipText .= '&lt;b&gt;' . __('FileDate', TRUE) . ': &lt;/b&gt;' . $DirData[4] . ' &lt;br /&gt;';
        $TooltipText .= '&lt;b&gt;' . __('Name', TRUE) . ': &lt;/b&gt;' . $DirData[6] . ' &lt;br /&gt;';
        $TooltipText .= '&lt;b&gt;' . __('TorrentAddDownolad', TRUE) . ': &lt;/b&gt;' . $DirData[7] . ' &lt;br /&gt;';
        $TooltipText .= '&lt;b&gt;' . __('TorrentOwner', TRUE) . ': &lt;/b&gt;' . $DirData[8];
        echo '<div class="torrentlist'  .$Rownum . '">';
        echo '<div class="tooltip" style="'. $OwnerStyle .'" title="' . $TooltipText . '">';
        echo '<img src="' . $FileIcon . '" border="0" />' . $DirData[0] . '<span style="float: right">' . __('InSeedTime', TRUE) . ' ' . $DirData[9] . '</span></div>';
        echo '</div>';
        $Rownum = ($Rownum == 1) ? 2 : 1;
      }
    }
  }else{
    echo __('NothingTorrents', FALSE);
  }
  
  ?>
