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
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <button type="button" class="btn btn-default waves-effect m-r-20" data-toggle="modal" data-target="#defaultModal">Tambah Downtime Kategori</button>
                            
                                    <a  href="<?= base_url('/staff/exportKategori')?>" class="btn btn-default waves-effect m-r-20" >Download Downtime Kategori</a>
                            
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            
                          
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-exportable" id= "laporan" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Downtime Kategori</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if($kategori): ?>
                                    <?php $no = 1;
                                        foreach($kategori as $brg): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $brg->downtime_kategori; ?></td>
                                        <td>
                                            <a href="<?= base_url('staff/editKategori/'.$brg->id);?>" class="btn btn-info btn-sm btn-edit" >Edit</a>
                                            <a href="<?= base_url('staff/deleteKategori/'.$brg->id);?>" class="btn btn-danger btn-sm " >Delete</a>
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
                        <h4 class="modal-title" id="defaultModalLabel">Tambah Downtime Kategori</h4>
                    </div>
                    <div class="modal-body">
                        <form id="download" method="get" action = "<?= base_url('staff/saveDowntimeKategori');?>">
                            <?= csrf_field(); ?>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons"></i>
                                    Downtime Kategori
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="txt_kategori" id = "txt_kategori" placeholder="masukkan downtime kategori" required autofocus>
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