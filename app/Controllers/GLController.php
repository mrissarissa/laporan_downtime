<?php namespace App\Controllers;

use \CodeIgniter\Controller;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;


use App\Models\SPVModel;
use App\Models\LaporanModel;
use App\Models\StockBarangModel;
use App\Models\PermintaanBarangModel;
use App\Models\PengembalianBarangModel;
use App\Models\MasterKategoriModel;
use App\Models\MasterDeskripsiModel;


class GLController extends BaseController {

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
            mb.nama_barang, mjb.jenis_barang
            from laporan
            left join spv on spv.nik = laporan.nik_spv
            left join stock_barang sb on sb.id = laporan.id_barang
            left join master_barang mb on mb.id = sb.id_barang
            left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang 
            where laporan.deleted_at is null and laporan.nik_gl = '$nik'")->getResult();
        
        return view('gl_view/dashboard', $data );
    }

    public function data()
    {
        $db = new LaporanModel();
        $builder = $db->where('deleted_at', null)
                    ->first();

        return DataTable::of($builder)
               ->addNumbering() //it will return data output with numbering on first column
               ->toJson();
    }

    public function index_create_laporan()
    {
        $db = new SPVModel();
        $data['spv'] = $db->where('deleted_at', null)->paginate();

        $stock_model = new StockBarangModel();
        $data['stock'] = $stock_model->query("SELECT mb.nama_barang, mjb.jenis_barang, stock_barang.qty, stock_barang.id from stock_barang
                        left join master_barang mb on mb.id=stock_barang.id_barang
                        left join master_jenis_barang mjb on mjb.id = stock_barang.id_jenis_barang
                        where stock_barang.deleted_at is null and stock_barang.qty > 0")->getResult();

        $downtime_model = new MasterDeskripsiModel();
        $data['downtime'] = $downtime_model->query("SELECT master_downtime_deskripsi.id,master_downtime_deskripsi.downtime_deskripsi,dk.downtime_kategori
                                                from master_downtime_deskripsi
                                                left join downtime_kategori dk on dk.id=master_downtime_deskripsi.downtime_kategori_id
                                                where  master_downtime_deskripsi.deleted_at is null")->getResult();

      
        return view('gl_view/create_laporan', $data);
    }

 

    public function saveLaporan()
    {

        $nik = $this->request->getVar('nik');
        $line = $this->request->getVar('line');
        $tgl_laporan = $this->request->getVar('tgl_laporan');
        $id_stock = $this->request->getVar('nm_barang');
        $style = $this->request->getVar('style');
        $problem = $this->request->getVar('problem');
        $problem_deskripsi = $this->request->getVar('problem_deskripsi');
        // $problem_category = $this->request->getVar('problem_category');
        $lossting = $this->request->getVar('lossting');
        $nik_atasan = $this->request->getVar('nik_atasan');

        $downtime_model = new MasterDeskripsiModel();
        $downtime_model->where('master_downtime_deskripsi.id', $problem_deskripsi);
        $downtime_model->join('downtime_kategori dk', 'dk.id=master_downtime_deskripsi.downtime_kategori_id');
        $downtime_model->select('dk.downtime_kategori,master_downtime_deskripsi.downtime_deskripsi');
        $getDowntimeKategori = $downtime_model->first();


        $laporan = new LaporanModel();
        $c_data = $laporan->where('nik_gl', $nik)->where('tgl_laporan', $tgl_laporan)
                    ->where('deleted_at', null)->first();
        
        if(!$c_data)
        {
        
            $laporan = new LaporanModel();
            $laporan->insert([
                'id' => 1,
                'nik_gl' => $nik,
                'line'  => $line,
                'tgl_laporan' => $tgl_laporan,
                'id_barang' => $id_stock,
                'style' => $style,
                'problem'=> $problem,
                'problem_deskripsi' => $getDowntimeKategori->downtime_deskripsi,
                'problem_kategori' => $getDowntimeKategori->downtime_kategori,
                'lossting' => $lossting,
                'nik_spv' => $nik_atasan,
                'status' => '0'
            ]);
            return redirect()->to('/gl/dashboard');
        }else{
            $laporan = new LaporanModel();
            $hitung = $laporan->where('nik_gl', $nik)->where('tgl_laporan', $tgl_laporan)
            ->where('deleted_at', null)->countAllResults();
            $id = $hitung+1;
        
            $laporan->insert([
                'id' => $id,
                'nik_gl' => $nik,
                'line'  => $line,
                'tgl_laporan' => $tgl_laporan,
                'id_barang' => $id_stock,
                'style' => $style,
                'problem'=> $problem,
                'problem_deskripsi' => $problem_deskripsi,
                'problem_kategori' => $problem_category,
                'lossting' => $lossting,
                'nik_spv' => $nik_atasan,
                'status' => '0'
            ]);
            return redirect()->to('/gl/dashboard');
        }

        

        




    }

    public function index_dashboard_permintaan()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new PermintaanBarangModel();
        $data['permintaan'] = $db->query("SELECT permintaan_barang.id,permintaan_barang.nik_gl, permintaan_barang.created_at, permintaan_barang.tgl_permintaan, 
            permintaan_barang.qty, spv.name, permintaan_barang.nik_spv,permintaan_barang.status,
            mb.nama_barang, mjb.jenis_barang
            from permintaan_barang
            left join spv on spv.nik = permintaan_barang.nik_spv
            left join stock_barang sb on sb.id = permintaan_barang.id_stock
            left join master_barang mb on mb.id = sb.id_barang
            left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang 
            where permintaan_barang.deleted_at is null and permintaan_barang.nik_gl = '$nik'")->getResult();
        return view('gl_view/dashboard_permintaan', $data );
    }

    public function index_create_permintaan()
    {
        $db = new SPVModel();
        $data['spv'] = $db->where('deleted_at', null)->paginate();

        $stock_model = new StockBarangModel();
        $data['stock'] = $stock_model->query("SELECT mb.nama_barang, mjb.jenis_barang, stock_barang.qty, stock_barang.id from stock_barang
                        left join master_barang mb on mb.id=stock_barang.id_barang
                        left join master_jenis_barang mjb on mjb.id = stock_barang.id_jenis_barang
                        where stock_barang.deleted_at is null and stock_barang.qty >= 0")->getResult();
        return view('gl_view/create_permintaan_barang', $data);
    }

    public function savePermintaan()
    {

        $nik = $this->request->getVar('nik');
        $line = $this->request->getVar('line');
        $tgl_permintaan = $this->request->getVar('tgl_permintaan');
        $id_stock = $this->request->getVar('nm_barang');
        $qty = $this->request->getVar('qty');
        $nik_atasan = $this->request->getVar('nik_atasan');

        $stock_barang_tb = new StockBarangModel();
        $stocks = $stock_barang_tb->where('id', $id_stock)->first();
        // $int_stocks = (int)$stocks->qty;
        // $int_qty = (int)$qty;
        // $sisa_stock = $int_stocks-$int_qty;

            $permintaan = new PermintaanBarangModel();
            $c_data = $permintaan->where('nik_gl', $nik)->where('tgl_permintaan', $tgl_permintaan)
                        ->where('deleted_at', null)->first();
            
            if(!$c_data)
            {
            
                $permintaan = new PermintaanBarangModel();
                $permintaan->insert([
                    'id' => 'PB'.$nik.'-1',
                    'nik_gl' => $nik,
                    'line'  => $line,
                    'tgl_permintaan' => $tgl_permintaan,
                    'id_stock' => $id_stock,
                    'qty' => $qty,
                    'nik_spv' => $nik_atasan,
                    'status' => '0',
                    'created_at'=>Time::now()
                ]);
                // $stock_barang_tb = new StockBarangModel();
                // $stock_barang_tb->set('qty', $sisa_stock);
                // $stock_barang_tb->where('id', $id_stock);
                // $updatedStock = $stock_barang_tb->update();                    

                return redirect()->to('/gl/dashboard/index_dashboard_permintaan');
            }else{
                $permintaan = new PermintaanBarangModel();
                $hitung = $permintaan->where('nik_gl', $nik)->where('tgl_permintaan', $tgl_permintaan)
                ->where('deleted_at', null)->countAllResults();
                $id = $hitung+1;
            
                $permintaan->insert([
                    'id' => 'PB'.$nik.'-'.$id,
                    'nik_gl' => $nik,
                    'line'  => $line,
                    'tgl_permintaan' => $tgl_permintaan,
                    'id_stock' => $id_stock,
                    'qty' => $qty,
                    'nik_spv' => $nik_atasan,
                    'status' => '0',
                    'created_at'=>Time::now()
                ]);
                
                // $stock_barang_tb = new StockBarangModel();
                // $stock_barang_tb->set('qty', $sisa_stock);
                // $stock_barang_tb->where('id', $id_stock);
                // $updatedStock = $stock_barang_tb->update();
                return redirect()->to('/gl/dashboard/index_dashboard_permintaan');
            }


        


    }

    public function ajukanPengembalian($id)
    {
        $db = new SPVModel();
        $data['spv'] = $db->where('deleted_at', null)->paginate();

        $permintaan = new PermintaanBarangModel();
        $permintaan->where('id', $id);
        $data['permintaan'] = $permintaan->first();
        
        $data['barang'] = $permintaan->query("select mb.nama_barang, mjb.jenis_barang  from permintaan_barang pb
                                        left join stock_barang sb on sb.id=pb.id_stock
                                        left join master_barang mb on mb.id=sb.id_barang
                                        left join master_jenis_barang mjb on mjb.id=sb.id_jenis_barang")->getResult();
                                    

        return view('gl_view/update_pengembalian_barang', $data );
    }

    public function index_dashboard_pengembalian()
    {
        //ambil data session dari login
        $nik = $this->session->get('nik');

        $db = new PengembalianBarangModel();
        $data['pengembalian'] = $db->query("SELECT pengembalian_barang.id,pengembalian_barang.nik_gl, pengembalian_barang.created_at, pengembalian_barang.tgl_pengembalian, 
            pengembalian_barang.qty, spv.name, pengembalian_barang.nik_spv,pengembalian_barang.status,
            mb.nama_barang, mjb.jenis_barang,pengembalian_barang.kondisi_barang, pengembalian_barang.keterangan_kondisi
            from pengembalian_barang
            left join spv on spv.nik = pengembalian_barang.nik_spv
            left join stock_barang sb on sb.id = pengembalian_barang.id_stock
            left join master_barang mb on mb.id = sb.id_barang
            left join master_jenis_barang mjb on mjb.id = sb.id_jenis_barang 
            where pengembalian_barang.deleted_at is null and pengembalian_barang.nik_gl = '$nik'")->getResult();
        return view('gl_view/dashboard_pengembalian', $data );
    }

    public function index_create_pengembalian()
    {                     
        $db = new SPVModel();
        $data['spv'] = $db->where('deleted_at', null)->paginate();

        $stock_model = new StockBarangModel();
        $data['stock'] = $stock_model->query("SELECT mb.nama_barang, mjb.jenis_barang, stock_barang.qty, stock_barang.id from stock_barang
                        left join master_barang mb on mb.id=stock_barang.id_barang
                        left join master_jenis_barang mjb on mjb.id = stock_barang.id_jenis_barang
                        where stock_barang.deleted_at is null and stock_barang.qty >= 0")->getResult();
        return view('gl_view/create_pengembalian_barang', $data);
    }

    public function savePengembalian()
    {

        $nik = $this->request->getVar('nik');
        $line = $this->request->getVar('line');
        $tgl_pengembalian = $this->request->getVar('tgl_pengembalian');
        $id_stock = $this->request->getVar('nm_barang');
        $qty = $this->request->getVar('qty');
        $nik_atasan = $this->request->getVar('nik_atasan');
        $kondisi_barang = $this->request->getVar('kondisi_barang');
        $keterangan_barang = $this->request->getVar('keterangan_barang');
        

        $stock_barang_tb = new StockBarangModel();
        $stocks = $stock_barang_tb->where('id', $id_stock)->first();

        $pengembalian = new PengembalianBarangModel();
        $c_data = $pengembalian->where('nik_gl', $nik)->where('tgl_pengembalian', $tgl_pengembalian)
                    ->where('deleted_at', null)->first();
                    // var_dump($c_data);
                    // die();
        // cek apakah ada 
        if(!$c_data)
        {
        
            $pengembalian = new PengembalianBarangModel();
            $pengembalian->insert([
                'id' => 'KB'.$nik.'-1',
                'nik_gl' => $nik,
                'line'  => $line,
                'tgl_pengembalian' => $tgl_pengembalian,
                'id_stock' => $id_stock,
                'qty' => $qty,
                'nik_spv' => $nik_atasan,
                'status' => '0',
                'created_at'=>Time::now(),
                'kondisi_barang' => $kondisi_barang,
                'keterangan_kondisi'=> $keterangan_barang,
            ]);
            // $stock_barang_tb = new StockBarangModel();
            // $stock_barang_tb->set('qty', $sisa_stock);
            // $stock_barang_tb->where('id', $id_stock);
            // $updatedStock = $stock_barang_tb->update();                    

            return redirect()->to('/gl/dashboard/index_dashboard_pengembalian');
        }else{
            $pengembalian = new PengembalianBarangModel();
            $hitung = $pengembalian->where('nik_gl', $nik)->where('tgl_pengembalian', $tgl_pengembalian)
            ->where('deleted_at', null)->countAllResults();
            // dd($hitung);
            $id = $hitung+1;
        
            
            $pengembalian->insert([
                'id' => 'KB'.$nik.'-'.$id,
                'nik_gl' => $nik,
                'line'  => $line,
                'tgl_pengembalian' => $tgl_pengembalian,
                'id_stock' => $id_stock,
                'qty' => $qty,
                'nik_spv' => $nik_atasan,
                'status' => '0',
                'created_at'=>Time::now(),
                'kondisi_barang' => $kondisi_barang,
                'keterangan_kondisi'=> $keterangan_barang,
            ]);
            
            return redirect()->to('/gl/dashboard/index_dashboard_pengembalian');
        }


        


    }

    

 
}
