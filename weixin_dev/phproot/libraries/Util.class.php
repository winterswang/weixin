<?php
class Util{
	static function dgmdate($timestamp) {

		$todaytimestamp = TIMESTAMP - TIMESTAMP % 86400;
		$s = gmdate('m-d', $timestamp);
		$time = TIMESTAMP - $timestamp;

		if($timestamp >= $todaytimestamp) {
			if($time > 3600) {
				return intval($time / 3600).' 小时前';
			} elseif($time > 1800) {
				return '半小时前';
			} elseif($time > 60) {
				return intval($time / 60).' 分钟前';
			} elseif($time > 0) {
				return $time.' 秒前';
			} elseif($time == 0) {
				return '刚刚';
			} else {
				return $s;
			}
		} elseif(($days = intval(($todaytimestamp - $timestamp) / 86400)) >= 0 && $days < 7) {
			if($days == 0) {
				return '昨天&nbsp;'.gmdate('H:i', $timestamp);
			} elseif($days == 1) {
				return '前天&nbsp;'.gmdate('H:i', $timestamp);
			} else {
				return ($days + 1).'&nbsp;天前';
			}
		} else {
			return $s;
		}
	}

}