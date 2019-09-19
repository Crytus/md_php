<?php
/**
Article by MarkDown

Copyright (c) 2019 KURIHARA Yoshiaki

This software is released under the MIT License.
http://opensource.org/licenses/mit-license.php
*/
$ary = explode("/",  $_SERVER["REQUEST_URI"]);
array_shift($ary);
array_pop($ary);
$dir = implode("/", $ary);
$template = $dir . "/template.html";
if (!file_exists($template)) {
	$template = __DIR__ . "/template.html";
}

spl_autoload_register(function($class){
	require str_replace('\\', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

use Michelf\MarkdownExtra;

if ($_REQUEST["f"]) {
	$file = $_REQUEST["f"];
} else {
	if (isset($_SERVER['PATH_TRANSLATED'])) {
	    $file = realpath($_SERVER['PATH_TRANSLATED']);
	}
}
if ($file and is_readable($file)) {
	$lines = file($file);
	while (substr($lines[0], 0, 1) == "@") {
		$str = trim(array_shift($lines));
		if (substr($str, 0, 2) == "@t") {	// �^�C�g��
			$title = substr($str, 3);
		}
		if (substr($str, 0, 2) == "@k") {	// �L�[���[�h
			$keywords = substr($str, 3);
		}
		if (substr($str, 0, 2) == "@d") {	// ������
			$description = substr($str, 3);
		}
		if (substr($str, 0, 2) == "@h") {	// HTML�t�@�C��
			$tf = $dir . "/" . substr($str, 3);
			if (file_exists($tf)) {
				$template = $tf;
			}
		}
	}
	// ��s������
	if (!trim($lines[0])) {
		array_shift($lines);
	}
	$html = MarkdownExtra::defaultTransform(implode("", $lines));
} else {
    $html = '<p>cannot read file</p>';
}

$base = "/";

include($template);
