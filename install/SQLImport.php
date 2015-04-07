<?php

 // SQLImporter
 // Version 1.1
 // V1.0 Author: Rubén Crespo Álvarez - rumailster@gmail.com
 // Updated by: Yannick Luescher, hivemail.com

 /******************************************************************************************
 * Possibility to select dbase when creating an object instance:
 * -------------------------------------------------------------
 * $db = new sqlImport('dump.sql', false, 'localhost', 'testuser', 'testpass', 'testdbase');
 * $db->import();
 * if ($db->error) exit($db->error);
 * else echo "<b>Data written successfully</b>";
 * -------------------------------------------------------------
 * Now working with both /r/n resp. /n line endings (to make it work with /r see php.net)
 * Now working when using ; inside SQL statements
 * Check parameter added to output what would be written into dbase.
 * If host isn't set the active connection will be used (if any) as always.
 /******************************************************************************************/

 class sqlImport {

 	// param $check bool: echo the sql statements instead of writing them into dbase

 	// Constructor
 	function sqlImport($SqlArchive, $check = false, $host = false, $user = false, $pass = false,
 		$database = false) {
 		$this->host = $host;
 		$this->database = $database;
 		$this->user = $user;
 		$this->pass = $pass;
 		$this->SqlArchive = $SqlArchive;
 		$this->check = $check;
 	}

 	// Connnect
 	function dbConnect() {
 		$this->con = @mysql_connect($this->host, $this->user, $this->pass);
 		if (!$this->con) {
 			$this->error = "<b>Error (dbConnect): " . mysql_error() . "</b>";
 		}
 	}

 	// Select dbase
 	function select_db() {
 		$result = @mysql_select_db($this->database);
 		if (!$result) {
 			$this->error = "<b>Error (select_db): " . mysql_error() . "</b>";
 		}
 	}

 	// Import Data
 	function import() {

 		// Connect if $host is set, else we're using the active connection (if any) !
 		if ($this->host) {
 			$this->dbConnect();
 			if ($this->error)
 				return;
 		}

 		// Select dbase if $database is set, can be set via sql as well
 		if ($this->database) {
 			$this->select_db();
 			if ($this->error)
 				return;
 		}

 		// For existing connections $this->con is false...
 		if ($this->con !== false || $this->check) {

 			// To avoid problems we're reading line by line ...
 			$lines = file($this->SqlArchive, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
 			$buffer = '';
 			foreach ($lines as $line) {
 				// Skip lines containing EOL only
 				if (($line = trim($line)) == '')
 					continue;

 				// skipping SQL comments
 				if (substr(ltrim($line), 0, 2) == '--')
 					continue;

 				// An SQL statement could span over multiple lines ...
 				if (substr($line, -1) != ';') {
 					// Add to buffer
 					$buffer .= $line;
 					// Next line
 					continue;
 				} else
 					if ($buffer) {
 						$line = $buffer . $line;
 						// Ok, reset the buffer
 						$buffer = '';
 					}

 				// strip the trailing ;
 				$line = substr($line, 0, -1);

 				// Write the data
 				if (!$this->check)
 					$result = mysql_query($line);
 				// or print it out
 				else {
 					echo substr($line, 0, 180) . ((strlen($line) > 180) ? "...<br>" : "<br>");
 					$this->error = "<b>No data has been written (check = true)</b>";
 				}

 				if (!$result and !$this->check) {
 					$this->error = "<b>Error (mysql_query): " . mysql_error() . "</b>";
 					return;
 				}
 			}
 		}
 	}
 }

?>