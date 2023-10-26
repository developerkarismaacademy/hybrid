<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TukarVoucher extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->FrontAuthModel->isLoggedIn();
    }


    public function index()
    {
        $this->data['title'] = "Claim Voucher";
        $this->data['content'] = "voucher";

        $this->load->view("front-v2/main", $this->data);
    }

    public function tukar()
    {
        $user = $this->FrontAuthModel->getUserLoggedIn();
        $time     = date('Y-m-d H:i:s', time());
        $voucher  = $this->db->get_where('voucher_prakerja', ['kode_voucher' => $this->input->post('kode_voucher')])->row_array();

        if ($voucher) {
            if ($voucher['status'] != 0) {
                if ($voucher['live_access'] == 1) {
                    $inputRedeem = [
                        'redeem_code' => randomVoucher(5, 'redeem', 'redeem_code', 'LIVE'),
                        'course_code' => randomVoucher(2, 'redeem', 'course_code', 'COURSECODE'),
                        'status' => true,
                        'timestamp' => time(),
                        'user_id' => $_SESSION['siswaData']['id_user'],
                        'mapel_id' => $voucher['mapel_id']
                    ];
                    $this->db->insert('redeem', $inputRedeem);
                }
                $this->db->update('voucher_prakerja', array('status' => 0), array('kode_voucher' => $voucher['kode_voucher']));
                $data_transaksi     = array(
                    "user_id"         => $_SESSION['siswaData']['id_user'],
                    "tanggal"         => $time,
                    "tanggal_bayar"   => $time,
                    "jumlah"          => 1,
                    "jumlah_bayar"    => 0,
                    "bank_user"       => "",
                    "bank_karisma"    => "",
                    "no_rek_user"     => "",
                    "atas_nama"       => "",
                    "bukti_transfer"  => "",
                    "status"          => 2,
                    "created_at"      => $time,
                    "kode_voucher"    => $this->input->post('kode_voucher'),
                    "total_potongan"  => 0,
                    "total_beli"      => 0,
                );

                $this->db->insert('transaksi', $data_transaksi);
                $id_transaksi = $this->db->insert_id();

                // $transaksi              = $this->db->get('transaksi')->row_array();

                $package_rand = rand(1, 3);
                $mapel_id = $voucher['mapel_id'];

                $data_detail_transaksi  = array(
                    "mapel_id"      => $voucher['mapel_id'],
                    "user_id"       => $_SESSION['siswaData']['id_user'],
                    "transaksi_id"  => $id_transaksi,
                    "level_mapel"   => 1,
                    "created_at"    => $time
                );

                $this->db->insert('detail_transaksi', $data_detail_transaksi);
                $idDetailTransaksi = $this->db->insert_id();

                $this->db->where('mapel_id', $mapel_id);
                $this->db->where('user_id', $user['data']['id_user']);
                $cek = $this->db->get('user_mapel')->row_array();

                if (!$cek) {
                    $this->db->insert('randomize', ['id_package' => $package_rand, 'id_detail_transaksi' => $idDetailTransaksi]);

                    $data_user_mapel = array(
                        'mapel_id' => $mapel_id,
                        'user_id' => $user['data']['id_user'],
                        'transaksi_id' => $id_transaksi,
                        'detail_transaksi_id' => $idDetailTransaksi,
                        'level_mapel' => 1
                    );
                    $this->db->insert('user_mapel', $data_user_mapel);
                    alert("success", "", "<strong> Voucher Berhasil di Claim</strong>");
                    return redirect('profil');
                } else {
                    $this->db->delete('transaksi', ['id_transaksi' => $id_transaksi]);
                    $this->db->delete('detail_transaksi', ['id_detail_transaksi' => $idDetailTransaksi]);
                    $this->db->update('voucher_prakerja', array('status' => 1), array('kode_voucher' => $voucher['kode_voucher']));

                    alert("danger", "", "<strong>Pelatihan sudah ada</strong>");

                    return redirect('profil');
                }
            } else {
                alert("danger", "", "<strong> Voucher tidak berlaku</strong>");

                return redirect('profil');
            }
        } else {
            alert("danger", "", "<strong>Kode voucher tidak valid !</strong>");

            return redirect('profil');
        }
    }
}

/* End of file TukarVoucher.php */
