<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 系统默认路径入口
 * @author 
 *
 */
class Index extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	}

	/**
	 * 
	 */
	public function index()
	{
        $this->views->display('index.html');
	}


	
}
