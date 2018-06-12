<?php
/**
 * ocr身份证识别
 */
require_once 'libraries/ocr/AipOcr.php';
function ocr($url){
	$aipOcr = new AipOcr('10111867', '7VGu0Npwpo9cFl5sACmFsj3h', 'T7quHUoAkyT9ucQnyKocAOQyRivr0TMI');
	return $aipOcr->idcard(file_get_contents($url), true);
}
