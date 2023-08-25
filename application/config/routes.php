<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['404_override'] = 'back/Dashboard/notFound404Alt';
$route['translate_uri_dashes'] = false;


# BACK V2 ROUTE







// ---- BACK PAGE ROUTE ---- //

// -- DASHBOARD -- //
$route['back'] = 'back/Dashboard';


// -- MATERI -- //
$route['back/materi/(:any)'] = 'back/Materi/index/$1';
$route['back/materi/(:any)/tambah/video'] = 'back/Materi/tambahVideo/$1';
$route['back/materi/(:any)/ubah/video'] = 'back/Materi/ubahVideo/$1';
$route['back/materi/(:any)/ubah/teks'] = 'back/Materi/ubahTeks/$1';
$route['back/materi/(:any)/ubah/latihan'] = 'back/Materi/ubahLatihan/$1';
$route['back/materi/(:any)/ubah/pdf'] = 'back/Materi/editPdf/$1';
$route['back/materi/(:any)/detail/video'] = 'back/Materi/detail/$1';
$route['back/materi/(:any)/detail/teks'] = 'back/Materi/detail/$1';
$route['back/materi/(:any)/detail/latihan'] = 'back/Materi/detail/$1';
$route['back/materi/(:any)/detail/praktek'] = 'back/Materi/detail/$1';
$route['back/materi/(:any)/detail/pdf'] = 'back/Materi/detail/$1';
$route['back/materi/(:any)/batch/latihan'] = 'back/Materi/pasteFromWord/$1';
$route['back/materi/(:any)/soal/latihan'] = 'back/Materi/DaftarSoal/$1';
$route['back/materi/(:any)/tambah-soal/latihan'] = 'back/Materi/tambahSoal/$1';
$route['back/materi/(:any)/ubah-soal/latihan/(:num)'] = 'back/Materi/ubahSoal/$1/$2';
$route['back/materi/(:any)/detail-soal/latihan/(:num)'] = 'back/Materi/detailSoal/$1/$2';
$route['back/materi/(:any)/ubah/praktek'] = 'back/Materi/ubahPraktek/$1';
$route['back/materi/(:any)/tambah/teks'] = 'back/Materi/tambahTeks/$1';
$route['back/materi/(:any)/tambah/latihan'] = 'back/Materi/tambahLatihan/$1';
$route['back/materi/(:any)/tambah/praktek'] = 'back/Materi/tambahPraktek/$1';
$route['back/materi/(:any)/tambah/pdf'] = 'back/Materi/tambahPdf/$1';
$route['back/materi/(:any)/ubah'] = 'back/Materi/ubah/$1';
$route['back/materi/(:any)/setting-urutan'] = 'back/Materi/setUrutan/$1';

// -- BAB -- //
$route['back/bab/(:any)'] = 'back/Bab/index/$1';
$route['back/bab/(:any)/tambah'] = 'back/Bab/tambah/$1';
$route['back/bab/(:any)/setting-urutan'] = 'back/Bab/setUrutan/$1';
$route['back/bab/(:any)/ubah'] = 'back/Bab/ubah/$1';

$route['back/paket/(:any)/ubah'] = 'back/Paket/ubah/$1';

// -- KOMPTENSI -- //
$route["back/kompetensi/(:any)"] = "back/Kompetensi/index/$1";
$route["back/kompetensi/(:any)/tambah"] = "back/Kompetensi/tambah/$1";
$route["back/kompetensi/(:any)/ubah/(:num)"] = "back/Kompetensi/ubah/$1/$2";
$route['back/kompetensi/(:any)/setting-urutan'] = 'back/Kompetensi/setUrutan/$1';

// -- INDIKATOR INDUK -- //
$route["back/indikator-induk/(:num)"] = "back/IndikatorInduk/index/$1";
$route["back/indikator-induk/(:num)/tambah"] = "back/IndikatorInduk/tambah/$1";
$route["back/indikator-induk/(:num)/ubah/(:num)"] = "back/IndikatorInduk/ubah/$1/$2";

// -- INDIKATOR -- //
$route["back/indikator/(:num)"] = "back/Indikator/index/$1";
$route["back/indikator/(:num)/tambah"] = "back/Indikator/tambah/$1";
$route["back/indikator/(:num)/ubah/(:num)"] = "back/Indikator/ubah/$1/$2";

// -- MAPEL -- //
$route['back/mapel/(:any)'] = 'back/Mapel/index/$1';
$route['back/mapel/(:any)/tambah'] = 'back/Mapel/tambah/$1';
$route['back/mapel/(:any)/ubah'] = 'back/Mapel/ubah/$1';
$route['back/mapel/(:any)/ubah-detail'] = 'back/Mapel/ubahDetail/$1';
$route['back/mapel/(:any)/siswa'] = 'back/Mapel/siswa/$1';
$route['back/mapel/(:any)/detail'] = 'back/Mapel/detail/$1';
$route['back/mapel/(:any)/detail/preview'] = 'back/Mapel/preview/$1';
$route['back/mapel/(:any)/detail/portofolio'] = 'back/Mapel/portofolio/$1';
$route['back/simpan-excel-mapel'] = 'back/Mapel/excelLink';

// -- DISKUSI BAB -- //
$route['back/bab/(:any)/diskusi'] = 'back/Diskusi/index/$1';
// -- DISKUSI MATERI-- //
$route['back/materi/(:any)/diskusi'] = 'back/Diskusi/index/$1';

// -- Voucher --//
$route['back/voucher/(:any)/ubah'] = 'back/Voucher/ubah/$1';
$route['voucher/save'] = 'back/Voucher/save';
$route['voucher'] = 'front-v2/TukarVoucher/index';
$route['voucher/tukar'] = 'front-v2/TukarVoucher/tukar';

// -- TESTIMONI --//
$route['back/testimoni/(:num)'] = 'back/Testimoni/index/$1';

// -- KELAS -- //
$route['back/kelas/(:any)/ubah'] = 'back/Kelas/ubah/$1';


// --Asset -- //
$route['back/asset/(:any)'] = 'back/Asset/index/$1';

// -- TRANSAKSI -- //
$route['back/pembelian'] = 'back/Transaksi/index';
$route['back/pembelian/detail/(:any)'] = 'back/Transaksi/detail/$1';
$route['back/pembelian/tambah'] = 'back/Transaksi/tambah';


// -- 404 PAGE -- //
$route['back/not-found'] = "back/Dashboard/notFound404";
$route['back/login'] = "back/Dashboard/login";
$route['back/logout'] = "back/Dashboard/logout";
$route['back/submit-login'] = "back/Dashboard/submitLogin";


//INSTRUKTUR PAGE ROUTE

$route['back/mapel-ampu'] = 'back/Progress/mapelDiAmpu';
$route["back/siswa-ampu/(:any)"] = "back/Progress/siswaAmpu/$1";
$route["back/progress-siswa/(:any)/(:num)"] = "back/Progress/progressSiswa/$1/$2";
$route["back/indikator-siswa/(:any)/(:num)"] = "back/Progress/indikatorSiswa/$1/$2";
$route["back/raport-siswa/(:any)/(:num)"] = "back/Raport/index/$1/$2";

// -- RATING GENERATE -- //
$route['back/rating'] = 'back/Rating';

// ---- FRONT PAGE ROUTE ---- //
$route['default_controller'] = 'front-v2/Page/index';

//PDF

$route["tentang"] = "front-v2/Page/tentang";
$route["keranjang"] = "front-v2/Page/keranjang";
$route["konfirmasi"] = "front-v2/Page/konfirmasi";
$route["paket"] = "front-v2/Page/paket";
$route["paket/(:any)"] = "front-v2/Page/paket/$1";
$route["materi/(:any)"] = "front-v2/Page/materi/$1";
//search tidak pake json
$route["kursus/searchMapel/(:any)"] = "front-v2/Kursus/searchMapel";
//search pake json
$route["kursus/jsonSearchMapel/(:any)"] = "front-v2/Kursus/jsonSearchMapel";

//Belajar
$route["beli/(:any)"] = "front-v2/Beli/beli/$1";
$route["beli-gratis/(:any)"] = "front-v2/Beli/beliGratis/$1";
$route["download-sertifikat/(:any)/(:any)"] = "back/sertifikat/index/$1/$2";
$route["raport/(:any)"] = "front-v2/Raport/index/$1";
$route["konfirmasi/(:num)"] = "front-v2/Beli/konfirmasi/$1";
$route["form-konfirmasi/(:num)/(:num)"] = "front-v2/Beli/formKonfirmasi/$1/$2";
$route["simpan-konfirmasi/(:num)/(:num)"] = "front-v2/Beli/simpanKonfirmasi/$1/$2";

//Belajar
$route["belajar/(:any)"] = "front-v2/Belajar/daftarMateri/$1";
$route["belajar/(:any)/(:any)"] = "front-v2/Belajar/materi/$1/$2";
$route["belajar/(:any)/(:any)/(:num)"] = "front-v2/Belajar/materi/$1/$2/$3";

//Base64
$route["materi/base64/(:num)"] = "api/v1/MateriApi/base64/$1";

//KURSUS
$route["kursus/detail/(:any)"] = "front-v2/Kursus/detail/$1";
$route["kursus/(:any)"] = "front-v2/Kursus/index/$1";
$route["ulasan/(:any)"] = "front-v2/Ulasan/index/$1";

//LOGIN
$route["daftar"] = "front-v2/Login/daftar";
$route["login"]['GET'] = "front-v2/Login/index";
$route["login"]["POST"] = "front-v2/Login/submit";
$route["logout"] = "front-v2/Page/logout";
//DEV MODE
$route["login/lupa"] = "front-v2/Login/lupa";
$route["login/lupa/send"] = "front-v2/Login/send";

//PROFILE
$route["profil"] = "front-v2/Profile/index";
$route["profil/edit"]['GET'] = "front-v2/Profile/edit";
$route["profil/edit"]['POST'] = "front-v2/Profile/submitEdit";

$route["kelas"] = "front-v2/Page/kelas";

//Portofolio
$route["portofolio"] = "front-v2/Page/portofolio";
$route["portofolio/detail"] = "front-v2/Page/detailPortofolio";

//Prakerja
$route["prakerja"] = "front-v2/Page/prakerja";
$route["prakerja/voucher"] = "front-v2/Page/voucher";
$route["redeem-code"] = "front-v2/Redeem/commit";
$route["redeem/status"] = "front-v2/Redeem/status";


//Gamification
$route["profil/gamification"] = "front-v2/Profile/gamification";
//$route["gamification"] = "front-v2/Page/Gamification";


//RegisterForm
$route["form"] = "front-v2/Login/registerform";

//AJAX V2
$route["simpan-log"] = "front-v2/Belajar/simpanLog";
$route["simpan-jawaban"] = "front-v2/Belajar/simpanJawaban";
$route["start"] = "front-v2/Belajar/mulaiLog";
$route["retake"] = "front-v2/Belajar/retakeKuis";
$route["selesai"] = "front-v2/Belajar/selesai";
$route["cari-kursus"] = "front-v2/cari/cariKursus";
$route["log-praktek"] = "front-v2/Belajar/getAllLogPraktek";
$route["hapus-praktek"] = "front-v2/Belajar/hapusLogPraktek";
$route["simpan-praktek"] = "front-v2/Belajar/simpanLogPraktek";
$route["data-ulasan-mapel/(:any)"] = "front-v2/Kursus/ulasanJson/$1";

// -- DEBUG -- //
$route['back/debug'] = 'back/Debug';


//XENDIT
$route["xendit/save-invoices"] = "api/v1/XenditApi/saveInvoice";


// -- PACKAGE -- //
$route['back/materi/package/(:any)'] = 'back/Package/index/$1';
$route['back/materi/package/(:any)/soal/(:num)'] = 'back/Package/soal/$1/$2';

$route['sertifikat'] = 'back/Sertifikat/index';
$route['back/qrcode'] = 'back/Barcode';
$route['back/qrcode/tampil'] = 'back/Barcode/tampil';

// Unit kompetensi
$route['back/unitkompetensi/list/(:num)'] = 'back/UnitKompetensi/list/$1';
$route['back/unitkompetensi/tambah/(:num)'] = 'back/UnitKompetensi/tambah/$1';
$route['back/unitkompetensi/ubah/(:num)/(:num)'] = 'back/UnitKompetensi/ubah/$1/$2';
$route['back/unitkompetensi/hapus/(:num)/(:num)'] = 'back/UnitKompetensi/hapus/$1/$2';

// Skkni
$route['back/skkni/hapus/(:num)'] = 'back/skkni/hapus/$1';
$route['back/skkni/ubah/(:num)'] = 'back/skkni/ubah/$1';

// Mapel Unit Kompetensi
$route['back/mapelunitkompetensi/list/(:any)'] = 'back/MapelUnitKompetensi/list/$1';
$route['back/mapelunitkompetensi/tambah/(:any)'] = 'back/MapelUnitKompetensi/tambah/$1';
$route['back/mapelunitkompetensi/hapus/(:any)'] = 'back/MapelUnitKompetensi/hapus/$1';

$route['promotion'] = 'front-v2/Page/promotion';
$route['gamification/beli-kelas'] = 'front-v2/Gamification/get_course';

// Export siswa 
$route['back/export/(:any)'] = 'back/Export/index/$1';

// Backend Absen
$route['back/absen'] = 'back/Absen/index';
$route['back/absen/tambah'] = 'back/Absen/create';
$route['back/absen/hapus/(:num)'] = 'back/Absen/delete/$1';
$route['back/absen/murid/(:num)'] = 'back/Absen/userAbsen/$1';
$route['back/absen/murid/(:num)/simpan'] = 'back/Absen/absenMurid/$1';

// Frontend Absen
$route['absen/(:num)/(:num)'] = 'front-v2/Absen/index/$1/$2';

// Backend Transaksi Prakerja
$route['back/transaksi-prakerja'] = 'back/TransaksiPrakerja/index';
$route['back/transaksi-prakerja/list/(:any)'] = 'back/TransaksiPrakerja/list/$1';

// Dev
$route['dev/reset-password/(:any)'] = 'back/Dev/resetPassword/$1';

// Prakerja Peserta
$route['back/peserta'] = 'back/Peserta/index';
$route['back/peserta/import'] = 'back/Peserta/import';

// Api V2
$route['api/v2/mapel'] = 'api/SiswaApi/index';


$route['back/generate-sertifikat/(:any)/(:num)'] = 'back/Debug/sertifikat/$1/$2';
