<?php
/**
 * 采集时需要的辅助函数类
 * 
 * @copyright 2017-11-28
 */

/**
 * 自定义匹配单个
 * @param unknown $start 开始标识
 * @param unknown $end 结束标识
 * @param unknown $str 目标字符串
 * @return Ambigous <> 结果字符串
 */
function diy_preg_match($start, $end, $str) {
    $temp = explode ( $start, $str, 2 );
    $content = explode ( $end, $temp [1], 2 );
    return $content [0];
}

/**
 * 自定义匹配所有
 * @param unknown $start 开始标识
 * @param unknown $end 结束标识
 * @param unknown $str 目标字符串
 * @return Ambigous <> 结果数组
 */
function diy_preg_match_all($start, $end, $str) {
    $arr=array();
    while (diy_preg_match($start, $end, $str)){
        $temp = explode ( $start, $str, 2 );
        $content = explode ( $end, $temp [1], 2 );
        $arr[]=$content [0];
        $str=$temp [1];
    }
    return $arr;
}

/**
 * 根据远程url获取文件扩展名（用到的get_mimes方法只在ci中有效）
 * @param unknown $url
 */
function get_filetype($url){
	$mime = get_headers($url,1)["Content-Type"];
    $mines = get_mimes();
    foreach ($mines as $k=>$v){
        if ($mime==$v||(is_array($v)&&in_array($mime, $v))) {
            return $k;
        }
    }
    return FALSE;
}

/**
 * 下载文件到本地
 * @param unknown $url 远程地址
 * @param unknown $path 本地路径
 * @return string|unknown 成功的话返回本地文件地址，失败返回源地址
 */
function down_file($url,$path) {
    $filetype = get_filetype($url);
    if($filetype){
        if (!is_dir($path)){
            mkdir($path, 0777,TRUE);//如果路径不存在则递归创建
        }
        $filename=$path.date('Ymd-His').rand(1000,9999).".".$filetype;//组装文件地址
        $fp_output = fopen($filename, 'w');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp_output);
        $result=curl_exec($ch);
        $statusCode= curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($result!==FALSE&&$statusCode==200){//判断文件是否下载成功
            return "/".$filename;
        }
    }
    return FALSE;
}

/**
 * 文件大小格式化
 * @param number $size 初始文件大小，单位为byte
 * @param number $dec 保留小数位
 * @return string 格式化后的文件大小和单位数组，单位为byte、KB、MB、GB、TB
 */
function file_size_format($size = 0, $dec = 2) {
    $unit = array("B", "KB", "MB", "GB", "TB", "PB");
    $pos = 0;
    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }
    $result['size'] = round($size, $dec);
    $result['unit'] = $unit[$pos];
    return $result['size'].$result['unit'];
}
