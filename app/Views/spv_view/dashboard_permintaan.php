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
                            <div class="table-responsive">
                               
                                <table class="table table-bordered table-striped table-hover js-exportable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Permintaan</th>
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Supervisor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($permintaan): ?>
                                    <?php $no = 1;
                                        foreach($permintaan as $lp): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $lp->tgl_permintaan; ?></td>
                                        <td><?php echo $lp->nama_barang . ' - '. $lp->jenis_barang; ?></td>
                                        <td><?php echo $lp->qty; ?></td>
                                        <td><?php echo $lp->nik_spv . ' - '. $lp->name ?></td>
                                        <td>
                                            <?php 
                                                //cek status approval
                                                if($lp->status == 0)
                                                {
                                            ?>
                                                <a href="<?= base_url('/spv/index_dashboard_permintaan/approvePermintaan/'.$lp->id)?>"class="btn btn-primary waves-effect">
                                                    <span>APPROVE</span></a>

                                                <a href="<?= base_url('/spv/index_dashboard_permintaan/rejectPermintaan/'.$lp->id)?>"class="btn btn-danger waves-effect">
                                                    <span>REJECT</span>
                                                </a>
                                            <?php
                                                }else if($lp->status == 1)
                                                {
                                            ?>
                                                <span class="label label-success">Approved</span>
                                            <?php
                                                }else{
                                            ?>
                                                <span class="label label-danger">Rejected</span>
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
</section>

<?= $this->endSection()?>



<script type="text/javascript">

jQuery(function($) {
        $('.js-exportable').DataTable({ 
            processing: true,
           
        });
});
    


   
</script>