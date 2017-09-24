<?= '<', '?php '; ?>

return [
<?php
foreach ($tables as $tbl)
   echo "['label' => '",$tbl['notion'],"', 'icon' => 'new', 'url' => ['/core/",\backend\ErpGenerator::generateClassRouter($tbl['name']),"'],],\n";
?>];