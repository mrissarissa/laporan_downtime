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
                            <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Tambah Stock</button>
                            <a  href="<?= base_url('/staff/exportStockBarang')?>" class="btn btn-default waves-effect m-r-20" >Download Stock Barang</a>
                            
                          
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-exportable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Qty</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($stock): ?>
                                    <?php $no = 1;
                                        foreach($stock as $key => $brg):
                                        ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $brg->nama_barang; ?></td>
                                        <td><?php echo $brg->jenis_barang; ?></td>
                                        <td><?php echo $brg->qty; ?></td>
                                        <td>
                                            <a href="<?= base_url('staff/editStock/'.$brg->id);?>" class="btn btn-info btn-sm btn-edit"  >Edit</a>
                                            <a href="<?= base_url('staff/deleteStockBarang/'.$brg->id);?>" class="btn btn-danger btn-sm " >Delete</a>
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
                        <h4 class="modal-title" id="defaultModalLabel">Tambah Stock Barang</h4>
                    </div>
                    <div class="modal-body">
                        <form id="download" method="get" action = "<?= base_url('staff/saveStockBarang');?>">
                            <?= csrf_field(); ?>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i>
                                    Nama Barang
                                </span>
                                <div class="form-line">
                                    
                                    <select class="form-control show-tick" id="nm_barang" name="nm_barang" data-live-search="true">
                                        <?php
                                        foreach($barang as $brg):
                                        ?>
                                        <option value="<?= $brg->id?>"><?= $brg->nama_barang ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i>
                                    Jenis Barang
                                </span>
                                <div class="form-line">
                                    <select class="form-control show-tick" id="jenis_barang" name="jenis_barang"  data-live-search="true">
                                        <?php
                                        foreach($jenis_barang as $brg):
                                        ?>
                                        <option value="<?= $brg->id?>"><?= $brg->jenis_barang ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i>
                                    Qty Barang
                                </span>
                                <div class="form-line">
                                    <input type="number" class="form-control" name="txt_qty" id = "txt_qty" placeholder="masukkan qty" required autofocus>
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