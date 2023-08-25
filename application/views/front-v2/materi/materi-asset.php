<?php

if ($asset["total"] > 0) { ?>

	<ul class="nav materi-tab border-tab mb-3" id="materi-tab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active text-white p-2" id="materi-download-list"
			   data-toggle="tab" href="#materi-download" role="tab"
			   aria-controls="materi-download" aria-selected="true">Download</a>
		</li>
	</ul>
	<div id="materi-download" aria-labelledby="materi-download-list" aria-selected="true"
		 class="row tab-pane fade show active" role="tabpanel">
		<div class="col-12 col-md-6">
			<?php foreach ($asset["data"] as $keyAsset => $valueAsset) { ?>
				<a href="<?= $valueAsset["tipe"] == "file" ? base_url("upload/asset/{$valueAsset["link"]}") : $valueAsset["link"] ?>"
				   class="border border-ka-dark p-2 mb-3 d-block download-item" target="_blank">
					<i class="fa fa-image text-warning"></i>
					<span class="text-truncate">
						<u><?= $valueAsset["nama"] ?></u>
					</span>
				</a>


			<?php } ?>
		</div>
	</div>

<?php } ?>
