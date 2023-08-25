<?php
defined('BASEPATH') or exit('No direct script access allowed');


function arr_to_obj($data)
{
	return $object = json_decode(json_encode($data), false);
}

function obj_to_arr($data)
{
	return $object = json_decode(json_encode($data), true);
}

function is_url_exist($url)
{
	return true;
}


function is_file_return($tipe = "user", $filepath)
{
	$filepath_check = "./" . $filepath;
	$filepath_check = str_replace(base_url(), "", $filepath);

	// Check if file exists
	if (is_file($filepath_check)) {
		$hasil = $filepath;
	} else {
		if ($tipe == "user") {
			$hasil = base_url("assets/front/v2/img/default.png");
		} else if ($tipe == "mapel") {
			$hasil = base_url("assets/front/v2/img/no-image.jpg");
		} else {
			$hasil = base_url("assets/front/v2/img/no-image-box.png");
		}
	}
	return $hasil;
}


function get_string_between($string, $start, $end)
{
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0)
		return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;

	return substr($string, $ini, $len);
}

function convert_base64_to_image($text, $dir)
{
	if (!is_dir($dir)) {
		mkdir($dir, 0777, true);
	}
	$doc = new DOMDocument();
	@$doc->loadHTML($text);

	$tags = $doc->getElementsByTagName('img');
	$img = [];
	$i = 0;
	$text_lama = $text;
	foreach ($tags as $tag) {
		$img[$i]['img'] = $tag->getAttribute('src');
		if (strpos($tag->getAttribute('src'), ';base64,') !== false) {
			$image_parts = explode(";base64,", $tag->getAttribute('src'));
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$img[$i]['tipe'] = $image_type;
			$img[$i]['tipe_file'] = tipe($image_type);
			$file = $dir . uniqid() . '.' . tipe($image_type);
			$image_base64 = base64_decode($image_parts[1]);
			file_put_contents($file, $image_base64);
			$img[$i]['file'] = base_url($file);
			$text = str_replace($tag->getAttribute('src'), base_url($file), $text);
			$i++;
		}

	}
	$img['text'] = $text;
	$img['text_lama'] = $text_lama;
	if ($handle = opendir($dir)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				if (strpos($text, $entry) != true) {
					echo $dir . $entry;
					unlink($dir . $entry);
					echo $entry;
				}
			}
		}

		closedir($handle);
	}

	return $text;
}

function tipe($tipe)
{
	$tipe = strtolower($tipe);
	switch ($tipe) {
		case "gif":
			return "gif";
			break;
		case "jpeg":
			return "jpg";
			break;
		case "png":
			return "png";
			break;
		default:
			return false;
			break;
	}
}

function getFileExtension($path)
{
	$ext = pathinfo($path, PATHINFO_EXTENSION);

	return $ext;
}

function delete_files($directory)
{


	if (substr($directory, strlen($directory) - 1, 1) != '/') {
		$directory .= '/';
	}

	$files = glob($directory . "*");

	if (!empty($files)) {
		foreach ($files as $file) {
			if (is_dir($file)) {
				delete_files($file);
			} else {
				unlink($file);
			}
		}
	}
	rmdir($directory);

}

function remove_unsusedp($isi)
{
	$isi = trim($isi);
	$isi = str_replace('&nbsp;', '', $isi);
	$isi = preg_replace('#<o:p>(\s|&nbsp;)*</o:p>#', '', $isi);
	$isi = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $isi);
	$isi = trim($isi);

	return $isi;
}


function DOMinnerHTML(DOMNode $element)
{
	$innerHTML = "";
	$children = $element->childNodes;

	foreach ($children as $child) {
		$innerHTML .= $element->ownerDocument->saveHTML($child);
	}

	return $innerHTML;
}


function remove_unsusedhtml($isi)
{
	$isi = trim($isi);
	$isi = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace(['<html>', '</html>', '<body>', '</body>', '<head>', '</head>', '<title>', '</title>'], ['', '', '', '', '', '', '', ''], $isi));
	;
	$isi = preg_replace('/<!--(.*)-->/Uis', '', $isi);
	$isi = trim($isi);

	return $isi;
}

function generateRandomString($length = 10)
{
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}

	return $randomString;
}


function formatTanggal($tanggal)
{
	$originalDate = $tanggal;
	$date = date("d", strtotime($originalDate));
	$month = date("n", strtotime($originalDate));
	$year = date("Y", strtotime($originalDate));

	$newDate = $date . " " . bulanSingkat[$month] . " " . $year;

	return $newDate;
}

function formatTanggal2($tanggal)
{
	$originalDate = $tanggal;
	$date = date("d", strtotime($originalDate));
	$month = date("n", strtotime($originalDate));
	$year = date("Y", strtotime($originalDate));

	$newDate = $date . " " . bulan[$month] . " " . $year;

	return $newDate;
}

function formatTanggalPembelian($tanggal)
{

}


function getDateString($date)
{
	$dateArray = date_parse_from_format('Y/m/d', $date);
	$monthName = DateTime::createFromFormat('!m', $dateArray['month'])->format('F');
	return $dateArray['day'] . " " . $monthName . " " . $dateArray['year'];
}

function getDateTimeDifferenceString($datetime)
{
	$currentDateTime = new DateTime(date('Y-m-d H:i:s'));
	$passedDateTime = new DateTime($datetime);
	$interval = $currentDateTime->diff($passedDateTime);
	//$elapsed = $interval->format('%y years %m months %a days %h hours %i minutes %s seconds');
	$day = $interval->format('%a');
	$hour = $interval->format('%h');
	$min = $interval->format('%i');
	$seconds = $interval->format('%s');

	if ($day > 7)
		return getDateString($datetime);
	else if ($day >= 1 && $day <= 7) {
		if ($day == 1)
			return $day . " day ago";
		return $day . " days ago";
	} else if ($hour >= 1 && $hour <= 24) {
		if ($hour == 1)
			return $hour . " hour ago";
		return $hour . " hours ago";
	} else if ($min >= 1 && $min <= 60) {
		if ($min == 1)
			return $min . " minute ago";
		return $min . " minutes ago";
	} else if ($seconds >= 1 && $seconds <= 60) {
		if ($seconds == 1)
			return $seconds . " second ago";
		return $seconds . " seconds ago";
	}
}

function rupiah($angka)
{

	$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
	return $hasil_rupiah;

}

function rupiahTanpa0($angka)
{

	$hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
	return $hasil_rupiah;

}

function hargaDiskon($harga_basic, $diskon)
{
	$harga_basic = is_numeric($harga_basic) ? $harga_basic : 500000;
	$diskon = is_numeric($diskon) ? $diskon : 80;
	$decoy = 100 / (100 - $diskon) * ($harga_basic);
	$decoy = substr(ceil($decoy), 0, 2) * pow(10, strlen($decoy) - 2);
	return $decoy;
}

function alert($level, $title, $message)
{
	if ($level == "danger")
		$level = "error";
	$_SESSION['alert'][] = "
	toastr['$level']('$message', '$title')";
}

function shortDescription($text, $limit)
{
	$words = explode(" ", $text);
	$short = implode(" ", array_slice($words, 0, $limit));
	if (count($words) > $limit) {
		$short .= "...";
	}
	return $short;
}

function invoice($number)
{
	$formattedNumber = '#' . str_pad($number, 8, '0', STR_PAD_LEFT);
	return $formattedNumber;
}

function randomVoucher($length, $table, $column, $code)
{
	$CI =& get_instance();
	$CI->load->database();

	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	$characterCount = strlen($characters);

	do {
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $characterCount - 1)];
		}

		$CI->db->where($column, $code . $randomString);
		$count = $CI->db->count_all_results($table);
	} while ($count > 0);

	return $code . $randomString;
}