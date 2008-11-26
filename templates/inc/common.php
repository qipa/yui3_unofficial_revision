<?php

if (!isset($docroot)) { $docroot=""; }
$dataroot = $docroot."examples/data/";

$developerHome = 'http://developer.yahoo.com/yui/3';

$loggerAvailable = false;

$aTypes = array('core', 'utility', 'infra', 'widget', 'tool', 'css', 'nodeplugin');

$oTypeNames = array('css'=>'YUI 3 CSS Foundation',
					'core'=>'YUI 3 Core',
                    'utility'=>'YUI 3 Utilities', 
                    'infra'=>'YUI 3 Component Infrastructure',
                    'widget' => 'YUI 3 Widgets',
                    'tool'=>'YUI 3 Developer Tools',
                    'nodeplugin' => 'YUI 3 Node Plugin');

//ydn indicates whether this is for the website or for distribution
if(!isset($ydn)) {
    $ydn = (isset($_GET['ydn'])) ? $_GET['ydn'] : false;
}

$externalLabel = ($ydn) ? "" : "(external)"; //used to stamp external links in dist

//for customizing build path during development:
if(!isset($buildpath)) {
    $buildpath = (isset($_GET['buildpath'])) ? $_GET['buildpath'] : false;
}

//The current YUI version, for building filepaths in docs:
if (!isset($yuiCurrentVersion)) {
    if (isset($_GET['v'])) {
        $yuiCurrentVersion = $_GET['v'];
    } else {
        $yuiCurrentVersion = "[yuiCurrentVersion]";
    }
}

function getExampleResources() {
    global $docroot;
    global $buildpath;
    global $yuiCurrentVersion;
    global $buildDirectory;
    global $logIncludes;

    if (is_file($docroot."inc/exampleResources.php")) {
        ob_start();
        include $docroot."inc/exampleResources.php";
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    } else {
        return "<!--Error including Example JS/CSS files-->";
    }
}

require($docroot."examples/module/modules.php");
