<?php


defined('BASEPATH') or exit('No direct script access allowed');

use Endroid\QrCode\QrCode;

class Barcode extends CI_Controller
{
  public function barcode_gen()
  {
    $this->load->library('ciqrcode');
    $link = 'hallow';
    $link = url_title($link, 'dash', TRUE);
    $params['data'] = 'http://localhost:8002/kursusonline/download-sertifikat/belajar-membuat-3d-interior-sederhana-dengan-sketchup/a2FyaXNtYWFjYWRlbXk4M2thcmlzbWFhY2FkZW15';
    $params['level'] = 'H';
    $params['size'] = 10;
    $params['savename'] = FCPATH . $link . '.png';
    $this->ciqrcode->generate($params);

    echo '<img src="' . base_url() . $link . '.png" />';
  }
  public function tampil()
  {
    $data = $this->barcode_gen();
    echo "<img src='$data'>";
  }
}

/* End of file QRCode.php */