<?= $this->extend('layout/template')?>

<?= $this->section('content')?>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>MASTER DOWNTIME DESKRIPSI</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                            MASTER DOWNTIME DESKRIPSI
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <button type="button" class="btn btn-primary waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Tambah Downtime Deskripsi</button>
                                    <a  href="<?= base_url('/staff/exportDeskripsi')?>" class="btn btn-danger waves-effect m-r-20" >Download Downtime Deskripsi</a>
                            
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            
                          
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-exportable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Downtime Deskripsi</th>
                                            <th>Downtime Kategori</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($deskripsi): ?>
                                    <?php $no = 1;
                                        foreach($deskripsi as $key => $brg):
                                        ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $brg->downtime_deskripsi; ?></td>
                                        <td><?php echo $brg->downtime_kategori; ?></td>
                                        <td>
                                             <a href="<?= base_url('staff/deleteDeskripsi/'.$brg->id);?>" class="btn btn-danger btn-sm " >Delete</a>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>

        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Tambah Downtime Deskripsi</h4>
                    </div>
                    <div class="modal-body">
                        <form id="download" method="get" action = "<?= base_url('staff/saveDowntimeDeskripsi');?>">
                            <?= csrf_field(); ?>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i>
                                    Nama Barang
                                </span>
                                <div class="form-line">
                                    
                                    <input type="text" class="form-control" name="txt_downtime_deskrispi" id = "txt_downtime_deskrispi" placeholder="masukkan downtime deskripsi" required autofocus>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i>
                                    Downtime Kategori
                                </span>
                                <div class="form-line">
                                    <select class="form-control show-tick" id="downtime_kategori" name="downtime_kategori"  data-live-search="true">
                                        <?php
                                        foreach($kategori as $brg):
                                        ?>
                                        <option value="<?= $brg->id?>"><?= $brg->downtime_kategori ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                          
                            
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                                <button type="submit" class="btn btn-info waves-effect">Save</button>
                                
                            </div>
                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>


</section>



<?= $this->endSection()?>

<script src="<?php echo base_url()?>/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="<?php echo base_url()?>/plugins/multi-select/js/jquery.multi-select.js"></script>

<script type="text/javascript">


    jQuery(function($) {
            $('.js-exportable').DataTable({ 
                processing: true,
            
            });
    });




</script>