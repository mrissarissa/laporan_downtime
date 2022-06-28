<?= $this->extend('layout/template')?>

<?= $this->section('content')?>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Create Permintaan Barang
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                           
                            <form id = "form_laporan" name = "form_laporan"  action="<?= base_url('gl/dashboard/savePermintaan');?>"  method ="post" accept-charset="utf-8">
                                

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email_address">Nama</label>
                                            <div class="form-line">
                                                <?= csrf_field(); ?>
                                                <input type="text" class="form-control" id = "name" value ="<?= session()->get('name'); ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email_address">NIK</label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id = "nik" name = "nik" value ="<?= session()->get('nik'); ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email_address">Line Sewing</label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id = "line" name ="line" value ="<?= session()->get('line'); ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row clearfix">
                            

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email_address">Tanggal</label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id = "tgl_permintaan" name = "tgl_permintaan" value="<?= date("Y-m-d") ?>" readonly required/>
                                            </div>
                                        </div>
                            
                                    </div>
                                    

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email_address">Pilih Barang</label>
                                            <div class="form-line">
                                            <select class="form-control select-search" id="nm_barang" name="nm_barang"  data-live-search="true">
                                                <?php
                                                foreach($stock as $st):
                                                ?>
                                                <option value="<?= $st->id?>">      <?= $st->nama_barang ?> - <?= $st->jenis_barang ?> - Sisa Stock <?= $st->qty ?></option>

                                                <?php endforeach; ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email_address">Qty</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id = "qty" name = "qty" required/>
                                            </div>
                                        </div>
                            
                                    </div>  
                                    

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword2" >NIK Atasan</label>
                                            <div class="form-line">
                                                <select class="form-control show-tick" id = "nik_atasan" name = "nik_atasan">
                                                    <?php
                                                        foreach ($spv as $user) {

                                                        echo "<option value='".$user->nik."'>".$user->nik.' - '.$user->name."</option>";
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                  

                                
                                </div>
                                <button class="btn btn-primary waves-effect" id="btn_submit" type="submit">SUBMIT</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
</section>



<?= $this->endSection()?>

<script type="text/javascript">



</script>
