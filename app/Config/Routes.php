<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/islogin', 'LoginController::islogin');
$routes->get('/logout', 'LoginController::logout');
$routes->get('/register', 'LoginController::registrasi_view');
$routes->post('/register/saveRegister', 'LoginController::saveRegister');
$routes->get('/dashboard', 'DashboardController::layout');


// GL Routing

$routes->get('/gl/dashboard', 'GLController::index');
$routes->get('/gl/dashboard/create_laporan', 'GLController::index_create_laporan');
$routes->post('/gl/dashboard/saveLaporan', 'GLController::saveLaporan');
$routes->get('/gl/dashboard/create_permintaan', 'GLController::index_create_permintaan');
$routes->get('/gl/dashboard/index_dashboard_permintaan', 'GLController::index_dashboard_permintaan');
$routes->post('/gl/dashboard/savePermintaan', 'GLController::savePermintaan');
$routes->get('/gl/ajukanPengembalian/(:num)', 'GLController::ajukanPengembalian/$1');
$routes->get('/gl/dashboard/create_pengembalian', 'GLController::index_create_pengembalian');
$routes->get('/gl/dashboard/index_dashboard_pengembalian', 'GLController::index_dashboard_pengembalian');
$routes->post('/gl/dashboard/savePengembalian', 'GLController::savePengembalian');



//staff routing
$routes->get('/staff/dashboard', 'StaffController::index');
$routes->get('/staff/dashboard/export', 'StaffController::export');
$routes->get('/staff/index_master_barang', 'StaffController::index_master_barang');
$routes->get('/staff/saveBarang', 'StaffController::saveBarang');
$routes->get('/staff/updateBarang', 'StaffController::updateBarang');
$routes->get('/staff/editBarang/(:num)', 'StaffController::editBarang/$1');
$routes->get('/staff/deleteBarang/(:num)', 'StaffController::deleteBarang/$1');
$routes->get('/staff/index_master_jenis_barang', 'StaffController::index_master_jenis_barang');
$routes->get('/staff/saveJenisBarang', 'StaffController::saveJenisBarang');
$routes->get('/staff/updateJenisBarang', 'StaffController::updateJenisBarang');
$routes->get('/staff/editJenisBarang/(:num)', 'StaffController::editJenisBarang/$1');
$routes->get('/staff/deleteJenisBarang/(:num)', 'StaffController::deleteJenisBarang/$1');
$routes->get('/staff/index_stock_barang', 'StaffController::index_stock_barang');
$routes->get('/staff/saveStockBarang', 'StaffController::saveStockBarang');
$routes->get('/staff/updateStock', 'StaffController::updateStock');
$routes->get('/staff/editStock/(:num)', 'StaffController::editStock/$1');
$routes->get('/staff/deleteStockBarang/(:num)', 'StaffController::deleteStockBarang/$1');
$routes->get('/staff/index_dashboard_permintaan', 'StaffController::index_dashboard_permintaan');
$routes->get('/staff/indexPengeluaranBarang/(:any)', 'StaffController::indexPengeluaranBarang/$1');
$routes->post('/staff/approvePengeluaranBarang', 'StaffController::approvePengeluaranBarang');
$routes->get('/staff/index_dashboard_pengeluaran', 'StaffController::index_dashboard_pengeluaran');
$routes->get('/staff/index_dashboard_pengembalian', 'StaffController::index_dashboard_pengembalian');
$routes->get('/staff/index_dashboard_pengembalian/approvePengembalian/(:any)', 'StaffController::approvePengembalian/$1');
$routes->get('/staff/index_dashboard_pengembalian/rejectPengembalian/(:any)', 'StaffController::rejectPengembalian/$1');
$routes->get('/staff/exportBarang', 'StaffController::exportBarang');
$routes->get('/staff/exportJenisBarang', 'StaffController::exportJenisBarang');
$routes->get('/staff/exportStockBarang', 'StaffController::exportStockBarang');
$routes->get('/staff/exportPermintaan', 'StaffController::exportPermintaan');
$routes->get('/staff/exportPengeluaran', 'StaffController::exportPengeluaran');
$routes->get('/staff/exportPengembalian', 'StaffController::exportPengembalian');
$routes->get('/staff/index_master_downtime_kategori', 'StaffController::index_master_downtime_kategori');
$routes->get('/staff/saveDowntimeKategori', 'StaffController::saveDowntimeKategori');
$routes->get('/staff/updateKategori', 'StaffController::updateKategori');
$routes->get('/staff/editKategori/(:num)', 'StaffController::editKategori/$1');
$routes->get('/staff/deleteKategori/(:num)', 'StaffController::deleteKategori/$1');
$routes->get('/staff/index_master_downtime_deskripsi', 'StaffController::index_master_downtime_deskripsi');
$routes->get('/staff/saveDowntimeDeskripsi', 'StaffController::saveDowntimeDeskripsi');
$routes->get('/staff/deleteDeskripsi/(:num)', 'StaffController::deleteDeskripsi/$1');
$routes->get('/staff/exportDeskripsi', 'StaffController::exportDeskripsi');
$routes->get('/staff/exportKategori', 'StaffController::exportKategori');






//spv routing
$routes->get('/spv/dashboard', 'SPVController::index');
$routes->get('/spv/dashboard/approve/(:num)', 'SPVController::approve/$1');
$routes->get('/spv/dashboard/reject/(:num)', 'SPVController::reject/$1');
$routes->get('/spv/index_dashboard_permintaan', 'SPVController::index_dashboard_permintaan');
$routes->get('/spv/index_dashboard_permintaan/approvePermintaan/(:any)', 'SPVController::approvePermintaan/$1');
$routes->get('/spv/index_dashboard_permintaan/rejectPermintaan/(:any)', 'SPVController::rejectPermintaan/$1');
$routes->get('/spv/index_dashboard_pengembalian', 'SPVController::index_dashboard_pengembalian');
$routes->get('/spv/index_dashboard_pengembalian/approvePengembalian/(:any)', 'SPVController::approvePengembalian/$1');
$routes->get('/spv/index_dashboard_pengembalian/rejectPengembalian/(:any)', 'SPVController::rejectPengembalian/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
