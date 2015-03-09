<?php
class Dkp {
	public function __construct($id) {
		$this->id = addslashes($id);
	}
	
	public function get_total_dkp() {
		$mysql = new SaeMysql();
		$data = $mysql->getVar(sprintf('select sum(`DKP`) from `dkp` where `ID`="%s"', $this->id));
		$mysql->closeDb();
		return $data;
	}




}
?>