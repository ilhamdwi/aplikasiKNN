<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Knn_Model extends CI_Model {
  var $dataset = array();
  var $dataset_kolom = array();
  var $predict = array();
  var $k = array();
  public function init($data = NULL,$predict = NULL,$k = 3){
    $this->reset();
    $this->dataset = $data;
    $this->dataset_kolom = $this->session->userdata('process_datasetindex');
    $this->predict = $predict;
    $this->k = $k;
  }
  public function reset(){
    $this->dataset = array();
    $this->dataset_kolom = array();
    $this->predict = array();
    $this->k = array();
  }
  public function splitdataset(){
    $data_info = array();
    $data_attr = array();
    $data_label = array();
    foreach ($this->dataset as $key) {
      $temp_attr = array();
      foreach ($this->dataset_kolom as $keys=>$values) {
        if($keys==0){
          array_push($data_info,$key[$values]);
        }else if($keys==sizeof($this->dataset_kolom)-1){
          array_push($data_label,$key[$values]);
        }else{
          array_push($temp_attr,$key[$values]);
        }
      }
      array_push($data_attr,$temp_attr);
    }
    return array("data_info"=>$data_info,"data_attr"=>$data_attr,"data_label"=>$data_label);
  }
  public function eucdistance(){
    $datasplit = $this->splitdataset();
    $euclidean = array();
    foreach ($datasplit['data_attr'] as $key) {
      $euc_temp = array();
      foreach ($this->predict as $keys=>$values) {
          array_push($euc_temp,pow(abs($values-$key[$keys]),2));
      }
      array_push($euclidean,sqrt(array_sum($euc_temp)));
    }
    $datasplit['distance']=$euclidean;
    return $datasplit;
  }
  public function predict(){
    $hasil = $this->eucdistance();
    asort($hasil['distance']);
    $temp = array();
    $x=0;
    foreach ($hasil['distance'] as $key => $value) {
      if($x<$this->k){
        $temp[$key]=$value;
        $x++;
      }else{
        break;
      }
    }
    $hasil['result'] = $temp;
    return $hasil;
  }
}
