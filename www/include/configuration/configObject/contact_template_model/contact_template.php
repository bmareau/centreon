<?php
/*
 * Copyright 2005-2013 Centreon
 * Centreon is developped by : Julien Mathis and Romain Le Merlus under
 * GPL Licence 2.0.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation ; either version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 *
 * Linking this program statically or dynamically with other modules is making a
 * combined work based on this program. Thus, the terms and conditions of the GNU
 * General Public License cover the whole combination.
 *
 * As a special exception, the copyright holders of this program give Centreon
 * permission to link this program with independent modules to produce an executable,
 * regardless of the license terms of these independent modules, and to copy and
 * distribute the resulting executable under terms of Centreon choice, provided that
 * Centreon also meet, for each linked independent module, the terms  and conditions
 * of the license of that module. An independent module is a module which is not
 * derived from this program. If you modify this program, you may extend this
 * exception to your version of the program, but you are not obliged to do so. If you
 * do not wish to do so, delete this exception statement from your version.
 *
 * For more information : contact@centreon.com
 *
 */

if (!isset($centreon)) {
    exit ();        
}

isset($_GET["contact_id"]) ? $cG = $_GET["contact_id"] : $cG = NULL;
isset($_POST["contact_id"]) ? $cP = $_POST["contact_id"] : $cP = NULL;
$cG ? $contact_id = $cG : $contact_id = $cP;

isset($_GET["select"]) ? $cG = $_GET["select"] : $cG = NULL;
isset($_POST["select"]) ? $cP = $_POST["select"] : $cP = NULL;
$cG ? $select = $cG : $select = $cP;

isset($_GET["dupNbr"]) ? $cG = $_GET["dupNbr"] : $cG = NULL;
isset($_POST["dupNbr"]) ? $cP = $_POST["dupNbr"] : $cP = NULL;
$cG ? $dupNbr = $cG : $dupNbr = $cP;

/*
 * Pear library
 */
require_once "HTML/QuickForm.php";
require_once 'HTML/QuickForm/select2.php';
require_once 'HTML/QuickForm/Renderer/ArraySmarty.php';

/*
 * Path to the configuration dir
 */
$path = "./include/configuration/configObject/contact_template_model/";

/*
 * PHP functions
 */
require_once "./include/configuration/configObject/contact/DB-Func.php";
require_once "./include/common/common-Func.php";

/* Set the real page */
if ($ret['topology_page'] != "" && $p != $ret['topology_page']) {
    $p = $ret['topology_page'];
}

$contactObj = new CentreonContact($pearDB);
    
switch ($o) {
    case "mc" : require_once($path."formContactTemplateModel.php"); break; // Massive Change
    case "a" : require_once($path."formContactTemplateModel.php"); break; // Add a contact template
    case "w" : require_once($path."formContactTemplateModel.php"); break; // Watch a contact template
    case "c" : require_once($path."formContactTemplateModel.php"); break; // Modify a contact template
    case "s" : enableContactInDB($contact_id); require_once($path."listContactTemplateModel.php"); break; // Activate a contact template
    case "ms" : enableContactInDB(NULL, isset($select) ? $select : array()); require_once($path."listContactTemplateModel.php"); break;
    case "u" : disableContactInDB($contact_id); require_once($path."listContactTemplateModel.php"); break; // Desactivate a contact
    case "mu" : disableContactInDB(NULL, isset($select) ? $select : array()); require_once($path."listContactTemplateModel.php"); break;
    case "m" : multipleContactInDB(isset($select) ? $select : array(), $dupNbr); require_once($path."listContactTemplateModel.php"); break; // Duplicate n contacts
    case "d" : deleteContactInDB(isset($select) ? $select : array()); require_once($path."listContactTemplateModel.php"); break; // Delete n contacts
    default : require_once($path."listContactTemplateModel.php"); break;
}
