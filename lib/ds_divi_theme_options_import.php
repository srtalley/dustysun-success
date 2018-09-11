<?php
/* Imports Divi options
*  v1.2
*/
if(!class_exists('DS_Divi_Import')) { class DS_Divi_Import {
  public function __construct($file) {
    $this->import_divi_theme_options($file);
  } //end construct

  public function import_divi_theme_options($file = null) {
    if(!$file) return false;

    $json_file = @file_get_contents($file);
    //see if there was anything in the json file
    if($json_file !=FALSE && $json_file != null && $json_file != '') {

      $theme_options_import = json_decode($json_file, true);

      //get only the data key
      $theme_options_import = $theme_options_import['data'];

      //get current theme options
      $theme_options_current = get_option('et_divi','');

      //update logo and favicon paths
      preg_match('~/wp-content/(.*)~', $theme_options_import['divi_logo'], $matches);
      $theme_options_import['divi_logo'] = get_site_url() . $matches[0];

      //merge the imported options with the existing ones
      $theme_options_merged = array_merge($theme_options_current, $theme_options_import);

      $result = update_option('et_divi', $theme_options_merged);

    } //end if($json_file != null || $json_file != '')

  } //end public function import_divi_theme_options

}}//END CLASS
