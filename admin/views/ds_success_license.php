<?php 
$update_slug = $this->get_main_settings()['item_slug'];
use \DustySun\WP_License_Agent\Updater\v1_5 as WPLA;
$license_panel = new WPLA\License_Panel($update_slug);
echo $license_panel->show_license_panel();
?>