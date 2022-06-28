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
                                DASHBOARD PERMINTAAN BARANG
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a  href="#" data-toggle="modal" data-target="#defaultModal" class="btn btn-default waves-effect m-r-20" >Download Permintaan Barang</a>
                            
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            
                           
                               
                                <table class="table table-bordered table-striped table-hover js-exportable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User GL</th>
                                            <th>Tanggal Permintaan</th>
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Supervisor</th>
                                            <th>Status Pengeluaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($permintaan): ?>
                                    <?php $no = 1;
                                        foreach($permintaan as $lp): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $lp->nik_gl?> - <?php echo $lp->nama_gl ?></td>
                                        <td><?php echo $lp->tgl_permintaan; ?></td>
                                        <td><?php echo $lp->nama_barang . ' - '. $lp->jenis_barang; ?></td>
                                        <td><?php echo $lp->qty; ?></td>
                                        <td><?php echo $lp->nik_spv . ' - '. $lp->name ?></td>
                                        <td>
                                            <?php
                                            if($lp->tgl_pengeluaran_barang != null)
                                            {
                                            ?>
                                                <span class="label label-success">Pengeluaran Barang sudah dilakukan dengan qty <?= $lp->qty_keluar_barang ;?></span>
                                            <?php
                                            }else{
                                                ?>
                                                <a href="<?= base_url('/staff/indexPengeluaranBarang/'.$lp->id)?>"class="btn btn-primary waves-effect">
                                                    <span>Tambah Pengeluaran Barang </span>
                                                </a>
                                                <?php
                                            }
                                            ?>
                                            

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
                        <h4 class="modal-title" id="defaultModalLabel">Download Report</h4>
                    </div>
                    <div class="modal-body">
                        <form id="download" method="get" action = "<?= base_url('staff/exportPermintaan');?>">
                            <?= csrf_field(); ?>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">date_range</i>
                                </span>
                                <div class="form-line">
                                    <input type="date" class="form-control" name="date_from" id = "date_from" placeholder="Select Date From " required autofocus>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">date_range</i>
                                </span>
                                <div class="form-line">
                                    <input type="date" class="form-control" name="date_to" id ="date_to" placeholder="Select Date To " required autofocus>
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-link waves-effect">DOWNLOAD</button>
                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                            </div>
                            
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
</section>

<?= $this->endSection()?>



<script type="text/javascript">

jQuery(function($) {
        $('.js-exportable').DataTable({ 
            processing: true,
           
        });
});
    


   
</script>