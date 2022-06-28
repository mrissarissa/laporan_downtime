<?php namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;

use App\Models\LaporanModel;
use App\Models\UserModel;
use App\Models\SPVModel;
use App\Models\MasterBarangModel;
use App\Models\MasterJenisBarangModel;
use App\Models\StockBarangModel;
use App\Models\PermintaanBarangModel;
use App\Models\PengembalianBarangModel;
use App\Models\MasterKategoriModel;
use App\Models\MasterDeskripsiModel;

class StaffController extends BaseController {

    public function __construct()
	{
		helper(['form', 'url']);
        $this->session = \Config\Services::session();
        $this->session->start();
	}

    public function index()
    {
          //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new LaporanModel();
          
        $data['laporan'] = $db->query("SELECT laporan.nik_gl, laporan.created_at, laporan.tgl_laporan, laporan.style,
        laporan.problem, laporan.problem_deskripsi, laporan.problem_kategori, laporan.lossting, laporan.status, spv.name, laporan.nik_spv,
        mb.nama_barang, mjb.jenis_barang, laporan.id
        from laporan
        left join spv on spv.nik = laporan.nik_spv
        left join stock_barang sb on sb.id = laporan.id_barang
        left join master_barang mb on mb.id = sb.id_barang
        left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang 
        where laporan.deleted_at is null")->getResult();
        return view('staff_view/dashboard', $data);
    }

    public function export() {
        //get data tgl
        $date_from = $this->request->getVar('date_from');
        $date_to   = $this->request->getVar('date_to');
  

        //menghubungkan ke tabel model
        $builder = new LaporanModel();
   
        $query = $builder->query("SELECT *, mb.nama_barang, mjb.jenis_barang FROM laporan 
                    left join stock_barang sb on sb.id = laporan.id_barang
                    left join master_barang mb on mb.id = sb.id_barang
                    left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang
                    where laporan.deleted_at is null
                    and laporan.tgl_laporan BETWEEN '$date_from' and '$date_to'");
        $users = $query->getResult();

         
        $fileName = 'LAPORAN_DOWNTIME.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK GL');
        $sheet->setCellValue('B1', 'NAMA GL');
        $sheet->setCellValue('C1', 'Line');
        $sheet->setCellValue('D1', 'Style');
        $sheet->setCellValue('E1', 'Tgl Laporan');
        $sheet->setCellValue('F1', 'Problem');
        $sheet->setCellValue('G1', 'Nama Barang - Jenis Barang');
        $sheet->setCellValue('H1', 'Lossting (Menit)');
        $sheet->setCellValue('I1', 'Problem Deskripsi');
        $sheet->setCellValue('J1', 'Problem Kategori');
        $sheet->setCellValue('K1', 'NIK SPV');
        $sheet->setCellValue('L1', 'NAMA SPV');
        $sheet->setCellValue('M1', 'STATUS');
      
        $rows = 2;
        
        foreach ($users as $val){
            //get nama GL
            $builder = new UserModel();
            $name_gl = $builder->where('nik', $val->nik_gl)->first();
            
    
            $sheet->setCellValue('A' . $rows, $val->nik_gl);
            $sheet->setCellValue('B' . $rows, $name_gl->name);
            $sheet->setCellValue('C' . $rows, 'LINE '.$val->line);
            $sheet->setCellValue('D' . $rows, $val->style);
            $sheet->setCellValue('E' . $rows, $val->tgl_laporan);
            $sheet->setCellValue('F' . $rows, $val->problem);
            $sheet->setCellValue('G' . $rows, $val->nama_barang.' - '.$val->jenis_barang);
            $sheet->setCellValue('H' . $rows, $val->lossting.' menit');
            $sheet->setCellValue('I' . $rows, $val->problem_deskripsi);
            $sheet->setCellValue('J' . $rows, $val->problem_kategori);

            //get nama SPV
            $builder = new SPVModel();
            $name_spv = $builder->where('nik', $val->nik_spv)->first();

            $sheet->setCellValue('K' . $rows, $val->nik_spv);
            $sheet->setCellValue('L' . $rows, $name_spv->name);
            $status = '';
            if($val->status ==0)
            {
                $status = "Belum di Approve";
            }else if($val->status ==1)
            {
                $status = "Approved";
            }else {
                $status = "Ditolak";
            }
            $sheet->setCellValue('M' . $rows, $status);


            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    public function index_master_barang()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new MasterBarangModel();
        $data['barang'] = $db->query("SELECT * from master_barang where deleted_at is null")->getResult();
        return view('staff_view/master_barang', $data );
    }

    public function saveBarang()
    {

        $nama_barang = $this->request->getVar('txt_nama_barang');

     
        $mbarang_db = new MasterBarangModel();

        //ambil id terakhir untuk create id baru + 1
        $result = $mbarang_db->select('max(id) as id')->first();
        $count_id = null;
        foreach ($result as $key => $rs) {
            $count_id = $rs;
            
        }
       
        
        if($count_id != null)
        {
            // var_dump($c_id)['id'];
            // die();
            // $int_id = (int)$c_id[0]->id;
            $int_id = (int)$count_id;
            $id = $int_id+1;
        }else{
            $id = 1;
        }
        $nik = $this->session->get('nik');
        
        $mbarang_db->insert([
            'id' => $id,
            'create_by' => $nik,
            'nama_barang'  => $nama_barang,
            'created_at' => time::now(),
            // 'deleted_at'=> null
        ]);
        return redirect()->to('/staff/index_master_barang');
    




    }


    public function editBarang($id)
    {
        $db = new MasterBarangModel();
        $db->where('id', $id);
        $data['barang'] = $db->first();
        return view('staff_view/edit_master_barang', $data );
    }

    public function updateBarang()
    {
        $id_barang = $this->request->getVar('edt_id_barang');
        $nama_barang = $this->request->getVar('edt_nama_barang');

        $db = new MasterBarangModel();
        $db->set('nama_barang', $nama_barang);
        $db->where('id', $id_barang);
        $updateBarang = $db->update();

        return redirect()->to('/staff/index_master_barang');

    }

    public function deleteBarang($id)
    {
        $mbarang_db = new MasterBarangModel();
        $mbarang_db->set('deleted_at', time::now());
        $mbarang_db->where('id', $id);
        $update = $mbarang_db->update();

        return redirect()->to('/staff/index_master_barang');
    
    }
    

    public function index_master_jenis_barang()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new MasterJenisBarangModel();
        $data['barang'] = $db->query("SELECT * from master_jenis_barang where deleted_at is null")->getResult();
        return view('staff_view/master_jenis_barang', $data );
    }

    public function saveJenisBarang()
    {

        $nama_barang = $this->request->getVar('txt_nama_barang');

     
        $mbarang_db = new MasterJenisBarangModel();

        //ambil id terakhir untuk create id baru + 1
        $result = $mbarang_db->select('max(id) as id')->first();
        $count_id = null;
        foreach ($result as $key => $rs) {
            $count_id = $rs;
            
        }
       
        
        if($count_id != null)
        {
            // var_dump($c_id)['id'];
            // die();
            // $int_id = (int)$c_id[0]->id;
            $int_id = (int)$count_id;
            $id = $int_id+1;
        }else{
            $id = 1;
        }
        $nik = $this->session->get('nik');
        
        $mbarang_db->insert([
            'id' => $id,
            'create_by' => $nik,
            'jenis_barang'  => $nama_barang,
            'created_at' => time::now(),
            // 'deleted_at'=> null
        ]);
        return redirect()->to('/staff/index_master_jenis_barang');
    




    }

    public function editJenisBarang($id)
    {
        $db = new MasterJenisBarangModel();
        $db->where('id', $id);
        $data['jns_barang'] = $db->first();
        return view('staff_view/edit_master_jenis_barang', $data );
    }

    public function updateJenisBarang()
    {
        $id_jenisbarang = $this->request->getVar('edt_id_barang');
        $jenis_barang = $this->request->getVar('edt_jenis_barang');

        $db = new MasterJenisBarangModel();
        $db->set('jenis_barang', $jenis_barang);
        $db->where('id', $id_jenisbarang);
        $updateBarang = $db->update();

        return redirect()->to('/staff/index_master_jenis_barang');

    }


    public function deleteJenisBarang($id)
    {
        $mbarang_db = new MasterJenisBarangModel();
        $mbarang_db->set('deleted_at', time::now());
        $mbarang_db->where('id', $id);
        $update = $mbarang_db->update();

        return redirect()->to('/staff/index_master_jenis_barang');
    
    }

    public function index_stock_barang()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new StockBarangModel();
        $data['stock'] = $db->query("SELECT mb.nama_barang, mjb.jenis_barang, stock_barang.qty, stock_barang.id from stock_barang
                        left join master_barang mb on mb.id=stock_barang.id_barang
                        left join master_jenis_barang mjb on mjb.id = stock_barang.id_jenis_barang
                        where stock_barang.deleted_at is null")->getResult();
        $data['barang'] = $db->query("SELECT * from master_barang where deleted_at is null")->getResult();
        $data['jenis_barang'] = $db->query("SELECT * from master_jenis_barang where deleted_at is null")->getResult();
        return view('staff_view/stock_barang_v', $data );
    }

    public function saveStockBarang()
    {

        $nama_barang = $this->request->getVar('nm_barang');
        $jenis_barang = $this->request->getVar('jenis_barang');
        $qty = $this->request->getVar('txt_qty');

     
        $stock = new StockBarangModel();

        //ambil id terakhir untuk create id baru + 1
        $result = $stock->select('max(id) as id')->first();
        $count_id = null;
        foreach ($result as $key => $rs) {
            $count_id = $rs;
            
        }
       
        
        if($count_id != null)
        {
            // var_dump($c_id)['id'];
            // die();
            // $int_id = (int)$c_id[0]->id;
            $int_id = (int)$count_id;
            $id = $int_id+1;
        }else{
            $id = 1;
        }
        $nik = $this->session->get('nik');
        
        $stock->insert([
            'id' => $id,
            'id_barang' => $nama_barang,
            'id_jenis_barang'=> $jenis_barang,
            'qty' => $qty,
            'created_at' => time::now(),
            // 'deleted_at'=> null
        ]);
        return redirect()->to('/staff/index_stock_barang');
    




    }

    public function editStock($id)
    {
        $db = new StockBarangModel();
        $db->where('stock_barang.id', $id);
        $db->join('master_barang', 'master_barang.id = stock_barang.id_barang');
        $db->join('master_jenis_barang', 'master_jenis_barang.id = stock_barang.id_jenis_barang');
        $db->select('stock_barang.id, master_barang.nama_barang, master_jenis_barang.jenis_barang,stock_barang.qty');
        $data['stock'] = $db->first();
        return view('staff_view/edit_stock_barang', $data );
    }

    public function updateStock()
    {
        $id_stock = $this->request->getVar('edt_id_stock');
        $qty = $this->request->getVar('edt_qty');

        $db = new StockBarangModel();
        $db->set('qty', $qty);
        $db->where('id', $id_stock);
        $updateBarang = $db->update();

        return redirect()->to('/staff/index_stock_barang');

    }


    public function deleteStockBarang($id)
    {
        $db = new StockBarangModel();
        $db->set('deleted_at', time::now());
        $db->where('id', $id);
        $update = $db->update();

        return redirect()->to('/staff/index_stock_barang');
    
    }

    public function index_dashboard_permintaan()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new PermintaanBarangModel();
        $data['permintaan'] = $db->query("SELECT permintaan_barang.id,permintaan_barang.nik_gl, permintaan_barang.created_at, permintaan_barang.tgl_permintaan, 
            permintaan_barang.qty, spv.name, permintaan_barang.nik_spv,permintaan_barang.status,
            mb.nama_barang, mjb.jenis_barang, permintaan_barang.tgl_pengeluaran_barang, permintaan_barang.qty_keluar_barang,users.name as nama_gl
            from permintaan_barang
            left join spv on spv.nik = permintaan_barang.nik_spv
            left join stock_barang sb on sb.id = permintaan_barang.id_stock
            left join master_barang mb on mb.id = sb.id_barang
            left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang 
            left join users on users.nik = permintaan_barang.nik_gl
            where permintaan_barang.deleted_at is null and permintaan_barang.status = '1'")->getResult();
        return view('staff_view/dashboard_permintaan', $data );
    }

    public function indexPengeluaranBarang($id)
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new PermintaanBarangModel();
        $db->where('permintaan_barang.id', $id);
        $db->join('users','users.nik=permintaan_barang.nik_gl');
        $db->join('spv','spv.nik=permintaan_barang.nik_spv');
        $db->join('stock_barang','stock_barang.id=permintaan_barang.id_stock');
        $db->join('master_barang','master_barang.id=stock_barang.id_barang');
        $db->join('master_jenis_barang','master_jenis_barang.id=stock_barang.id_jenis_barang');
        $db->select('permintaan_barang.*,users.name as nama_gl, spv.name as nama_spv, master_barang.nama_barang, master_jenis_barang.jenis_barang, stock_barang.qty as qty_stock');
        $data['permintaan'] = $db->first();
        // dd($data);
        return view('staff_view/create_pengeluaran_barang', $data );
    }

    

    public function approvePengeluaranBarang()
    {
        $nik = $this->session->get('nik');
        $id_permintaan = $this->request->getVar('id_permintaan');
        $qty_pengeluaran = $this->request->getVar('qty_pengeluaran');


        $db = new PermintaanBarangModel();
        $db->where('id', $id_permintaan);
        $db->set('tgl_pengeluaran_barang', time::now());
        $db->set('user_keluar_barang', $nik);
        $db->set('qty_keluar_barang', $qty_pengeluaran);
        $updated = $db->update();

        //get id stock
        $db->where('id', $id_permintaan);
        $getStock = $db->first();
        // dd($getStock->id_stock);

        //get qty di tabel stock
        $stocks = new StockBarangModel();
        $stocks->where('id', $getStock->id_stock);
        $getQtyStock = $stocks->first();

        //ngurangin stock
        $intGetQtyStock = (int)$getQtyStock->qty;
        $intQtyKeluar = (int)$qty_pengeluaran;
        $updatedStock = $intGetQtyStock - $intQtyKeluar;

        //update stock di tabel stock
        $stocks->where('id', $getStock->id_stock);
        $stocks->set('qty', $updatedStock);
        $updatedQtyStock = $stocks->update();


        return redirect()->to('/staff/index_dashboard_permintaan');
        
    }

    //memanggil halaman dashboard pengeluaran 
    public function index_dashboard_pengeluaran()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new PermintaanBarangModel();
        $data['permintaan'] = $db->query("SELECT permintaan_barang.id,permintaan_barang.nik_gl, permintaan_barang.created_at, permintaan_barang.tgl_permintaan, 
            permintaan_barang.qty, spv.name, permintaan_barang.nik_spv,permintaan_barang.status,
            mb.nama_barang, mjb.jenis_barang, permintaan_barang.tgl_pengeluaran_barang, permintaan_barang.qty_keluar_barang,
            users.name as nama_gl
            from permintaan_barang
            left join spv on spv.nik = permintaan_barang.nik_spv
            left join stock_barang sb on sb.id = permintaan_barang.id_stock
            left join master_barang mb on mb.id = sb.id_barang
            left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang 
            left join users on users.nik = permintaan_barang.nik_gl
            where permintaan_barang.deleted_at is null and permintaan_barang.status = '1' 
            and permintaan_barang.tgl_pengeluaran_barang is not null")->getResult();
        return view('staff_view/dashboard_pengeluaran', $data );
    }

    public function index_dashboard_pengembalian()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new PengembalianBarangModel();
        $data['pengembalian'] = $db->query("SELECT pengembalian_barang.id,pengembalian_barang.nik_gl, pengembalian_barang.created_at, pengembalian_barang.tgl_pengembalian, 
            pengembalian_barang.qty, spv.name, pengembalian_barang.nik_spv,pengembalian_barang.status,
            mb.nama_barang, mjb.jenis_barang,pengembalian_barang.kondisi_barang, pengembalian_barang.keterangan_kondisi,pengembalian_barang.status_app_admin
            from pengembalian_barang
            left join spv on spv.nik = pengembalian_barang.nik_spv
            left join stock_barang sb on sb.id = pengembalian_barang.id_stock
            left join master_barang mb on mb.id = sb.id_barang
            left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang 
            where pengembalian_barang.deleted_at is null and pengembalian_barang.status = '1'")->getResult();
        return view('staff_view/dashboard_pengembalian', $data );
    }

    public function approvePengembalian($id)
    {
        $db = new PengembalianBarangModel();

        $db->set('status_app_admin', 1);
        $db->where('id', $id);
        $update = $db->update();

        //get id stock
        $db->where('id', $id);
        $getIdStocks = $db->first();

        //get qty stock
        $stock = new StockBarangModel();
        $stock->where('id', $getIdStocks->id_stock);
        $getQtyStock = $stock->first();

        //nambah stock pengembalian
        $intQtyStock = (int)$getQtyStock->qty;
        $intQtyPengembalian = (int)$getIdStocks->qty;
        $totalQtyStock = $intGetQtyStock + $intQtyPengembalian;

        //update qty stock
        $stock->where('id', $getIdStocks->id_stock);
        $stock->set('qty', $totalQtyStock);
        $updatedStock = $stock->update();

        return $this->response->redirect(site_url('/staff/index_dashboard_pengembalian'));
    }

    public function rejectPengembalian($id)
    {
        $db = new PengembalianBarangModel();

        $db->set('status_app_admin', 2);
        $db->where('id', $id);
        $update = $db->update();

        return $this->response->redirect(site_url('/staff/index_dashboard_pengembalian'));
    }

    public function exportBarang() {
  
        //menghubungkan ke tabe l model
        $builder = new MasterBarangModel();
        $builder->where('deleted_at', null);
        $barang = $builder->findAll();
        
        // dd($barang);
         
        $fileName = 'LAPORAN_MASTER_BARANG.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NAMA BARANG');
        $rows = 2;
        
        foreach ($barang as $br){
            
    
            $sheet->setCellValue('A' . $rows, $br->nama_barang);
           
            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    public function exportJenisBarang() {
  
        //menghubungkan ke tabe l model
        $builder = new MasterJenisBarangModel();
        $builder->where('deleted_at', null);
        $barang = $builder->findAll();
        
        // dd($barang);
         
        $fileName = 'LAPORAN_MASTER_JENIS_BARANG.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'JENIS BARANG');
        $rows = 2;
        
        foreach ($barang as $br){
            
    
            $sheet->setCellValue('A' . $rows, $br->jenis_barang);
           
            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    public function exportStockBarang() {
  
        //menghubungkan ke tabe l model
        $builder = new StockBarangModel();
        $builder->where('stock_barang.deleted_at', null);
        $builder->join('master_barang','master_barang.id=stock_barang.id_barang');
        $builder->join('master_jenis_barang','master_jenis_barang.id=stock_barang.id_jenis_barang');
        $builder->select('master_barang.nama_barang, master_jenis_barang.jenis_barang,stock_barang.qty');
        $barang = $builder->findAll();
        
        // dd($barang);
         
        $fileName = 'LAPORAN_MASTER_STOCK_BARANG.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NAMA BARANG');
        $sheet->setCellValue('B1', 'JENIS BARANG');
        $sheet->setCellValue('C1', 'JENIS BARANG');

        $rows = 2;
        
        foreach ($barang as $br){
            
    
            $sheet->setCellValue('A' . $rows, $br->nama_barang);
            $sheet->setCellValue('B' . $rows, $br->jenis_barang);
            $sheet->setCellValue('C' . $rows, $br->qty);
           
            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    
    public function exportPermintaan() {
        //get data tgl
        $date_from = $this->request->getVar('date_from');
        $date_to   = $this->request->getVar('date_to');
  
  
        //menghubungkan ke tabe l model
        $builder = new PermintaanBarangModel();
        $builder->where('permintaan_barang.deleted_at', null);
        $builder->where("permintaan_barang.tgl_permintaan between '$date_from' and '$date_to'", null, false);
        $builder->where('permintaan_barang.status','1');
        $builder->join('stock_barang','stock_barang.id=permintaan_barang.id_stock');
        $builder->join('master_barang','master_barang.id=stock_barang.id_barang');
        $builder->join('master_jenis_barang','master_jenis_barang.id=stock_barang.id_jenis_barang');
        $builder->join('spv', 'spv.nik=permintaan_barang.nik_spv');
        $builder->join('users', 'users.nik = permintaan_barang.nik_gl');
        $builder->select('master_barang.nama_barang, master_jenis_barang.jenis_barang, permintaan_barang.*, spv.name as nama_spv, users.name as nama_gl ');
        $barang = $builder->findAll();
        
        // dd($barang);
         
        $fileName = 'LAPORAN_PERMINTAAN_BARANG.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK_GL');
        $sheet->setCellValue('B1', 'NAMA_GL');
        $sheet->setCellValue('C1', 'LINE');
        $sheet->setCellValue('D1', 'TGL_PERMINTAAN');
        $sheet->setCellValue('E1', 'NAMA_BARANG');
        $sheet->setCellValue('F1', 'JENIS_BARANG');
        $sheet->setCellValue('G1', 'QTY_PERMINTAAN');
        $sheet->setCellValue('H1', 'STATUS_PERMINTAAN');
        $sheet->setCellValue('I1', 'TGL_PENGELUARAN_BARANG');
        $sheet->setCellValue('J1', 'USER_KELUAR_BARANG');
        $sheet->setCellValue('K1', 'QTY_PENGELUARAN');
        $sheet->setCellValue('L1', 'NIK_SPV');
        $sheet->setCellValue('M1', 'NAMA_SPV');



        $rows = 2;
        
        foreach ($barang as $br){
            
    
            $sheet->setCellValue('A' . $rows, $br->nik_gl);
            $sheet->setCellValue('B' . $rows, $br->nama_gl);
            $sheet->setCellValue('C' . $rows, $br->line);
            $sheet->setCellValue('D' . $rows, $br->tgl_permintaan);
            $sheet->setCellValue('E' . $rows, $br->nama_barang);
            $sheet->setCellValue('F' . $rows, $br->jenis_barang);
            $sheet->setCellValue('G' . $rows, $br->qty);
            if($br->status == '0')
            {
                $status_new = 'Belum di Approve';
            }else if($br->status == '1')
            {
                $status_new = 'Approved';
            }else{
                $status_new = 'Gagal';
            }
            $sheet->setCellValue('H' . $rows, $status_new);
            $sheet->setCellValue('I' . $rows, $br->tgl_pengeluaran_barang);
            $sheet->setCellValue('J' . $rows, $br->user_keluar_barang);
            $sheet->setCellValue('K' . $rows, $br->qty_keluar_barang);
            $sheet->setCellValue('L' . $rows, $br->nik_spv);
            $sheet->setCellValue('M' . $rows, $br->nama_spv);
           
            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    public function exportPengeluaran() {
         //get data tgl
         $date_from = $this->request->getVar('date_from');
         $date_to   = $this->request->getVar('date_to');
  
        //menghubungkan ke tabe l model
        $builder = new PermintaanBarangModel();
        $builder->where('permintaan_barang.deleted_at', null);
        $builder->where('permintaan_barang.tgl_pengeluaran_barang is not null',null,false );
        $builder->where("permintaan_barang.tgl_pengeluaran between '$date_from' and '$date_to'", null, false);
        $builder->where('permintaan_barang.status','1');
        $builder->join('stock_barang','stock_barang.id=permintaan_barang.id_stock');
        $builder->join('master_barang','master_barang.id=stock_barang.id_barang');
        $builder->join('master_jenis_barang','master_jenis_barang.id=stock_barang.id_jenis_barang');
        $builder->join('spv', 'spv.nik=permintaan_barang.nik_spv');
        $builder->join('users', 'users.nik = permintaan_barang.nik_gl');
        $builder->select('master_barang.nama_barang, master_jenis_barang.jenis_barang, permintaan_barang.*, spv.name as nama_spv, users.name as nama_gl ');
        $barang = $builder->findAll();
        
        // dd($barang);
         
        $fileName = 'LAPORAN_PENGELUARAN_BARANG.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK_GL');
        $sheet->setCellValue('B1', 'NAMA_GL');
        $sheet->setCellValue('C1', 'LINE');
        $sheet->setCellValue('D1', 'TGL_PERMINTAAN');
        $sheet->setCellValue('E1', 'NAMA_BARANG');
        $sheet->setCellValue('F1', 'JENIS_BARANG');
        $sheet->setCellValue('G1', 'QTY_PERMINTAAN');
        $sheet->setCellValue('H1', 'STATUS_PERMINTAAN');
        $sheet->setCellValue('I1', 'TGL_PENGELUARAN_BARANG');
        $sheet->setCellValue('J1', 'USER_KELUAR_BARANG');
        $sheet->setCellValue('K1', 'QTY_PENGELUARAN');
        $sheet->setCellValue('L1', 'NIK_SPV');
        $sheet->setCellValue('M1', 'NAMA_SPV');



        $rows = 2;
        
        foreach ($barang as $br){
            
    
            $sheet->setCellValue('A' . $rows, $br->nik_gl);
            $sheet->setCellValue('B' . $rows, $br->nama_gl);
            $sheet->setCellValue('C' . $rows, $br->line);
            $sheet->setCellValue('D' . $rows, $br->tgl_permintaan);
            $sheet->setCellValue('E' . $rows, $br->nama_barang);
            $sheet->setCellValue('F' . $rows, $br->jenis_barang);
            $sheet->setCellValue('G' . $rows, $br->qty);
            if($br->status == '0')
            {
                $status_new = 'Belum di Approve';
            }else if($br->status == '1')
            {
                $status_new = 'Approved';
            }else{
                $status_new = 'Gagal';
            }
            $sheet->setCellValue('H' . $rows, $status_new);
            $sheet->setCellValue('I' . $rows, $br->tgl_pengeluaran_barang);
            $sheet->setCellValue('J' . $rows, $br->user_keluar_barang);
            $sheet->setCellValue('K' . $rows, $br->qty_keluar_barang);
            $sheet->setCellValue('L' . $rows, $br->nik_spv);
            $sheet->setCellValue('M' . $rows, $br->nama_spv);
           
            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    public function exportPengembalian() {
         //get data tgl
         $date_from = $this->request->getVar('date_from');
         $date_to   = $this->request->getVar('date_to');
  
        //menghubungkan ke tabe l model
        $builder = new PengembalianBarangModel();
        $builder->where('pengembalian_barang.deleted_at', null);
        $builder->where("pengembalian_barang.tgl_pengembalian between '$date_from' and '$date_to'", null, false);
        $builder->where('pengembalian_barang.status','1');
        $builder->join('stock_barang','stock_barang.id=pengembalian_barang.id_stock');
        $builder->join('master_barang','master_barang.id=stock_barang.id_barang');
        $builder->join('master_jenis_barang','master_jenis_barang.id=stock_barang.id_jenis_barang');
        $builder->join('spv', 'spv.nik=pengembalian_barang.nik_spv');
        $builder->join('users', 'users.nik = pengembalian_barang.nik_gl');
        $builder->select('master_barang.nama_barang, master_jenis_barang.jenis_barang, pengembalian_barang.*, spv.name as nama_spv, users.name as nama_gl ');
        $barang = $builder->findAll();
        
        // dd($barang);
         
        $fileName = 'LAPORAN_PENGEMBALIAN_BARANG.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'NIK_GL');
        $sheet->setCellValue('B1', 'NAMA_GL');
        $sheet->setCellValue('C1', 'LINE');
        $sheet->setCellValue('D1', 'TGL_PENGEMBALIAN');
        $sheet->setCellValue('E1', 'NAMA_BARANG');
        $sheet->setCellValue('F1', 'JENIS_BARANG');
        $sheet->setCellValue('G1', 'QTY_PENGEMBALIAN');
        $sheet->setCellValue('H1', 'STATUS_PENGEMBALIAN');
        $sheet->setCellValue('I1', 'KONDISI_BARANG');
        $sheet->setCellValue('J1', 'KETERANGAN_KONDISI');
        $sheet->setCellValue('K1', 'NIK_SPV');
        $sheet->setCellValue('L1', 'NAMA_SPV');



        $rows = 2;
        
        foreach ($barang as $br){
            
    
            $sheet->setCellValue('A' . $rows, $br->nik_gl);
            $sheet->setCellValue('B' . $rows, $br->nama_gl);
            $sheet->setCellValue('C' . $rows, $br->line);
            $sheet->setCellValue('D' . $rows, $br->tgl_pengembalian);
            $sheet->setCellValue('E' . $rows, $br->nama_barang);
            $sheet->setCellValue('F' . $rows, $br->jenis_barang);
            $sheet->setCellValue('G' . $rows, $br->qty);
            if($br->status == '0')
            {
                $status_new = 'Belum di Approve';
            }else if($br->status == '1')
            {
                $status_new = 'Approved';
            }else{
                $status_new = 'Gagal';
            }
            $sheet->setCellValue('H' . $rows, $status_new);
            $sheet->setCellValue('I' . $rows, $br->kondisi_barang);
            $sheet->setCellValue('J' . $rows, $br->keterangan_kondisi);
            $sheet->setCellValue('K' . $rows, $br->nik_spv);
            $sheet->setCellValue('L' . $rows, $br->nama_spv);
           
            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    public function index_master_downtime_kategori()
    {
         //ambil data session dari login
         $nik = $this->session->get('nik');

         $db = new MasterKategoriModel();
         $data['kategori'] = $db->query("SELECT * FROM downtime_kategori where deleted_at is null")->getResult();
        //  dd($data['kategori']); 
         return view('staff_view/master_downtime_kategori', $data );

    }

    public function saveDowntimeKategori()
    {
        $kategori = $this->request->getVar('txt_kategori');

     
        $db = new MasterKategoriModel();

        //ambil id terakhir untuk create id baru + 1
        $result = $db->select('max(id) as id')->first();
        $count_id = null;
        foreach ($result as $key => $rs) {
            $count_id = $rs;
            
        }
       
        
        if($count_id != null)
        {
            // var_dump($c_id)['id'];
            // die();
            // $int_id = (int)$c_id[0]->id;
            $int_id = (int)$count_id;
            $id = $int_id+1;
        }else{
            $id = 1;
        }
        $nik = $this->session->get('nik');
        
        $db->insert([
            'id' => $id,
            'downtime_kategori'  => $kategori,
            'created_at' => time::now(),
            // 'deleted_at'=> null
        ]);
        return redirect()->to('/staff/index_master_downtime_kategori');
    

    }

    
    public function editKategori($id)
    {
        $db = new MasterKategoriModel();
        $db->where('id', $id);
        $data['kategori'] = $db->first();
        return view('staff_view/edit_master_downtime_kategori', $data );
    }

    public function updateKategori()
    {
        $id = $this->request->getVar('edt_id_kategori');
        $kategori = $this->request->getVar('edt_nama_kategori');

        $db = new MasterKategoriModel();
        $db->set('downtime_kategori', $kategori);
        $db->where('id', $id);
        $updateKategori = $db->update();

        return redirect()->to('/staff/index_master_downtime_kategori');
    

    }


    public function deleteKategori($id)
    {
        $db = new MasterKategoriModel();
        $db->set('deleted_at', time::now());
        $db->where('id', $id);
        $update = $db->update();

        return redirect()->to('/staff/index_master_downtime_kategori');
    
    
    }

    public function index_master_downtime_deskripsi()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new MasterDeskripsiModel();
        $data['deskripsi'] = $db->query("SELECT master_downtime_deskripsi.id, master_downtime_deskripsi.downtime_deskripsi, dk.downtime_kategori from master_downtime_deskripsi 
                        left join downtime_kategori dk on dk.id = master_downtime_deskripsi.downtime_kategori_id
                        where master_downtime_deskripsi.deleted_at is null ")->getResult();

        $db2 = new MasterKategoriModel();
        $data['kategori'] = $db2->query("SELECT * from downtime_kategori where deleted_at is null")->getResult();
        return view('staff_view/master_downtime_deskripsi', $data );
    }

    
    public function saveDowntimeDeskripsi()
    {
        $downtime_deskrispi = $this->request->getVar('txt_downtime_deskrispi');
        $kategori_id = $this->request->getVar('downtime_kategori');

     
        $db = new MasterDeskripsiModel();

        //ambil id terakhir untuk create id baru + 1
        $result = $db->select('max(id) as id')->first();
        $count_id = null;
        foreach ($result as $key => $rs) {
            $count_id = $rs;
            
        }
       
        
        if($count_id != null)
        {
            // var_dump($c_id)['id'];
            // die();
            // $int_id = (int)$c_id[0]->id;
            $int_id = (int)$count_id;
            $id = $int_id+1;
        }else{
            $id = 1;
        }
        $nik = $this->session->get('nik');
        
        $db->insert([
            'id' => $id,
            'downtime_deskripsi' => $downtime_deskrispi,
            'downtime_kategori_id'  => $kategori_id,
            'created_at' => time::now(),
            // 'deleted_at'=> null
        ]);
        return redirect()->to('/staff/index_master_downtime_deskripsi');
    

    }

    public function deleteDeskripsi($id)
    {
        $db = new MasterDeskripsiModel();
        $db->set('deleted_at', time::now());
        $db->where('id', $id);
        $update = $db->update();

        return redirect()->to('/staff/index_master_downtime_deskripsi');
    
    
    }

    public function exportDeskripsi()
    {
        
        //menghubungkan ke tabe l model
        $builder = new MasterDeskripsiModel();
        $builder->where('master_downtime_deskripsi.deleted_at', null);
        $builder->join('downtime_kategori','downtime_kategori.id=master_downtime_deskripsi.downtime_kategori_id');
        $barang = $builder->findAll();
        
        // dd($barang);
         
        $fileName = 'LAPOORAN_MASTER_DOWNTIME_DESKRIPSI.xlsx';  
        $spreadsheet = new Spreadsheet();
   
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'DOWNTIME DESKRIPSI');
        $sheet->setCellValue('B1', 'DOWNTIME KATEGORI');
        $rows = 2;
        
        foreach ($barang as $br){
            
    
            $sheet->setCellValue('A' . $rows, $br->downtime_deskripsi);
            $sheet->setCellValue('B' . $rows, $br->downtime_kategori);
           
            $rows++;
        } 

        $writer = new Xlsx($spreadsheet);
        $writer->save("upload/".$fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
        // redirect(base_url()."/upload/".$fileName); 
    }

    public function exportKategori()
    {
         //menghubungkan ke tabe l model
         $builder = new MasterKategoriModel();
         $builder->where('deleted_at', null);
         $barang = $builder->findAll();
         
         // dd($barang);
          
         $fileName = 'LAPOORAN_MASTER_DOWNTIME_KATEGORI.xlsx';  
         $spreadsheet = new Spreadsheet();
    
         $sheet = $spreadsheet->getActiveSheet();
         $sheet->setCellValue('A1', 'DOWNTIME KATEGORI');
         $rows = 2;
         
         foreach ($barang as $br){
             
     
             $sheet->setCellValue('A' . $rows, $br->downtime_kategori);
            
             $rows++;
         } 
 
         $writer = new Xlsx($spreadsheet);
         $writer->save("upload/".$fileName);
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
         header('Cache-Control: max-age=0');
     
         $writer->save('php://output');
         // redirect(base_url()."/upload/".$fileName); 
    }
    



}
