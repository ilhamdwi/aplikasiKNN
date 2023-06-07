<div class="row">
    <!-- Right Sidebar -->
    <div class="col-12">
        <div class="card-box">
            <!-- Left sidebar -->
            <div class="inbox-leftbar">
                <a href="#" class="btn btn-danger btn-block waves-effect waves-light">K-NN Menu</a>
                <div class="mail-list mt-4">
                    <a href="<?=base_url()?>knn/process/dataset" class="list-group-item border-0 <?=$page=='dataset'?'font-weight-bold':'';?>">1. Dataset</a>
                    <a href="<?=base_url()?>knn/process/init" class="list-group-item border-0 <?=$page=='init'?'font-weight-bold':'';?>">2. Initial Process</a>
                    <a href="<?=base_url()?>knn/process/prediksi" class="list-group-item border-0 <?=$page=='prediksi'?'font-weight-bold':'';?>">3. Prediksi</a>
                    <a href="<?=base_url()?>knn/process/performance" class="list-group-item border-0 <?=$page=='performance'?'font-weight-bold':'';?>">4. Performance</a>
                </div>
            </div>
            <!-- End Left sidebar -->
            <div class="inbox-rightbar">
            <?php
                //Dataset
                if($page == 'dataset'){
                ?>
                <div class="col-md-12">
                    <div class="card-box">
                      <h4>Pilih Data Excel</h4>
                      <small><a href="<?=base_url();?>assets/knn/data-knn-1.xlsx" target="_blank">Download contoh Format .xlsx</a></small>
                      <br>
                      <form enctype="multipart/form-data">
                          <input id="upload" type="file" name="files">
                          <button type="button" class="btn btn-primary btn-sm" id="upl" onclick="doupl()" style="display:none;">Upload</button>
                      </form>
                    </div>
                    <?php
                        if($this->session->userdata('process_dataset')!==NULL && $this->session->userdata('process_datasetindex')!==NULL){
                            $index = $this->session->userdata('process_datasetindex');
                            $dataset = $this->session->userdata('process_dataset');
                    ?>
                    <div class="card-box">
                      <h4>Dataset KNN</h4>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <?php
                                foreach ($index as $key) {
                                  ?>
                                   <th><?=$key?></th>
                                  <?php
                                }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($dataset as $key) {
                                ?>
                                <tr>
                                    <?php
                                     foreach ($index as $keys) {
                                        ?>
                                            <td><?=$key[$keys]?></td>
                                        <?php
                                     }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <?php } ?>
                  </div>
                <?php
                }
                if($page == 'init'){
                    ?>
                     <?php
                        if($this->session->userdata('process_dataset')!==NULL && $this->session->userdata('process_datasetindex')!==NULL){
                            $index = $this->session->userdata('process_datasetindex');
                            $dataset = $this->session->userdata('process_dataset');
                    ?>
                    <div class="card-box">
                      <h4>Initial Process</h4>
                      <table class="table table-border">
                        <thead>
                          <tr>
                            <?php
                                foreach ($index as $key) {
                                  ?>
                                   <th><?=$key?></th>
                                  <?php
                                }
                            ?>
                          </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td align="center"><b>--Atribut Info--</b></td>
                            <td align="center" style="border-right: 1px solid black;" colspan="<?=sizeof($index)-2?>"><b>--Atribut Pendukung--</b></td>
                            <td align="center"><b>--Label Target--</b></td>
                        </tr>
                            <?php
                            foreach ($dataset as $key) {
                                ?>

                                <tr>
                                    <?php
                                    $x=0;
                                     foreach ($index as $keys) {
                                        $x++;
                                        if($x==1){
                                          ?>
                                              <td class="table-danger"><?=$key[$keys]?></td>
                                          <?php
                                        }else if($x<sizeof($index)){
                                          ?>
                                              <td class="table-warning"><?=$key[$keys]?></td>
                                          <?php
                                        }else{
                                          ?>
                                              <td class="table-success"><?=$key[$keys]?></td>
                                          <?php
                                        }
                                     }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                    <?php } ?>
                    <?php
                }
                if($page == 'prediksi'){
                    if($this->session->userdata('process_dataset')!==NULL && $this->session->userdata('process_datasetindex')!==NULL){
                        $index = $this->session->userdata('process_datasetindex');
                        $dataset = $this->session->userdata('process_dataset');
                        foreach ($index as $key) {
                            $label[$key] = array_unique(array_column($dataset,$key));
                        }
                        ?>
                        <div class="card-box">
                            <div class="row">
                            <div class="col-md-6">
                            <h4>Prediksi</h4>
                            <form method="POST" action="">
                              <div class="form-group">
                               <label>Nilai K</label>
                                  <input type="number" class="form-control" name="k" value="<?=$this->input->post('k')!==NULL?$this->input->post('k'):'3'?>"/>
                              </div>
                              <hr />
                                <?php
                                $x=0;
                                foreach ($label as $key => $value) {
                                    $x++;
                                    if((sizeof($label))>$x){
                                      if($x==1){
                                        ?>
                                        <div class="form-group">
                                         <label><?=strtoupper($key)?></label>
                                            <input type="text" class="form-control" value="<?=$this->input->post('attr_info')!==NULL?$this->input->post('attr_info'):''?>" name="attr_info" required />
                                        </div>
                                        <?php
                                      }else{
                                        $sum = 0;
                                        if(isset($_POST['pred'])){
                                          foreach($_POST['pred'] as $value){
                                              $sum += $value;
                                          }
                                          echo "Total: " . $sum;
                                      }
                                        ?>
                                        <div class="form-group">
                                         <label><?=strtoupper($key)?></label>
                                            <input type="number" class="form-control" value="<?=isset($this->input->post('pred')[$x-2])&&$this->input->post('pred')[$x-2]!==NULL?$this->input->post('pred')[$x-2]:"Total: " . $sum;?>" name="pred[]" required/>
                                        </div>
                                        <?php
                                      }

                                    }
                                }
                            ?>
                            <div class="form-group">
                               <button class="btn btn-primary" name="prediksi" value="1" type="submit">Prediksi</button>
                            </div>
                            </form>
                            </div>
                            <div class="col-md-6">
                                <?php
                                    if($this->input->post('prediksi') !== NULL){
                                        $this->session->set_userdata("prediksi",true);
                                        $predict = $this->input->post('pred');
                                        $this->knn->init($dataset,$predict,$this->input->post('k'));
                                        $result = $this->knn->predict();
                                        ?>
                                        <h4>Hasil</h4>
                                        <div class="card card-body bg-primary text-white">
                                        <h4 class="card-title mb-2 text-white" align="center">Hasil Jarak Tetangga Terdekat</h4>
                                        <ul>
                                          <?php
                                          foreach ($result['result'] as $key => $value) {
                                            ?>
                                              <li><?=strtoupper($this->knn->dataset_kolom[0])?> <?=$result['data_info'][$key]?>
                                                <ul>
                                                  <li>Jarak : <?=$value?></li>
                                                  <li><?=ucfirst($this->knn->dataset_kolom[sizeof($this->knn->dataset_kolom)-1])?> : <?=$result['data_label'][$key]?></li>
                                                </ul>
                                              </li>
                                            <?php
                                          }
                                          // echo "<pre>";
                                          // print_r($result['result']);
                                          // echo "</pre>";
                                          ?>
                                        </ul>
                                          <h4 class="card-title mb-2 text-white" align="center">Hasil Prediksi KNN</h4>
                                            <?php
                                            foreach ($result['result'] as $key => $value) {
                                              ?>
                                                <h4 class="text-white" align="center"><?=$result['data_label'][$key]?></h4>
                                              <?php
                                              break;
                                            }
                                            // echo "<pre>";
                                            // print_r($result['result']);
                                            // echo "</pre>";
                                            ?>
                                        </div>


                                      <!-- hasil prediksi -->
                                        <?php
                                        if($this->session->userdata('prediksi')==true){
                                          // $temp = array();
                                          // $temp['uniqid'] = uniqid();
                                          // $labels = array_keys($label);
                                          // $x=0;
                                          // foreach ($labels as $key) {
                                          //   if($x<sizeof($labels)-1){
                                          //     $temp[$key] = $predict[$x];
                                          //   }else{
                                          //     $temp[$key] = $prediksi;
                                          //   }
                                          //   $x++;
                                          // }
                                          // $this->db->insert("naivebayes_history",
                                          //   array(
                                          //     "history"=>json_encode($temp)
                                          // ));
                                          $this->session->set_userdata("prediksi",false);
                                        }
                                    }
                                ?>
                            </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                if($page == 'performance'){
                    if($this->session->userdata('process_dataset')!==NULL && $this->session->userdata('process_datasetindex')!==NULL){
                      $index = $this->session->userdata('process_datasetindex');
                      $dataset = $this->session->userdata('process_dataset');
                      foreach ($index as $key) {
                          $label[$key] = array_unique(array_column($dataset,$key));
                      }
                    ?>
                       <div class="card-box">
                            <div class="row">
                            <div class="col-md-6">
                            <h4>Uji Akurasi Metode</h4>
                            <form method="POST" action="" id="performance">
                                <div class="form-group">
                                    <label id="lab">Prosentase Data Training <?=$this->input->post('train')!==NULL?$this->input->post('train').'%, Data Testing '.(100-$this->input->post('train')).'%':''?></label>
                                    <select name="train" required="" onchange="if($(event.target).val()!=''){$('#lab').html('Prosentase Data Training '+$(event.target).val()+'%, Data Testing '+(100-$(event.target).val())+'%');$('#performance').submit();}else{$('#lab').html('Prosentase Data Training');}" class="form-control">
                                       <option value="">-- Pilih Prosentase --</option>
                                       <option value="10" <?=$this->input->post('train')==10?'selected':''?>>10 %</option>
                                       <option value="20" <?=$this->input->post('train')==20?'selected':''?>>20 %</option>
                                       <option value="30" <?=$this->input->post('train')==30?'selected':''?>>30 %</option>
                                       <option value="40" <?=$this->input->post('train')==40?'selected':''?>>40 %</option>
                                       <option value="50" <?=$this->input->post('train')==50?'selected':''?>>50 %</option>
                                       <option value="60" <?=$this->input->post('train')==60?'selected':''?>>60 %</option>
                                       <option value="70" <?=$this->input->post('train')==70?'selected':''?>>70 %</option>
                                       <option value="80" <?=$this->input->post('train')==80?'selected':''?>>80 %</option>
                                       <option value="90" <?=$this->input->post('train')==90?'selected':''?>>90 %</option>
                                    </select>
                                </div>
                            </form>
                            </div>
                            <div class="col-md-6">

                            </div>
                            </div>
                        </div>
                        <?php if($this->input->post('train')!==NULL){ ?>
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Pemisahan Data Training & Testing</h4>
                                    <?php
                                        $train = $this->input->post('train');
                                        $countdata = sizeof($dataset);
                                        $ndatatrain = ($train/100)*$countdata;
                                        $ndatatrain = floor($ndatatrain);
                                        $newtraindata = [];
                                    ?>
                                    <table class="table table-border">
                                        <thead>
                                          <tr>
                                            <?php
                                                foreach ($index as $key) {
                                                  ?>
                                                   <th><?=$key?></th>
                                                  <?php
                                                }
                                            ?>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td align="center" colspan="<?=sizeof($index)?>"><b>--Data Training--</b></td>
                                        </tr>
                                            <?php
                                            $x=0;$flagtesting=0;
                                            foreach ($dataset as $key) {
                                                $x++;
                                                if($ndatatrain>=$x){
                                                ?>
                                                <tr>
                                                    <?php
                                                    $newtraindata_temp=[];
                                                    foreach ($index as $keys) {
                                                        $newtraindata_temp[$keys]=$key[$keys];
                                                    ?>
                                                        <td class="table-primary"><?=$key[$keys]?></td>
                                                    <?php
                                                    }
                                                    $newtraindata[]=$newtraindata_temp;
                                                    ?>
                                                </tr>
                                                <?php
                                                }else{
                                                ?>
                                                <?php if($flagtesting==0){$flagtesting++; ?>
                                                <tr>
                                                <td align="center" colspan="<?=sizeof($index)?>"><b>--Data Testing--</b></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <?php
                                                    foreach ($index as $keys) {
                                                    ?>
                                                        <td class="table-warning"><?=$key[$keys]?></td>
                                                    <?php
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <h4 class="mt-3">Proses Testing</h4>
                                    <table class="table table-border">
                                        <thead>
                                          <tr>
                                            <?php
                                                foreach ($index as $key) {
                                                  ?>
                                                   <th><?=$key?></th>
                                                  <?php
                                                }
                                            ?>
                                            <th>Hasil Testing</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $x=0;$benar=0;
                                            foreach ($dataset as $key) {
                                                $x++;
                                                if($x>$ndatatrain){
                                                ?>
                                                <tr>
                                                    <?php
                                                    $predict=[];
                                                    $predict_sisa=[];
                                                    $o=0;
                                                    foreach ($index as $keys) {
                                                      if($o>0 && $o<sizeof($index)-1){
                                                        $predict[]=$key[$keys];
                                                      }else{
                                                        $predict_sisa[]=$key[$keys];
                                                      }
                                                      $o++;
                                                    ?>
                                                        <td class="table-warning"><?=$key[$keys]?></td>
                                                    <?php
                                                    }

                                                    $pop = array_pop($predict_sisa);
                                                    $this->knn->init($newtraindata,$predict,3);
                                                    $result = $this->knn->predict();
                                                    $hasil_knn = "";
                                                    foreach ($result['result'] as $key => $value) {
                                                      $hasil_knn = $result['data_label'][$key];
                                                      break;
                                                    }
                                                    ?>
                                                    <td class="table-primary">
                                                    <?php
                                                        if($hasil_knn==$pop){$benar++;}
                                                        echo $hasil_knn;
                                                    ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                    <hr />
                                    <?php
                                        $akurasi=$benar/(sizeof($dataset)-$ndatatrain)*100;
                                    ?>
                                    <div class="card card-body <?php if($akurasi<60){echo 'bg-danger';}else if($akurasi<80){echo 'bg-warning';}else{echo 'bg-primary';} ?> text-white">
                                        <h4 class="card-title mb-0 text-white">Hasil Akurasi : <?=round($akurasi,3)?>%</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php
                }
              }
            ?>
            </div>
            <div class="clearfix"></div>
        </div> <!-- end card-box -->
    </div> <!-- end Col -->
</div>
