<?php

// $Id$

// This file contains internal configuration settings.   You should not need 
// to change them unless you are making changes to the MRBS code.


/***************************************
 * DOCTYPE - internal use, do not change
 ***************************************/

 define('DOCTYPE', '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">');
 
 // Records which DOCTYPE is being used.    Do not change - it will not change the DOCTYPE
 // that is used;  it is merely used when the code needs to know the DOCTYPE, for example
 // in calls to nl2br.   TRUE means XHTML, FALSE means HTML.
 define('IS_XHTML', FALSE);

/*************************************************
 * ENTRY STATUS CODES - internal use, do not change
 *************************************************/

// The status code field for an entry is a tinyint (smallint on PostgreSQL)
// with individual bits set to record the various possible boolean properties
// of a booking:
//
// Bit 0:  Privacy status (set = private)
// Bit 1:  Approval status (set = not yet approved)
// Bit 2:  Confirmation status (set = not yet confirmed)
//
// A "standard" booking has status 0x00;


define('STATUS_PRIVATE',           0x01);
define('STATUS_AWAITING_APPROVAL', 0x02);
define('STATUS_TENTATIVE',         0x04);


/*************************************************
 * REPEAT TYPE CODES - internal use, do not change
 *************************************************/
 
define('REP_NONE',            0);
define('REP_DAILY',           1);
define('REP_WEEKLY',          2);
define('REP_MONTHLY',         3);
define('REP_YEARLY',          4);
define('REP_MONTHLY_SAMEDAY', 5);
define('REP_N_WEEKLY',        6);

/****************************************************************
 * DATABASE TABLES  - internal use, do not change
 ****************************************************************/

// CUSTOM FIELDS
// Prefix for custom field variable names
define('VAR_PREFIX', 'f_');  // must begin with a letter;

// STANDARD FIELDS
// These are the standard fields in the database tables.   If you add more
// standard (not user defined, custom) fields, then you need to change these

$standard_fields['entry'] = array('id',
                                  'start_time',
                                  'end_time',
                                  'entry_type',
                                  'repeat_id',
                                  'room_id',
                                  'timestamp',
                                  'create_by',
                                  'name',
                                  'type',
                                  'description',
                                  'status',
                                  'reminded',
                                  'info_time',
                                  'info_user',
                                  'info_text');
                                  
$standard_fields['repeat'] = array('id',
                                   'start_time',
                                   'end_time',
                                   'rep_type',
                                   'end_date',
                                   'rep_opt',
                                   'room_id',
                                   'timestamp',
                                   'create_by',
                                   'name',
                                   'type',
                                   'description',
                                   'rep_num_weeks',
                                   'status',
                                   'reminded',
                                   'info_time',
                                   'info_user',
                                   'info_text');

// Boolean fields.    These are fields which are treated as booleans                                
$boolean_fields['area'] = array('private_enabled',
                                'private_default',
                                'private_mandatory',
                                'min_book_ahead_enabled',
                                'max_book_ahead_enabled',
                                'approval_enabled',
                                'reminders_enabled',
                                'enable_periods',
                                'confirmation_enabled',
                                'confirmed_default');
                                   
/********************************************************
 * Miscellaneous
 ********************************************************/
// Save some of the default per-area settings for later use.   We
// do this because they will get overwritten by the values for
// the current area in a moment - in standard_vars.inc by a call to 
// get_area_settings().   [This isn't a very elegant way of handling
// per-area settings and perhaps ought to be revisited at some stage]

$area_defaults = array();
$area_defaults['resolution']             = $resolution;
$area_defaults['default_duration']       = $default_duration;
$area_defaults['morningstarts']          = $morningstarts;
$area_defaults['morningstarts_minutes']  = $morningstarts_minutes;
$area_defaults['eveningends']            = $eveningends;
$area_defaults['eveningends_minutes']    = $eveningends_minutes;
$area_defaults['private_enabled']        = $private_enabled;
$area_defaults['private_default']        = $private_default;
$area_defaults['private_mandatory']      = $private_mandatory;
$area_defaults['private_override']       = $private_override;
$area_defaults['min_book_ahead_enabled'] = $min_book_ahead_enabled;
$area_defaults['max_book_ahead_enabled'] = $max_book_ahead_enabled;
$area_defaults['min_book_ahead_secs']    = $min_book_ahead_secs;
$area_defaults['max_book_ahead_secs']    = $max_book_ahead_secs;
$area_defaults['approval_enabled']       = $approval_enabled;
$area_defaults['reminders_enabled']      = $reminders_enabled;
$area_defaults['enable_periods']         = $enable_periods;
$area_defaults['confirmation_enabled']   = $confirmation_enabled;
$area_defaults['confirmed_default']      = $confirmed_default;
                               
/********************************************************
 * PHP System Configuration - internal use, do not change
 ********************************************************/

// Disable magic quoting on database returns:
set_magic_quotes_runtime(0);

// Make sure notice errors are not reported, they can break mrbs code:
$error_level = E_ALL ^ E_NOTICE;
if (defined("E_DEPRECATED"))
{
  $error_level = $error_level ^ E_DEPRECATED;
}
error_reporting ($error_level);

?>