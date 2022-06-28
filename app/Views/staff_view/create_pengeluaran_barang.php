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
                                Create Pengeluaran Barang
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
                            <div class="info-box bg-pink hover-expand-effect">
                                <div class="icon">
                                    <i class="material-icons">playlist_add_check</i>
                                </div>
                                <div class="content">
                                    <div class="text">STOCK BARANG TERSEDIA</div>
                                    <div class="number count-to" ><?= $permintaan->qty_stock?></div>
                                </div>
                            </div>
                           
                            <form id = "form_laporan" name = "form_laporan"  action="<?= base_url('staff/approvePengeluaranBarang');?>"  method ="post" accept-charset="utf-8">
                                

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email_address">Nama</label>
                                            <div class="form-line">
                                                <?= csrf_field(); ?>
                                                <input type="text" class="form-control" id = "name" value ="<?= $permintaan->nama_gl ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email_address">NIK</label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id = "nik" name = "nik" value ="<?= $permintaan->nik_gl ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email_address">Line Sewing</label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id = "line" name ="line" value ="<?= $permintaan->line ?>" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="row clearfix">
                            

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email_address">Tanggal Permintaan</label>
                                            <div class="form-line">
                                                <input type="date" class="form-control" id = "tgl_permintaan" name = "tgl_permintaan" value="<?= $permintaan->tgl_permintaan?>" readonly required/>
                                            </div>
                                        </div>
                            
                                    </div>
                                    

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email_address">Nama Barang</label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id = "barang" name = "barang" readonly value="<?= $permintaan->nama_barang?> - <?= $permintaan->jenis_barang?>" required/>
                                            </div>
                                        </div>
                                    </div>  
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email_address">Qty Permintaan</label>
                                            <div class="form-line">
                                                <input type="number" class="form-control" id = "qty" name = "qty" value="<?= $permintaan->qty ?>" readonly required/>
                                            </div>
                                        </div>
                            
                                    </div>  
                                    

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword2" >NIK Atasan</label>
                                            <div class="form-line">
                                                <input type="text" class="form-control" id = "qty" name = "qty" value="<?= $permintaan->nik_spv ?> - <?= $permintaan->nama_spv ?>" readonly required/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="email_address">Qty Pengeluaran</label>
                                            <div class="form-line">
                                                <input type="hidden" class="form-control" id = "id_permintaan" name = "id_permintaan" value = "<?= $permintaan->id ?>"required/>
                                                <input type="number" class="form-control" id = "qty_pengeluaran" name = "qty_pengeluaran" min="1" max ="<?= $permintaan->qty_stock ?>" value="<?= $permintaan->qty ?>"  required/>
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
