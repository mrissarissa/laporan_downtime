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
                            LAPORAN HARIAN DOWNTIME
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
                                            <th>Created at</th>
                                            <th>Tanggal Laporan</th>
                                            <th>Style</th>
                                            <th>Probem</th>
                                            <th>Problem Deskripsi</th>
                                            <th>Problem Category</th>
                                            <th>Lossting</th>
                                            <th>Barang</th>
                                            <th>Supervisor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($laporan): ?>
                                    <?php $no = 1;
                                        foreach($laporan as $lp): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $lp->created_at; ?></td>
                                        <td><?php echo $lp->tgl_laporan; ?></td>
                                        <td><?php echo $lp->style; ?></td>
                                        <td><?php echo $lp->problem; ?></td>
                                        <td><?php echo $lp->problem_deskripsi; ?></td>
                                        <td><?php echo $lp->problem_kategori; ?></td>
                                        <td><?php echo $lp->lossting; ?></td>
                                        <td><?php echo $lp->nama_barang . ' - '. $lp->jenis_barang; ?></td>
                                        <td><?php echo $lp->nik_spv . ' - '. $lp->name ?></td>
                                        <td>
                                        <?php 
                                            //cek status approval
                                            if($lp->status == 0)
                                            {
                                        ?>
                                            <a href="<?= base_url('/spv/dashboard/approve/'.$lp->id)?>"><button type="button" class="btn btn-primary waves-effect">
                                                <i class="material-icons">done</i>
                                                <span>APPROVE</span>
                                            </button></a>

                                            <a href="<?= base_url('/spv/dashboard/reject/'.$lp->id)?>"><button type="button" class="btn btn-danger waves-effect">
                                                <i class="material-icons">clear</i>
                                                <span>REJECT</span>
                                            </button></a>
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
    $(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

   
});
</script>