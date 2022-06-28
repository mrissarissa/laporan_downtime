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
                                    <a href = "<?= base_url('/gl/dashboard/create_pengembalian') ?>" class="btn btn-default waves-effect m-r-20">Tambah Pengembalian</a>
                            
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
</section>

<?= $this->endSection()?>



<script type="text/javascript">

jQuery(function($) {
        $('.js-exportable').DataTable({ 
            processing: true,
           
        });
});
    


   
</script>