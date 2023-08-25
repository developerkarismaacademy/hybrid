<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PesertaModel extends CI_Model
{
	public function getPeserta($slug = 'null')
	{
		if ($slug != 'null') {
			return $this->db->query("SELECT user.nama_user,redeem.redeem_code,DATE_FORMAT( FROM_UNIXTIME(redeem.timestamp), '%m/%d/%Y' ) AS tanggal_redeem,mapel.nama_mapel,user.email_user FROM user JOIN redeem ON user.id_user = redeem.user_id JOIN mapel ON redeem.mapel_id = mapel.id_mapel WHERE mapel.prakerja = 1 AND mapel.meta_link_mapel = '$slug' ORDER BY DATE_FORMAT( FROM_UNIXTIME(redeem.timestamp), '%m/%d/%Y' ) DESC")->result_array();
		}
		return $this->db->query("SELECT	user.nama_user,redeem.redeem_code,DATE_FORMAT( FROM_UNIXTIME(redeem.timestamp), '%m/%d/%Y' ) AS tanggal_redeem,mapel.nama_mapel,user.email_user FROM user JOIN redeem ON user.id_user = redeem.user_id JOIN mapel ON redeem.mapel_id = mapel.id_mapel WHERE mapel.prakerja = 1 ORDER BY DATE_FORMAT( FROM_UNIXTIME(redeem.timestamp), '%m/%d/%Y' ) DESC")->result_array();
	}

	public function getMapel()
	{
		return $this->db->query("SELECT * FROM mapel WHERE mapel.prakerja = 1")->result_array();
	}

	public function getSiswaByMapel($mapelId){
		return $this->db->query("SELECT t1.posttest, t2.pretest, `user`.id_user, `mapel`.meta_link_mapel, `transaksi`.id_transaksi, `transaksi`.kode_voucher, `user`.nama_user, `user`.email_user, `user`.telepon_user, `redeem`.redeem_code, `transaksi`.tanggal AS tanggal_pembelian, `redeem`.TIMESTAMP AS tanggal_redeem, `user_mapel_progress`.progress, `user_mapel_progress`.updated_at AS tanggal_pengerjaan FROM `user` LEFT JOIN (SELECT log_ujian.nilai AS posttest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE posttest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t1 ON user.id_user = t1.user_id LEFT JOIN (SELECT log_ujian.nilai AS pretest, log_ujian.user_id FROM mapel JOIN bab ON mapel.id_mapel = bab.mapel_id JOIN materi ON materi.bab_id = bab.id_bab JOIN log_ujian ON materi.id_materi = log_ujian.materi_id WHERE pretest_status = 1 GROUP BY log_ujian.user_id ORDER BY log_ujian.id_log_ujian DESC) t2 ON user.id_user = t2.user_id INNER JOIN transaksi ON `user`.id_user = transaksi.user_id INNER JOIN `detail_transaksi` ON `user`.id_user = `detail_transaksi`.user_id AND `transaksi`.id_transaksi = `detail_transaksi`.transaksi_id INNER JOIN `mapel` ON `detail_transaksi`.mapel_id = `mapel`.id_mapel LEFT JOIN `redeem` ON `redeem`.user_id = `user`.id_user LEFT JOIN `user_mapel_progress` ON `user_mapel_progress`.mapel_id = `mapel`.id_mapel AND `user_mapel_progress`.user_id = `user`.id_user WHERE mapel.id_mapel = $mapelId ORDER BY `transaksi`.tanggal DESC")->result();
	}
}
