<?php
require_once "../config/config.inc.php";
require_once "../lib/simple_html_dom/simple_html_dom.php";

class Player {
	private $id;
	private $SERVER_NAME;
	
	public function __construct($id) {
		$this->SERVER_NAME = $GLOBALS['SERVER_NAME'];
		$this->id = addslashes($id);
	}

	pubLic function get_max_item_lvl() {
		if ($GLOBALS['METHOD'] == 'API') {
			return $this->get_max_item_lvl_api();
		} elseif ($GLOBALS['METHOD'] == 'ARMONY') {
			return $this->get_max_item_lvl_armony();
		} else {
			return -1;
		}
	}
	
	// 从战网 API 获取最高装等
	private function get_max_item_lvl_api() {
		$url = sprintf('https://www.battlenet.com.cn/api/wow/character/%s/%s?fields=items', rawurlencode($this->SERVER_NAME), rawurlencode($this->id));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$html = curl_exec($ch);
		curl_close($ch);
		$json_data = json_decode($html, True);
		return $json_data['items']['averageItemLevel'];
	}
	
	// 从英雄榜获取最高装等
	private function get_max_item_lvl_armony() {
		$url = sprintf('http://www.battlenet.com.cn/wow/zh/character/%s/%s/simple', rawurlencode($this->SERVER_NAME), rawurlencode($this->id));
		$html = file_get_html($url);
		return $html->find('div.summary-averageilvl', 0)->find('div#summary-averageilvl-best', 0)->plaintext;
	}
	
	public function get_current_item_lvl() {
		if ($GLOBALS['METHOD'] == 'API') {
			return $this->get_current_item_lvl_api();
		} elseif ($GLOBALS['METHOD'] == 'ARMONY') {
			return $this->get_current_item_lvl_armony();
		} else {
			return -1;
		}
	}
	
	// 从战网 API 获取当前装等
	private function get_current_item_lvl_api() {
		$url = sprintf('https://www.battlenet.com.cn/api/wow/character/%s/%s?fields=items', rawurlencode($this->SERVER_NAME), rawurlencode($this->id));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$html = curl_exec($ch);
		curl_close($ch);
		$json_data = json_decode($html, True);
		return $json_data['items']['averageItemLevelEquipped'];
	}
	
	// 从英雄榜获取当前装等
	private function get_current_item_lvl_armony() {
		$url = sprintf('http://www.battlenet.com.cn/wow/zh/character/%s/%s/simple', rawurlencode($this->SERVER_NAME), rawurlencode($this->id));
		$html = file_get_html($url);
		return $html->find('div.summary-averageilvl', 0)->find('span.equipped', 0)->plaintext;
	}
	
	public function get_class() {
		$mysql = new SaeMysql();
		$class = $mysql->getVar(sprintf('select `CLASS` from `raider_list` where `ID`="%s";', $this->id));
		if ($class) {
			$mysql->closeDb();
			return $class;
		} else {
			$class = $this->get_class_api();
			// TODO
			$mysql->runSql(sprintf('insert into `raider_list` values ("%s", "%s", "");', $this->id, $class));
			$mysql->closeDb();
			return $class;
		}
	}
	
	// 从战网 API 获取职业
	private function get_class_api() {
		$class_list = array('NONE', 'WARRIOR', 'PALADIN', 'HUNTER', 'ROGUE', 'PRIEST', 'DEATHKNIGHT', 'SHAMAN', 'MAGE', 'WARLOCK', 'MONK', 'DRUID');
		$url = sprintf('https://www.battlenet.com.cn/api/wow/character/%s/%s', rawurlencode($this->SERVER_NAME), rawurlencode($this->id));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$html = curl_exec($ch);
		curl_close($ch);
		$json_data = json_decode($html, True);
		return $class_list[intval($json_data['class'])];
	}
}
?>