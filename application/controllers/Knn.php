<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include ("libraries/autoload.php");
use GroceryCrud\Core\GroceryCrud;
class Knn extends CI_Controller {
    var $footer = [];
    var $menu = [];
	function __construct() {
        parent::__construct();
        $database   = include ('database.php'); //config database Grocery
        $config     = include ('config.php'); //config library Grocery
        $this->crud = new GroceryCrud($config, $database); //initialize Grocery
    		$this->crud->unsetBootstrap();
    		$this->crud->unsetExport();
    		$this->crud->unsetPrint();
        $this->footer = array(
                            "copyright"=>APPNAME,
                            "aboutus"=>"#LinktoYour",
                            "contactus"=>"#LinktoContact",
                            "help"=>"#LinktoHelp"
                        );
        $this->menu = array(
                        "navbar"=>array(
                                "menu"=>array(
                                                array(
                                                "name"=>"Dashboard",
                                                "icon"=>"remixicon-dashboard-line",
                                                "link"=>base_url()."knn"
                                            ),
                                            array(
                                                "name"=>"KNN",
                                                "icon"=>"remixicon-honour-line",
                                                "link"=>base_url()."knn/process"
                                            ),
                                            array(
                                                "name"=>"Logout",
                                                "icon"=>"remixicon-honour-line",
                                                "link"=>base_url()."auth/logout"
                                            )
                                )
                            )
                        );
	}
    public function index(){
        $var['menu'] = $this->menu;
        $var['module'] = "knn/dashboard";
        $var['var_module'] = array();
        $var['content_title'] = "";
        $var['breadcrumb'] = array(
                "Home"=>"",
                "Dashboard"=>"active"
        );
        $var['footer'] = $this->footer;
        $this->load->view('main',$var);

    }
	public function process($page="dataset")
	{
      $var['menu'] = $this->menu;
      $var['module'] = "knn/process";
    	$var['var_module'] = array("page"=>$page);
      $var['content_title'] = "Metode K-NN";
    	$var['breadcrumb'] = array(
    			"Home"=>"",
    			"K-NN"=>"active"
    	);
      $var['footer'] = $this->footer;
	    $this->load->view('main',$var);
	}
  function history(){
    $var = array();
    $var['menu'] = $this->menu;
    $var['footer'] = $this->footer;
		$var['gcrud'] = 1;
		$var['content_title'] = "Data History";
		$var['breadcrumb'] = array(
			"Data History"=>""
		);
		$this->crud->setTable('history');
    $this->crud->unsetAdd();
    $this->crud->unsetEdit();
		$output = $this->crud->render();
		if ($output->isJSONResponse) {
				header('Content-Type: application/json; charset=utf-8');
				echo $output->output;
				exit;
		}
		$var['css_files']   = $output->css_files;
		$var['js_files']    = $output->js_files;
		$var['output']      = $output->output;
		$this->load->view('main',$var);
  }
  function export(){
    $this->load->view('module/export');
  }
  function debug(){
    $data = $this->session->userdata('process_dataset');
    $this->knn->init($data,[14,25],3);
    $result = $this->knn->predict();
    echo "<pre>";
    print_r($result);
    echo "</pre>";
  }
}
