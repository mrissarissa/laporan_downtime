<?php namespace App\Controllers;

use \CodeIgniter\Controller;
use \Hermawan\DataTables\DataTable;
use CodeIgniter\HTTP\RequestInterface;

use App\Models\LaporanModel;
use App\Models\StockBarangModel;
use App\Models\PermintaanBarangModel;
use App\Models\PengembalianBarangModel;

class SPVController extends BaseController {

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
        where laporan.deleted_at is null and laporan.nik_spv = '$nik'")->getResult();
        return view('spv_view/dashboard', $data );
    }

    public function approve($id)
    {
        $db = new LaporanModel();

        $db->set('status', 1);
        $db->where('id', $id);
        $update = $db->update();

        return $this->response->redirect(site_url('/spv/dashboard'));
    }

    public function reject($id)
    {
        $db = new LaporanModel();

        $db->set('status', 2);
        $db->where('id', $id);
        $update = $db->update();

        return $this->response->redirect(site_url('/spv/dashboard'));
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
            where permintaan_barang.deleted_at is null and permintaan_barang.nik_spv = '$nik'")->getResult();
        return view('spv_view/dashboard_permintaan', $data );
    }

    public function approvePermintaan($id)
    {
        $db = new PermintaanBarangModel();

        $db->set('status', 1);
        $db->where('id', $id);
        $update = $db->update();

        return $this->response->redirect(site_url('/spv/index_dashboard_permintaan'));
    }

    public function rejectPermintaan($id)
    {
        $db = new PermintaanBarangModel();

        $db->set('status', 2);
        $db->where('id', $id);
        $update = $db->update();

        return $this->response->redirect(site_url('/spv/index_dashboard_permintaan'));
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
            where pengembalian_barang.deleted_at is null and pengembalian_barang.nik_spv = '$nik'")->getResult();
        return view('spv_view/dashboard_pengembalian', $data );
    }

    public function approvePengembalian($id)
    {
        $db = new PengembalianBarangModel();

        $db->set('status', 1);
        $db->where('id', $id);
        $update = $db->update();

        return $this->response->redirect(site_url('/spv/index_dashboard_pengembalian'));
    }

    public function rejectPengembalian($id)
    {
        $db = new PengembalianBarangModel();

        $db->set('status', 2);
        $db->where('id', $id);
        $update = $db->update();

        return $this->response->redirect(site_url('/spv/index_dashboard_pengembalian'));
    }



}
