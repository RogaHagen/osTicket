<?php
/*********************************************************************
    class.misc.php

    Misc collection of useful generic helper functions.

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/

const ICONWEB           = 'icon-globe';
const ICONMAIL          = 'icon-envelope';
const ICONMAIL2         = 'icon-envelope-alt';
const ICONPHONE         = 'icon-phone';
const ICONMISC          = 'icon-tag';
const ICONSYSTEM        = 'icon-gear';
const ICONDONE          = 'icon-check-sign';
const ICONSOLVED        = 'icon-check';
const ICONOPEN          = 'icon-unchecked';
const ICONCLOSED        = 'icon-lock';
const ICONOVERDUE       = 'icon-warning-sign';
const ICONUNSIGNED      = 'icon-warning-sign';
const ICONANSWERED      = 'icon-folder-open';
const ICONUNANSWERED    = 'icon-folder-close';
const ICONLOCKED        = 'icon-key';
const ICONTHREAD        = 'icon-comments';
const ICONGROUP         = 'icon-group';
const ICONTEAM          = 'icon-group';
const ICONAGENT         = 'icon-user';
const ICONUSER          = 'icon-user';
const ICONDEPARTMENT    = 'icon-building';
const ICONATTACHMENT    = 'icon-file-text';
const ICONTASK          = 'icon-list';
const ICONUNKNOWN       = 'icon-question-sign';

const TICKETOPEN        = 1;
const TICKETSOLVED      = 2;
const TICKETCLOSED      = 3;
const TICKETARCHIVED    = 4;
const TICKETDELETED     = 5;

const TICKETOVERDUED    = 1;
const TICKETLOCKED      = 2;
const TICKETANSWERED    = 3;
const TICKETUNANSWERED  = 4;
const TICKETFINISHED    = 5;

class Misc {

    function icon($icon, $class, $tooltip){
        if ($class == '') $class = 'icon-center icon-faded';
        $var='<i class="'.$icon.' '.$class.' icon-fixed-width" data-toggle="tooltip" title="'.$tooltip.'"></i>';
        return $var;
    }
    
    function icon_closestate($status){
        if (!strcasecmp($status,'offen')){
            $var = Misc::icon(ICONOPEN, '', 'Das Ticket ist offen');
        }elseif (!strcasecmp($status,'gelöst')){
            $var = Misc::icon(ICONSOLVED, '', 'Das Ticket ist gelöst');
        }elseif (!strcasecmp($status,'geschlossen')){
            $var = Misc::icon(ICONCLOSED, '', 'Das Ticket ist geschlossen');
        }else{
            $var = Misc::icon(ICONUNKNOWN, '', 'Der Ticketstatus ist unbekannt');       
        }
        return $var;
    }

    function icon_openstate($state){
        if ($state == 'overdue'){
            $var = Misc::icon(ICONOVERDUE, 'icon-center icon-red', 'Das Ticket ist überfällig');
        }elseif ($state == 'locked'){
            $var = Misc::icon(ICONLOCKED, 'icon-center icon-red', 'Das Ticket ist momentan gesperrt');
        }elseif ($state == 'opened') {
            $var = Misc::icon(ICONUNANSWERED, '', 'Das Ticket ist offen und unbeantwortet');
        }elseif ($state== 'closed') {
            $var = Misc::icon(ICONANSWERED, '', 'Das Ticket ist offen und beantwortet');
        }elseif ($state== 'done') {
            $var = Misc::icon(ICONDONE, '', 'Das Ticket ist fertig und abgearbeitet');
        }
        return $var;
    }
 
    function icon_annotation($thread, $attachment, $collab, $tasks){
        $var = '<span class="pull-right">';
        if ($thread > 1)
            $var = $var.Misc::icon(ICONTHREAD, '', 'Das Ticket enthält '.$thread.' Vorgänge');
        if ($tasks > 1)
            $var = $var.Misc::icon(ICONTASK, '', 'Das Ticket enthält '.$tasks.' Aufgaben');
        if ($tasks == 1)
            $var = $var.Misc::icon(ICONTASK, '', 'Das Ticket enthält '.$tasks.' Aufgabe');
        if ($attachment > 1)
            $var = $var.Misc::icon(ICONATTACHMENT, '', 'Das Ticket enthält '.$attachment.' Dateianhänge');
        if ($attachment == 1)
            $var = $var.Misc::icon(ICONATTACHMENT, '', 'Das Ticket enthält '.$attachment.' Dateianhang');
        if ($collab > 1)
            $var = $var.Misc::icon(ICONGROUP, '', 'An dem Ticket sind '.$collab.' weitere Personen beteiligt');
        if ($collab == 1)
            $var = $var.Misc::icon(ICONUSER, '', 'An dem Ticket ist '.$collab.' weitere Person beteiligt');
        $var = $var.'</span>';
        return $var;
    }
    
    function icon_source($ticket_source){
        if (!strcasecmp($ticket_source,'web')) {
            $var = Misc::icon(ICONWEB, '', 'Das Ticket wurde über die Website eingeliefert');
        }elseif (!strcasecmp($ticket_source,'email')) {
            $var = Misc::icon(ICONMAIL, '', 'Das Ticket wurde per E-Mail eingeliefert');
        }elseif (!strcasecmp($ticket_source,'phone')) {
            $var =  Misc::icon(ICONPHONE, '', 'Das Ticket wurde nach einem Telefonat erfasst');
        }elseif (!strcasecmp($ticket_source,'api')) {
            $var =  Misc::icon(ICONSYSTEM, '', 'Das Ticket wurde durch die API eingeliefert');
        }elseif (!strcasecmp($ticket_source,'other')) {
            $var =  Misc::icon(ICONMISC, '', 'Das Ticket wurde durch eine andere Quelle eingerichtet');
        }else {
            $var =  Misc::icon(ICONMISC, '', 'Das Ticket wurde durch eine andere Quelle eingerichtet');
        }
        return $var;
        
    }
    
    function randCode($len=8, $chars=false) {
        $chars = $chars ?: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890_=';

        // Determine the number of bits we need
        $char_count = strlen($chars);
        $bits_per_char = ceil(log($char_count, 2));
        $bytes = ceil(4 * $len / floor(32 / $bits_per_char));
        // Pad to 4 byte boundary
        $bytes += (4 - ($bytes % 4)) % 4;

        // Fetch some random data blocks
        $data = Crypto::random($bytes);

        $mask = (1 << $bits_per_char) - 1;
        $loops = (int) (32 / $bits_per_char);
        $output = '';
        $ints = unpack('V*', $data);
        foreach ($ints as $int) {
            for ($i = $loops; $i > 0; $i--) {
                $output .= $chars[($int & $mask) % $char_count];
                $int >>= $bits_per_char;
            }
        }
        return substr($output, 0, $len);
	}

    function __rand_seed($value=0) {
        // Form a 32-bit figure for the random seed with the lower 16-bits
        // the microseconds of the current time, and the upper 16-bits from
        // received value
        $seed = ((int) $value % 65535) << 16;
        $seed += (int) ((double) microtime() * 1000000) % 65535;
        mt_srand($seed);
    }

    /* Helper used to generate ticket IDs */
    function randNumber($len=6,$start=false,$end=false) {

        $start=(!$len && $start)?$start:str_pad(1,$len,"0",STR_PAD_RIGHT);
        $end=(!$len && $end)?$end:str_pad(9,$len,"9",STR_PAD_RIGHT);

        return mt_rand($start,$end);
    }

    /* misc date helpers...this will go away once we move to php 5 */
    function db2gmtime($var){
        static $dbtz;
        global $cfg;

        if (!$var || !$cfg)
            return;

        if (!isset($dbtz))
            $dbtz = new DateTimeZone($cfg->getDbTimezone());

        $dbtime = is_int($var) ? $var : strtotime($var);
        $D = DateTime::createFromFormat('U', $dbtime);
        if (!$D)
            // This happens e.g. from negative timestamps
            return $var;

        return $dbtime - $dbtz->getOffset($D);
    }

    // Take user's time and return GMT time.
    function user2gmtime($timestamp=null, $user=null) {
        global $cfg;

        $tz = new DateTimeZone($cfg->getTimezone($user));

        if ($timestamp && is_int($timestamp)) {
            if (!($date = DateTime::createFromFormat('U', $timestamp)))
                return $timestamp;

            return $timestamp - $tz->getOffset($date);
        }

        $date = new DateTime($timestamp ?: 'now', $tz);
        return $date ? $date->getTimestamp() : $timestamp;
    }

    //Take user time or gmtime and return db (mysql) time.
    function dbtime($var=null){
        static $dbtz;
        global $cfg;

        if (is_null($var) || !$var) {
            // Default timezone is set to UTC
            $time = time();
        } else {
            // User time to UTC
            $time = self::user2gmtime($var);
        }

        if (!isset($dbtz)) {
            $dbtz = new DateTimeZone($cfg->getDbTimezone());
        }
        // UTC to db time
        $D = DateTime::createFromFormat('U', $time);
        return $time + $dbtz->getOffset($D);
    }

    /*Helper get GM time based on timezone offset*/
    function gmtime($time=false, $user=false) {
        global $cfg;

        $tz = new DateTimeZone($user ? $cfg->getDbTimezone($user) : 'UTC');

       if ($time && is_numeric($time))
          $time = DateTime::createFromFormat('U', $time);
        elseif (!($time = new DateTime($time ?: 'now'))) {
            // Old standard
            return time() - date('Z');
        }

        return $time->getTimestamp() - $tz->getOffset($time);
    }

    /* Needed because of PHP 4 support */
    function micro_time() {
        list($usec, $sec) = explode(" ", microtime());

        return ((float)$usec + (float)$sec);
    }

    //Current page
    function currentURL() {

        $str = 'http';
        if ($_SERVER['HTTPS'] == 'on') {
            $str .='s';
        }
        $str .= '://';
        if (!isset($_SERVER['REQUEST_URI'])) { //IIS???
            $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
            if (isset($_SERVER['QUERY_STRING'])) {
                $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];
            }
        }
        if ($_SERVER['SERVER_PORT']!=80) {
            $str .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        } else {
            $str .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        }

        return $str;
    }

    function timeDropdown($hr=null, $min =null,$name='time') {
        global $cfg;

        //normalize;
        if ($hr >= 24)
            $hr = $hr%24;
        elseif ($hr < 0)
            $hr = 0;
        elseif ($hr)
            $hr = (int) $hr;
        else  // Default to 5pm
            $hr = 17;

        if ($min >= 45)
            $min = 45;
        elseif ($min >= 30)
            $min = 30;
        elseif ($min >= 15)
            $min = 15;
        else
            $min = 0;

        $time = Misc::user2gmtime(mktime(0,0,0));
        ob_start();
        echo sprintf('<select name="%s" id="%s" style="display:inline-block;width:auto">',$name,$name);
        echo '<option value="" selected="selected">&mdash;'.__('Time').'&mdash;</option>';
        for($i=23; $i>=0; $i--) {
            for ($minute=45; $minute>=0; $minute-=15) {
                $sel=($hr===$i && $min===$minute) ? 'selected="selected"' : '';
                $_minute=str_pad($minute, 2, '0',STR_PAD_LEFT);
                $_hour=str_pad($i, 2, '0',STR_PAD_LEFT);
                $disp = Format::time($time + ($i*3600 + $minute*60 + 1), false);
                echo sprintf('<option value="%s:%s" %s>%s</option>',$_hour,$_minute,$sel,$disp);
            }
        }
        echo '</select>';
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    function realpath($path) {
        $rp = realpath($path);
        return $rp ? $rp : $path;
    }

}
?>
