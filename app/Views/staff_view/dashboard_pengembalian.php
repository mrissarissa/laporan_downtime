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
                                DASHBOARD PENGEMBALIAN BARANG
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a  href="#" class="btn btn-default waves-effect m-r-20"  data-toggle="modal" data-target="#defaultModal" >Download Pengembalian Barang</a>
                            
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                            
                            
                                <table class="table table-bordered table-striped table-hover js-exportable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Pengembalian</th>
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Kondisi Barang</th>
                                            <th>Keterangan Barang</th>
                                            <th>Supervisor</th>
                                            
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($pengembalian): ?>
                                    <?php $no = 1;
                                        foreach($pengembalian as $lp): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $lp->tgl_pengembalian; ?></td>
                                        <td><?php echo $lp->nama_barang . ' - '. $lp->jenis_barang; ?></td>
                                        <td><?php echo $lp->qty; ?></td>
                                        <td><?php echo $lp->kondisi_barang; ?></td>
                                        <td><?php echo $lp->keterangan_kondisi; ?></td>
                                        <td><?php echo $lp->nik_spv . ' - '. $lp->name ?></td>
                                        <td><?php 
                                            //cek status approval
                                            if($lp->status_app_admin == 0)
                                            {
                                            ?>
                                             <a href="<?= base_url('/staff/index_dashboard_pengembalian/approvePengembalian/'.$lp->id)?>" class="btn btn-primary waves-effect">
                                                
                                                <span>APPROVE</span>
                                            </a>
                                            <a href="<?= base_url('/staff/index_dashboard_pengembalian/rejectPengembalian/'.$lp->id)?>"class="btn btn-danger waves-effect">
                                                    <span>REJECT</span>
                                            </a>
                                            <?php
                                            }else if($lp->status_app_admin == 1)
                                            {
                                            ?>
                                                <span class="label label-success">Approved</span>
                                                
                                            <?php
                                            }else{
                                            ?>
                                                <span class="label label-danger">Rejected</span>
                                            <?php
                                            }
                                         ?></td>
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
                        <form id="download" method="get" action = "<?= base_url('/staff/exportPengembalian')?>">
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