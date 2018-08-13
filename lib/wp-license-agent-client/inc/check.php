<?php
/*
 * WP License Agent License Checker Library
 *
 * Version 1.5
 *
 * https://dustysun.com
 *
 * Copyright 2018 Dusty Sun
 * Released under the GPLv2 license.
 * 
 */

namespace DustySun\WP_License_Agent\Updater\v1_5;

if(!class_exists('DustySun\WP_License_Agent\Updater\v1_4\License_Check')) {
class License_Check {

  static function retrieve_license_info($update_settings) {
      
    $request = wp_remote_get( $update_settings['checklicense_url'] );

    if( is_wp_error( $request )) {
      return false;
    }
    $body = wp_remote_retrieve_body($request);

    $data = json_decode($body);

    update_option($update_settings['update_slug'] . '_daily_license_check', $data);
    update_option($update_settings['update_slug'] . '_license_validity', $data->valid);

    return($data);

  } // end function retrieve_license_info

}} // end class 