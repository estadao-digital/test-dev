<?php

namespace App\Models;

class ReadWriteDataBase
{
	public function write($data){
		$db = 'carros.txt';
		$file = fopen($db, 'a');
		$data.= PHP_EOL;
		fwrite($file, $data);
		fclose($file);
		return true;
	}

	public function read(){
		$db = 'carros.txt';
		try{
			$file = fopen($db, 'r');
			if($file){
				$content = fread($file, filesize($db));
				fclose($file);
				return $content;
			}
		}
		catch(\Exception $e){
			return false;
		}
	}

	public function delete($id){
		$db = 'carros.txt';
		$data = '';
		try{
			$file = fopen($db, 'r');
			if($file){
				while (($line = fgets($file)) !== false) {
					$pos = strpos($line, 'ID:'.$id.',');
			        if ($pos >= 0 && $pos !== false){
			        	//Exclui
			        }else{
			        	$data .= $line;
			        }
			    }
			}
			fclose($file);
			unlink($db);
			$file = fopen($db, 'a');
			fwrite($file, $data);
		}
		catch(\Exception $e){
			return false;
		}
	}

}
