<?php

class db{
	var $con;
	function __construct($DB=array()){
		$Default = array(
			'host' => DB_HOST,
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_DB
		);
		$DB = array_merge($Default, $DB);
		$this->con = mysql_connect($DB['host'], 
                               $DB['user'],
                               $DB['pass'],
                               TRUE) or die ('Error connecting to MySQL! Nem lehet kapcsolódni az adatbázishoz!');
		mysql_select_db($DB['db'], $this->con) or die('Database ' . $DB['db'] . ' does not exist! A(z) ' . $DB['db'] . ' nevű adatbázis nem elérhető!');
		mysql_set_charset(DB_ENCODE, $this->con);
	}
	
	function close(){ //function __destruct(){
		mysql_close($this->con);
	}
	
  /*RETURN RESULT: OBJ->object, ARR->array*/
	function query($SqlString='', $DataType='OBJ', $Rows=FALSE, $Organize=TRUE){
    $DataType = strripos($SqlString, 'NSERT INTO ') ? FALSE : $DataType;
	  if($DataType == 'ARR'){
		  if(!$SqlQuery = mysql_query($SqlString, $this->con)){
			  return false;
		  }
		  if ($Rows !== FALSE){
			  $Rows = intval($Rows);
		  }
		  $Result = array();
      $Count = 0;
		  $Type = $Organize ? MYSQL_NUM : MYSQL_ASSOC;		
		  while(($Rows === FALSE || $Count < $Rows) && $Line=mysql_fetch_array($SqlQuery, $Type)){
				  foreach ($Line as $FieldID => $Value) {
					  $Table = mysql_field_table($SqlQuery, $FieldID);
						  if ($Table === ''){
							  $Table = 0;
						  }
					  $Field = mysql_field_name($SqlQuery, $FieldID);
					  $Result['data'][$Count][$Field] = $Value;
				  }
			  ++$Count;
		  }
		  $Result['rows'] = $Count;
	  }
	  elseif($DataType == 'OBJ'){
		  $CountObj = 0;
		  if($SqlQueryObj = mysql_query($SqlString, $this->con)){
			  while($LineObj = mysql_fetch_object($SqlQueryObj)){
				  $Result['data'][$CountObj] = $LineObj;
			    $CountObj++;
			  }
		  }
      $Result['rows'] = $CountObj;
	  }elseif($DataType == FALSE){
		  return $this->execute($SqlString);
	  }else{
		  return FALSE;
	  }
	  $Result['sql'] = $SqlString;
		return $Result;
	}

	function execute($SqlString=''){
		if(mysql_query($SqlString, $this->con)){ 
      return TRUE;
    }
		return FALSE;
	}

	function select($Options, $DataType='OBJ'){
		$Default = array (
			'table' => '',
			'fields' => DB_FIELDS,
			'condition' => DB_CONDITION,
			'order' => DB_ORDER,
			'limit' => DB_LIMIT
		);
		$Options = array_merge($Default, $Options);
		$Sql = "SELECT {$Options['fields']} FROM {$Options['table']} WHERE {$Options['condition']} ORDER BY {$Options['order']} LIMIT {$Options['limit']}";
		return $this->query($Sql, $DataType);
	}

	function row($Options, $DataType='OBJ'){
		$Default = array (
			'table' => '',
			'fields' => DB_FIELDS,
			'condition' => DB_CONDITION,
			'order' => DB_ORDER
		);
		$Options = array_merge($Default, $Options);
		$Sql = "SELECT {$Options['fields']} FROM {$Options['table']} WHERE {$Options['condition']} ORDER BY {$Options['order']}";
		$Result = $this->query($Sql, $DataType, 1, FALSE);
		if (empty($Result[0])){
      return FALSE;
    }
		return $Result[0];
	}

	function get($Table=null, $Field=null, $Conditions='1'){
		if ($Table === null || $Field === null){
      return FALSE;
    }
		$Result = $this->row(array(
			'table' => $Table,
			'condition' => $Conditions,
			'fields' => $Field
		));
		return (empty($Result[$Field])) ? FALSE : $Result[$Field];
	}

	function update($Table=null, $ArrayOfValues=array(), $Conditions='FALSE'){
		if($Table === null || empty($ArrayOfValues)){
      return FALSE;
    }
		$WhatToSet = array();
		foreach ($ArrayOfValues as $Field => $Value) {
			if(is_array($Value) && !empty($Value[0])){
        $WhatToSet[] = "`$Field`='{$Value[0]}'";
      }else{
        $WhatToSet[] = "`$Field`='" . mysql_real_escape_string($Value, $this->con) . "'";
      }
		}
		$WhatToSetString = implode(',', $WhatToSet);
		$ResultSql = "UPDATE $Table SET $WhatToSetString WHERE $Conditions";
		$UpdSql = $this->execute($ResultSql);
		$QueryStatus = $UpdSql ? TRUE : FALSE;
		return array('sql'=>$resultSql, 'query'=>$QueryStatus, 'error'=>mysql_error($this->con));
	}

	function insert($Table=null, $ArrayOfValues=array()){
		if($Table === null || empty($ArrayOfValues) || !is_array($ArrayOfValues)){
      return FALSE;
    }
		$Fields = array();
    $Values = array();
		foreach ($ArrayOfValues as $ID => $Value){
			$Fields[] = $ID;
			if(is_array($Value) && !empty($Value[0])){
        $Values[] = $Value[0];
      }else{
        $Values[]="'" . mysql_real_escape_string($Value, $this->con) . "'";
      }
		}
		$SqlInsert = "INSERT INTO $Table (" . implode(',', $Fields) . ') VALUES (' . implode(',', $Values) . ')';
		return (mysql_query($SqlInsert, $this->con)) ? mysql_insert_id($this->con) : FALSE;
	}

	function delete($Table=null, $Conditions='FALSE'){
		return ($Table === null) ? FALSE : $this->execute("DELETE FROM $Table WHERE $Conditions");
	}
}

//$DB->query(sprintf("SELECT * FROM users WHERE id=%2$d AND fname='%1$s'", $fname, $id), 'OBJ');
?>
