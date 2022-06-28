<?= $this->extend('layout/template')?>

<?= $this->section('content')?>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>MASTER DOWNTIME KATEGORI</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               MASTER DOWNTIME KATEGORI
                            </h2>
                           
                        </div>
                        <div class="body">
                            
                          
                            <div class="table-responsive">
                                <form id="download" method="get" action = "<?= base_url('staff/updateKategori');?>">
                                    <?= csrf_field(); ?>
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="material-icons"></i>Downtime Kategori
                                        </span>
                                        <div class="form-line">

                                            <!-- menyembunyikan /hidden id untuk di update -->
                                            <input type="hidden" class="form-control" name="edt_id_kategori" id = "edt_id_kategori" value="<?= $kategori->id ?>" >
                                            <input type="text" class="form-control" name="edt_nama_kategori" id = "edt_nama_kategori" value="<?= $kategori->downtime_kategori ?>" placeholder="masukkan kategori" required autofocus>
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