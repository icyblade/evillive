<?php
require_once "../config/config.inc.php";

class Guild {
	private static $SERVER_NAME;
	private static $GUILD_NAME;
	private static $MIN_RANK;
	
	public function __construct() {
		$this->SERVER_NAME = $GLOBALS['SERVER_NAME'];
		$this->GUILD_NAME = $GLOBALS['GUILD_NAME'];
		$this->MIN_RANK = $GLOBALS['MIN_RANK'];
	}
	
	public function get_guild_members() {
		//global $SERVER_NAME, $GUILD_NAME, $MIN_RANK;
		$url = sprintf('https://www.battlenet.com.cn/api/wow/guild/%s/%s?fields=members', rawurlencode($this->SERVER_NAME), rawurlencode($this->GUILD_NAME));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$html = curl_exec($ch);
		curl_close($ch);
		$json_data = json_decode($html, True);
		$members = array();
		foreach($json_data['members'] as $member) {
			if ($member['rank'] <= $this->MIN_RANK) {
				$members[] = $member['character']['name'];
			}
		}
		return array($this->SERVER_NAME, $members);
	}
}
?>