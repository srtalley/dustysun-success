<?php

//vars
$ds_version = $this->main_settings['version'];
$ds_author = $this->main_settings['author'];
$ds_author_uri = $this->main_settings['author_uri'];
$ds_name = $this->main_settings['name'];
$ds_item_uri = $this->main_settings['item_uri'];

?>

<div style="text-align:center;" class="ds-wp-settings-api-admin-flexcenter">
  <p><strong><?php echo $ds_name; ?></strong></p>
  <p>Version: <?php echo $ds_version; ?></p>
  <p>Author: <a href="<?php echo $ds_author_uri; ?>" target="_blank"><?php echo $ds_author; ?></a></p>
  <p>Theme Homepage: <a href="<?php echo $ds_item_uri; ?>" target="_blank"><?php echo $ds_item_uri; ?></a></p>
</div>
