<?= '<', '?php '; ?>

return [
<?php
foreach ($tables as $tbl)
   echo "['label' => '$tbl', 'icon' => 'new', 'url' => ['/core/$tbl'],],\n";
?>];