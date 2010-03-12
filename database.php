<?php 
class Database {
var $connection;


function Database()	{
      /* Make connection to database */
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
	 				}
					


function query($query)	{
	mysql_query("set names 'utf8'");
	mysql_query("SET character_set_client=utf8");
	mysql_query("SET character_set_connection=utf8");
	mysql_query("SET character_set_results=utf8");
	return mysql_query($query, $this->connection);
					   }



function load_settings(){
$q = "SELECT * FROM settings ORDER BY atribut";
$result = $this->query($q);
for($i = 0;$i != mysql_numrows($result);$i++)	{
define(strtoupper(mysql_result($result,$i,'atribut')), mysql_result($result,$i,'value'));
//echo strtoupper(mysql_result($result,$i,'atribut'))." = ".mysql_result($result,$i,'value')."<br />";
											}



						}


}



?>