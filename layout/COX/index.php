<link href="layout/<?php echo $camp_layout; ?>/css/newcss.css?v=218" rel="stylesheet">
<script type="text/javascript" src="layout/<?php echo $camp_layout; ?>/js/cox.js?v=135"></script>
<?php
$global_url = trim($db->setVal('global_url', 'ADMIN'), "/");
?>
<link rel="shortcut icon" href="<?php echo $global_url; ?>/layout/<?php echo $camp_layout; ?>/img/favicon.ico?v=1" type="image/x-icon" />