<?php

/**
 * Copyright (c) 2017 airDesign.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of the
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package     [ coreFramework ]
 * @subpackage  [ cqured ]
 * @author      Owusu-Afriyie Kofi <koathecedi@gmail.com>
 * @copyright   2017 airDesign.
 * @license     http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link        http://airdesign.co.nf
 * @version     @@2.00@@
 */
declare(strict_types=1);

    session_start();

    //check if the site is offline,
    //if yes, show offline page and account login,
        //if login, display site

    //else if no, show the default page that is set as home.
        //check if the page exists,
            //if yes, show page
                //else, it show error page
    define('DS', DIRECTORY_SEPARATOR);

    require_once '..'.DS.'config.php';
    $adConfig = new AdConfig;






if ($adConfig->offline) {
    echo json_encode(["noti"=>"success","result"=>$adConfig->offline_message]);
} else {
    require_once 'core.php';
    //Check Restrictions

    if ($_SERVER['SERVER_NAME'] == $_SERVER['HTTP_HOST']) {
        require_once 'airjax.php';
        $airJax = new AirJax();
    } elseif (authorization()) {
        require_once 'airjax.php';
        $airJax = new AirJax();
    } else {
        die('WHO ARE YOU');
    }
}


 // Also look for a way to generate TOKENS per each call(ajax) for verfication.
 // To prevent spoofing, also check to see if the requested component requires authentication and if the person
 // or client is authenticated, and the right user to make those changes

    //CrossOringin Checks
    // This should be a separate class
function authorization():bool
{
    if (isset($adConfig->cors)) {
        for ($i=0; $i < count($adConfig->cors); $i++) {
            if ($adConfig->cors[$i] == $_SERVER['REMOTE_ADDR']) {
                return true;
            }

            return false;
        }
    } else {
        return false;
    }
}
