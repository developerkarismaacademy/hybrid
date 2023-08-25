<script src="<?= base_url(); ?>assets/back/plugins/nestable/jquery.nestable.js"></script>
<?php
// $section on controller Mapel.php/detail
foreach($section as $item){ ?>

<script src="<?= base_url(); ?>assets/back/pages/mapel/detail-<?=$item?>.js" type="text/javascript"></script>

<?php
}
?>
