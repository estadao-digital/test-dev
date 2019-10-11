<?php
/**
 * A quick little function to interact with a MySQL database.
 * Updated by Xavi Esteve to use mysqli, original by AngeloR (https://gist.github.com/AngeloR/919695)
 * 
 * When working with Limonade-php a full-fledged MySQL wrapper seems like
 * overkill. This method instead accepts any mysql statement and if it works
 * returns either the result or the number of rows affected. If neither worked,
 * then it returns false
 *
 * @param   string      $sql    the sql statement you want to execute
 * @param   resource    $c      mysql connect link identifier, if multi-connect
 *                              otheriwse, you can leave it blank
 * @return  MIXED       array   the result set if the sql statement was a SELECT
 *                      integer if the sql statement was INSERT|UPDATE|DELETE
 *                      bool    if anything went wrong with executing your statement
 *
 * Usage:
 * // First start the connection
 * $c = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
 * 
 * // Now run your queries
 * [update|insert|delete]
 * if(db('UPDATE mytable SET myrow = 4 WHERE someotherrow = 3', $c) !== false) {
 *  // worked!
 * }
 *
 * [select]
 * $res = db('select * from mytable', $c);
 * echo $res[0]['id'];
 */



function check_database_is_installed($c) {
	$c = mysqli_connect("localhost", "root", "teste123", "carros");
	$installed_ = (mysqli_query($c, 'SELECT 1 FROM carros LIMIT 1;')=="") ? false : true;
	if(!$installed_) {
		#First access, installing database...
		$sql = file_get_contents('table_carros_plain_sql_builder_seeder.sql');

		if ($c->multi_query($sql)) {
			echo "Installation complete.";
		} else {
			echo "Erros installing database.";
			die();
		}
	}
}
check_database_is_installed();

function db ($sql, $c) {
	$c = mysqli_connect("localhost", "root", "teste123", "carros");
    $res = false;
	$q = ($c === null)?@mysqli_query($sql):@mysqli_query($c,$sql);

	if($q) {
		if(strpos(strtolower($sql),'select') === 0) {
			$res = array();
			while($r = mysqli_fetch_assoc($q)) {
				$res[] = $r;
			}
		} else {
			$res = ($c === null)?mysqli_affected_rows():mysqli_affected_rows($c);
		}
	}
	if(!empty($res))
		return json_encode($res);
	else
		return false;
}
