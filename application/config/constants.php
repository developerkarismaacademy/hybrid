<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/**
 * Custom defines
 */
define('bg', array("yellow", "red", "blue", "green", "purple", "yellow"));
define('badge', array("red", "blue", "green", "purple", "yellow", "red"));

define('garem', 'itsKarismaOnline');

define('level', [
	"0" => ["public", "light"],
	"1" => ["basic", "success"],
	"2" => ["silver", "secondary"],
	"3" => ["gold", "warning"],
]);

define('tipeList', ["pilihan" => "clipboard-check", "praktek" => "file-alt", "upload" => "marker", "teks" => "align-center", "video" => "play"]);


define('status', [

		"0" => ["red", "Belum dibayar"],
		"1" => ["blue", "Tunggu konfirmasi"],
		"2" => ["green", "Telah diterima"],
		"3" => ["gray", "EXPIRED"],
	]
);

define('statusBs', [

		"0" => ["danger", "Belum dibayar"],
		"1" => ["warning", "Tunggu konfirmasi"],
		"2" => ["success", "Telah diterima"],
		"3" => ["danger", "EXPIRED"],
	]
);

define("jenisMateri", [
	"teks"    => "Teks",
	"video"   => "Video",
	"pilihan" => "Ujian",
	"praktek" => "Praktek",
	"pdf"     => "PDF",
]);

define("iconMateri", [
	"teks"    => "mteks",
	"video"   => "mvideo",
	"pilihan" => "steks",
	"praktek" => "spraktek",
	"pdf"     => "mteks",
]);

define("iconMateriFa", [
	"teks"    => "fa-file-pdf-o",
	"video"   => "fa-youtube-play",
	"pilihan" => "fa-pencil-square-o",
	"praktek" => "fa-pencil-square",
	"pdf"     => "fa-file-pdf-o",
]);

define("iconMateriColor", [
	"teks"    => "assets/back/images/icons/kindle.svg",
	"video"   => "assets/back/images/icons/start.svg",
	"pilihan" => "assets/back/images/icons/inspection.svg",
	"praktek" => "assets/back/images/icons/kindle.svg",
	"pdf"     => "assets/back/images/icons/kindle.svg",
]);

define("satuanMateri", [
	"teks"    => "Halaman",
	"video"   => "Menit",
	"pilihan" => "Soal",
	"praktek" => "Tugas",
	"pdf"     => "PDF",
]);

//HARI
define("hari", ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]);

//BULAN
define("bulan", ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"]);

//BULAN SINGKAT
define("bulanSingkat", ["", "Jan", "Feb", "Mar", "Apr", "Mei", "Juni", "Juli", "Agu", "Sep", "Okt", "Nov", "Des"]);

define("knownType",
	[
		//IMAGE
		'png'  => 'IMAGE',
		'jpe'  => 'IMAGE',
		'jpeg' => 'IMAGE',
		'jpg'  => 'IMAGE',
		'gif'  => 'IMAGE',
		'bmp'  => 'IMAGE',
		'ico'  => 'IMAGE',
		'tiff' => 'IMAGE',
		'tif'  => 'IMAGE',
		'svg'  => 'IMAGE',
		'svgz' => 'IMAGE',

		//ARCHIVE
		'zip'  => 'ARCHIVE ZIP',
		'rar'  => 'ARCHIVE RAR',

		//TXT
		'txt'  => 'TEKS',

		//PDF
		'pdf'  => 'PDF',

		//DOCUMENT
		'rtf'  => 'DOCUMENT',

		//CSV
		'csv'  => 'CSV',

		//POWERPOINT
		'ppt'  => 'MICROSOFT POWERPOINT',
		'pptm' => 'MICROSOFT POWERPOINT',
		'pptx' => 'MICROSOFT POWERPOINT',

		//EXCEL
		'xls'  => 'MICROSOFT EXCEL',
		'xlsx' => 'MICROSOFT EXCEL',

		//WORD
		'doc'  => 'MICROSOFT WORD',
		'docx' => 'MICROSOFT WORD',
		'docm' => 'MICROSOFT WORD',

		//CSS
		'css'  => 'CSS',

		//php
		'php'  => 'PHP',

		//js
		'js'   => 'JS',

		//HTML
		'htm'  => 'HTML',
		'html' => 'HTML',

	]);

define("bank", [
	"bca"     => [
		"nama"     => "BCA",
		"image"    => ".png",
		"rekening" => "3150786532",
		"atasNama" => "Nizar Luthfiansyah",
		"link"     => "#"
		,],
	"bri"     => [
		"nama"     => "BRI",
		"image"    => ".png",
		"rekening" => "312701003092500",
		"atasNama" => "Nizar Luthfiansyah",
		"link"     => "#",
	],
	"mandiri" => [
		"nama"     => "MANDIRI",
		"image"    => ".png",
		"rekening" => "1440011580054",
		"atasNama" => "Nizar Luthfiansyah",
		"link"     => "#",
	],
]);


define("metode_bayar", [
	"VIRTUAL_ACCOUNT" => "Bank Transfer",
	"RETAIL_OUTLET"   => "Outlet Ritel",
	"EWALLET"         => "eWallet",
	"CREDITCARD"      => "Kartu Kredit",
]);


define("payment", [
	"VIRTUAL_ACCOUNT" => [
		"BNI"     => "BNI",
		//		"BCA"     => "BCA",
		"BRI"     => "BRI",
		"PERMATA" => "PERMATA",
		"MANDIRI" => "MANDIRI",
	],
	"RETAIL_OUTLET"   => [
//		"ALFAMART"  => "ALFAMART GROUP",
//		"INDOMARET" => "INDOMARET GROUP",
	],
	"EWALLET"         => [
//		"SHOPEEPAY" => "Shopee Pay",
		"OVO"       => "OVO",
		"DANA"      => "DANA",
//		"LINKAJA"   => "LinkAja",
	],
	"CREDITCARD"      => [
		"CREDITCARD" => "Kartu Kredit"
	],
]);

define("xnd_key", "xnd_production_5saAaxjGPDLufLfe8GdNwDRnoTyAzcv0yEj6LEJCFl0N1ky49TNC6Wdu4MIk");
// define("xnd_key", "xnd_development_DqkUIVP8O3DGOQSqGAqgktzK41UDDg8A4i0GcdjaDDTHgdSh6rdd1pNh2Y2c");

