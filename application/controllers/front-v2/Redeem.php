<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Redeem extends CI_Controller

{


    public function __construct()
    {
        parent::__construct();

        $this->FrontAuthModel->isLoggedIn();
    }

    private $client_code = 'lkpkar3994138595632901';

    private $key = 'c9a02d1d932146d1b006d4f53f674ca6';





    public function status()

    {

        $redeem_code = $this->input->post('status');

        $endpoint = '/api/v1/integration/payment/redeem-code/status';

        $timestamp = time();

        $text = $this->client_code . $timestamp . 'POST' . $endpoint . '{"redeem_code":"' . $redeem_code . '"}';

        $signature = hash_hmac('sha1', $text, $this->key);

        $headers = [

            'Content-Type: application/json',

            'client_code: ' . $this->client_code,

            'signature: ' . $signature,

            'timestamp: ' . $timestamp,

        ];

        $data = [

            'redeem_code' => $redeem_code

        ];



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,            'https://api.prakerja.go.id/' . $endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST,           1);

        curl_setopt($ch, CURLOPT_HTTPHEADER,     $headers);

        curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($data));

        $result = curl_exec($ch);

        curl_close($ch);



        $result = json_decode($result, true);

        $message = $result['message'];

        $success = $result['success'];

        //var_dump($result);
        //die;

        if ($success == 'true') {

            $this->data = [

                'redeem_code' => $result['data']['redeem_code'],

                'course_code' => $result['data']['course_code'],

                'status' => $result['data']['status'],

            ];

            $this->data['title'] = "redeem";

            $this->data['content'] = "redeem";



            $this->load->view("front-v2/main", $this->data);
        } else {

            // $this->session->set_flashdata('message', $message);

            alert("warning", "", "<strong>{$message}</strong>");

            redirect('prakerja');
        }
    }



    public function commit()

    {

        $redeem_code = $this->input->post('commit');
        $mapel_id = $this->input->post('mapel_id');
        $user = $this->FrontAuthModel->getUserLoggedIn();
        $user_id = $user['data']['id_user'];

        $endpoint = '/api/v1/integration/payment/redeem-code/commit';

        $timestamp = time();

        $text = $this->client_code . $timestamp . 'POST' . $endpoint . '{"redeem_code":"' . $redeem_code . '"}';

        $signature = hash_hmac('sha1', $text, $this->key);



        $headers = [

            'Content-Type: application/json',

            'client_code: ' . $this->client_code,

            'signature: ' . $signature,

            'timestamp: ' . $timestamp,

        ];

        $data = [

            'redeem_code' => $redeem_code

        ];



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,            'https://api.prakerja.go.id/' . $endpoint);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST,           1);

        curl_setopt($ch, CURLOPT_HTTPHEADER,     $headers);

        curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($data));

        $result = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($result, true);

        $success = $result['success'];
        //var_dump($result);
        //die;
        $data = [
            'redeem_code' => $result['data']['redeem_code'],
            'course_code' => $result['data']['course_code'],
            'status' => $result['data']['status'],
            'timestamp' => $timestamp,
            'mapel_id' => $mapel_id,
            'user_id' => $user_id
        ];
        var_dump($data);
        die;
        if ($success == true) {

            $data = [
                'redeem_code' => $result['data']['redeem_code'],
                'course_code' => $result['data']['course_code'],
                'status' => $result['data']['status'],
                'timestamp' => $timestamp,
                'mapel_id' => $mapel_id,
                'user_id' => $user_id
            ];

            $this->db->insert('redeem', $data);



            alert("success", "", "<strong>Data berhasil di redeem</strong>");
            // echo '<script>console.log(' . $result . ')</script>';

            redirect('profil');
        } else {

            // echo '<pre>';
            // echo '<script>console.log(' . $result . ')</script>';
            // print_r($result);

            $message = $result['message'];

            alert("warning", "", "<strong>{$message}</strong>");

            // $this->session->set_flashdata('message', $message);

            redirect('profil');
        }
    }





    // Example Success Commit

    public function json()

    {

        $this->load->view('success.json');
    }

    public function getJson()

    {

        $json = file_get_contents('http://localhost/reedemcode/redeem/json');

        echo '<pre>';

        print_r(json_decode($json, true));
    }
}
