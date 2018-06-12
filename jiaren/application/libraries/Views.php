<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
require_once ('Smarty/Smarty.class.php');

/**
 * 自定义SMARTY支持
 *
 * @author Administrator
 *
 */
class Views extends Smarty {
    function __construct() {
        parent::__construct ();
        // 模板存放目录,本人直接用的是CI的views目录，当然可以用templates也行。
        $this->template_dir = APPPATH . "views";
        // 编译目录，在application下需要新建此目录
        $this->compile_dir = APPPATH . "cache";
        // 缓存目录。
        $this->cache_dir = APPPATH . "cache";
        $this->caching = 0;
        // $this->cache_lifetime = 120; //缓存更新时间
        // $this->debugging = true;
        // 检查当前的模板是否自上次编译后被更改；如果被更改了，它将重新编译该模板。
        $this->compile_check = true;
        // $this->force_compile = true; //强制重新编译模板
        //$this->allow_php_templates= true; //开启PHP模板
        // 左定界符
        $this->left_delimiter = "<{";
        // 右定界符
        $this->right_delimiter = "}>";
    }
}