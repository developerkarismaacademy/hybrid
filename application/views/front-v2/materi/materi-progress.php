<div id="materi-progress-icon" class="px-3 pb-3">
	<div class="progress-icon d-flex position-relative">
		<div class="progress">
			<div class="progress-bar" id="progress-bar" role="progressbar" aria-valuenow="0"
				 aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		<div class="d-flex justify-content-between w-100 overflow-auto">
			<?php
			$totalSelesai = $materi["total"] <= 2 ? 1 : 0.5;
			$sebelum = true;
			if ($materi["total"] > 1) {
				foreach ($materi["data"] as $keyMateri => $valueMateri) {
					$aktif = $urutanCurrent == $valueMateri["urutan_materi"];
					?>
					<a href="<?= $sebelum ? base_url("belajar/{$mapel["meta_link_mapel"]}/{$bab["meta_link_bab"]}/{$valueMateri["urutan_materi"]}") : "javascript:void(0);" ?>"
					   class="jenis-icon"
					   title="<?= ($keyMateri + 1) . ". " . $valueMateri["nama_materi"] ?>">
						<i class="icon-materi im-<?= $sebelum ? iconMateri[$valueMateri["tipe"]] : "mlock" ?> <?= $aktif ? "active" : "done" ?>"></i>
					</a>
					<?php
					if ($valueMateri["log_baca"] > 0 || $valueMateri["log_video"] > 0 || $valueMateri["log_ujian"] > 0 || $valueMateri["log_praktek"] > 0) {
						$sebelum = true;
						if ($valueMateri["log_ujian"] > 0) {
							if ($bab["pretest_status"] == 0) {
								$id_user = $_SESSION['siswaData']['id_user'];
								$nilai = $this->db->get_where('log_ujian', ['materi_id' => $valueMateri['id_materi'], 'user_id' => $id_user])->row_array();
								if ($nilai['nilai'] < 80.00) {
									$sebelum = false;
								}
							}
						}
						if ($valueMateri["log_baca"] > 0) {
							if ($valueMateri["tipe"] == "pdf" && $valueMateri['webinar_status'] == 1) {
								$userId = $_SESSION['siswaData']['id_user'];
								$materiId = $valueMateri['id_materi'];
								$userAbsen = $this->db->query("SELECT * FROM user_absen WHERE user_id = $userId AND materi_id = $materiId");
								if ($userAbsen->num_rows() == 0) {
									$sebelum = false;
								}
							}
						}
						$totalSelesai++;
					} else {
						$sebelum = false;
					}
				}
			}

			$totalSelesai = $totalSelesai <= 0.5 ? 0 : $totalSelesai;
			?>
		</div>
	</div>
</div>
