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
                                <button type="button" class="btn btn-danger waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Download Report</button>
                            
                          
                            </ul>
                        </div>
                        <div class="body">
                           
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Created at</th>
                                            <th>Tanggal Laporan</th>
                                            <th>Style</th>
                                            <th>Probem</th>
                                            <th>Problem Deskripsi</th>
                                            <th>Problem Category</th>
                                            <th>Lossting (menit)</th>
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
                                        <td><?php 
                                            //cek status approval
                                            if($lp->status == 0)
                                            {
                                            ?>
                                                <span class="label label-info">Belum di Approve</span>
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
                        <form id="download" method="get" action = "<?= base_url('staff/dashboard/export');?>">
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
