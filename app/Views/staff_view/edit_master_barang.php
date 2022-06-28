<?= $this->extend('layout/template')?>

<?= $this->section('content')?>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>MASTER BARANG</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               MASTER BARANG
                            </h2>
                           
                        </div>
                        <div class="body">
                            
                          
                            <div class="table-responsive">
                                <form id="download" method="get" action = "<?= base_url('staff/updateBarang');?>">
                                    <?= csrf_field(); ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons"></i>Nama Barang
                                        </span>
                                        <div class="form-line">

                                            <!-- menyembunyikan /hidden id untuk di update -->
                                            <input type="hidden" class="form-control" name="edt_id_barang" id = "edt_id_barang" value="<?= $barang->id ?>" >
                                            <input type="text" class="form-control" name="edt_nama_barang" id = "edt_nama_barang" value="<?= $barang->nama_barang ?>" placeholder="masukkan nama barang" required autofocus>
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