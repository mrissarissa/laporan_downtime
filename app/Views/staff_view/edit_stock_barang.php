<?= $this->extend('layout/template')?>

<?= $this->section('content')?>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>STOCK BARANG</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                STOCK BARANG
                            </h2>
                           
                        </div>
                        <div class="body">
                            
                          
                            <div class="table-responsive">
                                <form id="download" method="get" action = "<?= base_url('staff/updateStock');?>">
                                    <?= csrf_field(); ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons"></i>Nama Barang
                                        </span>
                                        <div class="form-line">

                                            <input type="text" class="form-control" name="edt_nama_brg" id = "edt_nama_brg" value="<?= $stock->nama_barang ?>" readonly required autofocus>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons"></i>Jenis Barang
                                        </span>
                                        <div class="form-line">

                                            <input type="text" class="form-control" name="edt_jenis_brg" id = "edt_jenis_brg" value="<?= $stock->jenis_barang ?>" readonly required autofocus>
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons"></i>Qty
                                        </span>
                                        <div class="form-line">

                                            <!-- menyembunyikan /hidden id untuk di update -->
                                            <input type="hidden" class="form-control" name="edt_id_stock" id = "edt_id_stock" value="<?= $stock->id ?>" >
                                            <input type="number" class="form-control" name="edt_qty" id = "edt_qty" value="<?= $stock->qty ?>" placeholder="masukkan nama barang" required autofocus>
                                        </div>
                                    </div>
                                    
                                    
                                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                        <button type="submit" class="btn btn-info waves-effect">Save</button>
                                        
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>

     

</section>



<?= $this->endSection()?>

<script type="text/javascript">



</script>