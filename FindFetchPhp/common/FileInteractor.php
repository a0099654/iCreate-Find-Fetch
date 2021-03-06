<?php
namespace common;

class FileInteractor {
	public static function interactWithFile($mode, $src) {
		ini_set('display_errors', 1); 
		error_reporting(E_ALL);

		$handle = fopen($src, $mode);
		if ($handle) {
			$length = 4096;
			$lineNo = 0;
			while (($buffer = fgets($handle, $length)) !== false) {
				$lines[$lineNo] = $buffer;
				$lineNo++;
			}
			if (!feof($handle)) {
				die("Error: unexpected fgets() fail\n");
			}
			fclose($handle);
			
			return $lines;
		} else {
			die ("can't open file!");
			//return NULL;
		}	
	}
}
?>