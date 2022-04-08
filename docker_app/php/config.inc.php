<?php // -*-mode: PHP; coding:utf-8;-*-
// Report all PHP errors
namespace MRBS;


$timezone = "Europe/Athens";
$dbsys = "mysql";
$db_host = "db";
$db_database = "mrbs";
$db_login = "mrbs";
$db_password = "mrbs";
$db_tbl_prefix = "mrbs_";
$db_persist = FALSE;

$auth["admin"] = [
    "kiagias@protonmail.com"
];
$auth['type'] = 'cas';
$auth['session'] = 'cas';

// 'cas' configuration settings
$auth['cas']['host']    = 'cas-proxy.fsyllogos.poiw.org';  // Full hostname of your CAS Server
$auth['cas']['port']    = 443;  // CAS server port (integer). Normally for a https server it's 443
$auth['cas']['context'] = '';  // Context of the CAS Server
// The "real" hosts of clustered cas server that send SAML logout messages
// Assumes the cas server is load balanced across multiple hosts.
// Failure to restrict SAML logout requests to authorized hosts could
// allow denial of service attacks where at the least the server is
// tied up parsing bogus XML messages.
$auth['cas']['real_hosts'] = array('cas-proxy.fsyllogos.poiw.org');

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
$auth['cas']['no_server_validation'] = true;
$auth['cas']['debug']   = true;  // Set to true to enable debug output. Disable for production.
