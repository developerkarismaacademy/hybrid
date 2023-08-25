<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kursus extends CI_Controller
{

	private $data;

	public function __construct()
	{
		parent::__construct();
		$this->data['page'] = "kursus";

		$this->load->model("front-v2/KelasModel", "FrontKelasModel");
		$this->load->model("front-v2/MapelModel", "FrontMapelModel");
		$this->load->model("front-v2/BabModel", "FrontBabModel");
		$this->load->model("front-v2/MateriModel", "FrontMateriModel");
		$this->load->model("front-v2/UlasanModel", "FrontUlasanModel");
	}


	public function detail($meta_link_mapel = "")
	{
		$where = "meta_link_mapel = '{$meta_link_mapel}'";

		$dataMapel = $this->FrontMapelModel->getAllMapel($where);


		if ($dataMapel["total"] > 0) {
			$mapel = $dataMapel["data"][0];
			//Dynamic Content
			$listhasil = $this->UniversalModel->getAllData("mapel_listhasil", "mapel_id = {$mapel['id_mapel']}", "*");
			$previewMateri = $this->UniversalModel->getAllData("preview", "mapel_id = {$mapel['id_mapel']}", "*", "urutan_preview", "ASC");
			$portofolioMateri = $this->UniversalModel->getAllData("portofolio", "mapel_id = {$mapel['id_mapel']}", "*", "urutan_portofolio", "ASC");
			$targetMateri = $this->UniversalModel->joinGetAll("target",
				[
					[
						"table" => "targetitem",
						"join" => "target.id_target = targetitem.target_id",
						"tipe" => ""
					],
				],
				"mapel_id = {$mapel['id_mapel']}", "*");

			//Restructure list
			$targetMateri_temp = [];
			if ($targetMateri["total"] > 0) {
				foreach ($targetMateri["data"] as $keyTarget => $valueTarget) {
					$targetMateri_temp["data"][$valueTarget['slug_target']]["title_target"] = $valueTarget['title_target'];
					$targetMateri_temp["data"][$valueTarget['slug_target']]["list"][] = $valueTarget['item_target'];
				}
				$targetMateri = $targetMateri_temp;
				$targetMateri["total"] = count($targetMateri_temp["data"]);
			}
			//End Restructure List

			$allBab = $this->FrontBabModel->getAllBab("mapel_id = {$mapel["id_mapel"]}");

			if ($allBab["total"] > 0) {
				foreach ($allBab["data"] as $keyBab => $valueBab) {
					$allBab["data"][$keyBab]["materi"] = $this->FrontMateriModel->getAllMateri("bab_id = {$valueBab["id_bab"]}");
				}
			}

			$bintang1 = $this->FrontUlasanModel->getAllUlasan("mapel_id = {$mapel["id_mapel"]} AND rating = 1", "rating.created_at");
			$bintang2 = $this->FrontUlasanModel->getAllUlasan("mapel_id = {$mapel["id_mapel"]} AND rating = 2", "rating.created_at");
			$bintang3 = $this->FrontUlasanModel->getAllUlasan("mapel_id = {$mapel["id_mapel"]} AND rating = 3", "rating.created_at");
			$bintang4 = $this->FrontUlasanModel->getAllUlasan("mapel_id = {$mapel["id_mapel"]} AND rating = 4", "rating.created_at");
			$bintang5 = $this->FrontUlasanModel->getAllUlasan("mapel_id = {$mapel["id_mapel"]} AND rating = 5", "rating.created_at");

			$mapelRekom = $this->FrontMapelModel->getAllMapel("kelas_id = {$mapel["kelas_id"]}", "RAND()", "", 4);

			$this->data["title"] = "Beli Kursus {$mapel["nama_mapel"]}";
			$this->data["mapel"] = $mapel;
			$this->data["total_bintang"] = $bintang1["total"] + $bintang2["total"] + $bintang3["total"] + $bintang4["total"] + $bintang5["total"];
			$this->data["bintang1"] = $bintang1;
			$this->data["bintang2"] = $bintang2;
			$this->data["bintang3"] = $bintang3;
			$this->data["bintang4"] = $bintang4;
			$this->data["bintang5"] = $bintang5;
			$this->data["bab"] = $allBab;
			$this->data["mapelRekom"] = $mapelRekom;
			$this->data['content'] = "kursus.detail";

			//Dynamic Content
			$this->data["listhasil"] = $listhasil;
			$this->data['previewMateri'] = $previewMateri;
			$this->data['portofolioMateri'] = $portofolioMateri;
			$this->data['targetMateri'] = $targetMateri;
		} else {
			$this->data["title"] = "Kursus Tidak Di Temukan";
			$this->data["content"] = "404";
		}

		$this->load->view("front-v2/main", $this->data);
	}

	public function ulasanJson($meta_link_mapel)
	{
		$where = "meta_link_mapel = '{$meta_link_mapel}'";

		$dataMapel = $this->FrontMapelModel->getAllMapel($where);
		$return = [];
		if ($dataMapel["total"] > 0) {

			$mapel = $dataMapel["data"][0];
			$url = "data-ulasan-mapel/{$mapel["meta_link_mapel"]}";

			$code = 200;
			$dataAllUlasan = $this->FrontMapelModel->getAllUlasan("mapel_id = {$mapel["id_mapel"]}");


			$limit = $_GET["limit"] ?? 5;
			$page = $_GET['page'] ?? 1;
			$start = ($page > 1) ? ($page * $limit) - $limit : 0;


			$total = $dataAllUlasan["total"];
			$totalPage = ceil($total / $limit);

			$sort = $_GET["sort"] ?? "baru";

			$sortColumn = "rating.created_at";
			$sortMode = "DESC";

			switch ($sort) {

				case "baru":
					$sortColumn = "rating.created_at";
					$sortMode = "DESC";
					break;

				case "dulu":
					$sortColumn = "rating.created_at";
					$sortMode = "ASC";
					break;

				case "top":
					$sortColumn = "rating";
					$sortMode = "DESC";
					break;
			}

			$dataUlasan = $this->FrontMapelModel->getPagingUlasan("mapel_id = {$mapel["id_mapel"]}", $sortColumn, $sortMode, $limit, $start);

			$params = "";
			if (isset($_GET) && count($_GET) > 0) {
				foreach ($_GET as $name => $value) {
					if ($name != "page") {
						$params .= "&{$name}={$value}";
					}
				}
			}

			$first_page = $totalPage == 1 || $page == 1 ? "#" : base_url($url) . "?page=1" . $params;
			$last_page = $totalPage == 1 || $page == $totalPage ? "#" : base_url($url) . "?page={$totalPage}" . $params;

			if (($page + 1) <= $totalPage) {
				$next_page = base_url($url) . "?page=" . ($page + 1) . $params;
			} else {
				$next_page = "#";
			}

			if (($page - 1) >= 1) {
				$prev_page = base_url($url) . "?page=" . ($page - 1) . $params;
			} else {
				$prev_page = "#";
			}

			$return["success"] = true;
			$return["params"] = $params;
			$return['total'] = $total;
			$return['data'] = $dataUlasan["data"];
			$return['total_in_page'] = $dataUlasan["total"];
			$return['total_page'] = $totalPage;
			$return['start'] = $start;
			$return['end'] = $start + $dataUlasan["total"];
			$return['url_first_page'] = $first_page;
			$return['url_next_page'] = $next_page;
			$return['url_prev_page'] = $prev_page;
			$return['url_last_page'] = $last_page;
			$return['current_page'] = $page;
		} else {
			$code = 404;

			$return["success"] = false;
			$return["message"] = "Data Kosong";
		}

		return $this->output
			->set_content_type('application/json')
			->set_status_header($code)
			->set_output(json_encode($return));
	}
}
