<?= $this->extend('layout/template')?>

<?= $this->section('content')?>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>MASTER JENIS BARANG</h2>
            </div>

            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               MASTER JENIS BARANG
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
                            <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Tambah Barang</button>
                            <a  href="<?= base_url('/staff/exportJenisBarang')?>" class="btn btn-default waves-effect m-r-20" >Download Master Barang</a>
                            
                            
                          
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-exportable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Barang</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($barang): ?>
                                    <?php $no = 1;
                                        foreach($barang as $brg): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $brg->jenis_barang; ?></td>
                                        <td>
                                            <a href="<?= base_url('staff/editJenisBarang/'.$brg->id);?>" class="btn btn-info btn-sm btn-edit"  >Edit</a>
                                            <a href="<?= base_url('staff/deleteJenisBarang/'.$brg->id);?>" class="btn btn-danger btn-sm " >Delete</a>
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
                        <h4 class="modal-title" id="defaultModalLabel">Tambah Jenis Barang</h4>
                    </div>
                    <div class="modal-body">
                        <form id="download" method="get" action = "<?= base_url('staff/saveJenisBarang');?>">
                            <?= csrf_field(); ?>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i>
                                    Jenis Barang
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="txt_nama_barang" id = "txt_nama_barang" placeholder="masukkan nama barang" required autofocus>
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

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Edit Barang</h4>
                    </div>
                    <div class="modal-body">
                        <form id="download" method="get" action = "#">
                            <?= csrf_field(); ?>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i> Nama Barang
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="edt_id" id = "edt_id" required autofocus>
                                    <input type="text" class="form-control id" name="edt_nama_barang" id = "edt_nama_barang" placeholder="masukkan nama barang" required autofocus>
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

<script type="text/javascript">

$(document).ready(function(){
    $('.btn-edit').on('click', function(){
        const id = $(this).data('id');
        console.log(id);
        $('#edt_id').val(id);
        $('#editModal').modal('show');
    });
});

jQuery(function($) {
        $('.js-exportable').DataTable({ 
            processing: true,
           
        });
});



</script>