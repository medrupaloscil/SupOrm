<?php

class MedruPDO extends PDO {

	public function prepareAndExecuteQuery($statement) {
		$sth = $this->prepare($statement);
		if ($sth->errorInfo()[2] != null) $this->logError($sth);
		$sth->execute();
		if ($sth->errorInfo()[2] != null) {
			$this->logError($sth);
		} else {
			$file = __DIR__."/../../app/logs/access.log";
			if (!file_exists($file)) {
				file_put_contents($file, "LOGS ACCESS: \n");
			}
			file_put_contents($file, date("\[d/m/y H:i:s\]")." : ".$statement." \n", FILE_APPEND);
			
		}
		return $sth;
	}

	public function logError($sth) {
		$file = __DIR__."/../../app/logs/error.log";
		if (!file_exists($file)) {
			file_put_contents($file, "LOGS ERRORS: \n");
		}
		file_put_contents($file, date("\[d/m/y H:i:s\]")." : ".$sth->errorInfo()[2]." \n", FILE_APPEND);
	}

}