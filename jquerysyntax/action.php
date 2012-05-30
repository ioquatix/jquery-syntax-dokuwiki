<?php

//	This file is part of the "jQuery.Syntax" project, and is distributed under the MIT License.
//	See <jquery.syntax.js> for licensing details.
//	Copyright (c) 2011 Samuel G. D. Williams. <http://www.oriontransfer.co.nz>

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

class action_plugin_jquerysyntax extends DokuWiki_Action_Plugin {
	function getInfo() {
		return array(
			'author' => 'Samuel Williams',
			'email'  => 'samuel.williams@oriontransfer.co.nz',
			'date'   => '2012-06-01',
			'name'   => 'jQuery.Syntax release-3.1',
			'desc'   => 'Extreme Client-side Syntax Highlighting. Inserts required JavaScript code.',
			'url'    => 'http://www.oriontransfer.co.nz/software/jquery-syntax',
		);
	}

	function register(&$controller) {
		$controller->register_hook('TPL_METAHEADER_OUTPUT','BEFORE', $this, '_inject_js');
	}

	function _inject_js(&$event, $param) {
		$plugin_root = DOKU_BASE."lib/plugins/jquerysyntax";
		global $updateVersion;
		$noConflict = "";
		
		if ($updateVersion < 36.0) {
			$event->data['script'][] = array(
				'type'    => 'text/javascript',
				'charset' => 'utf-8',
				'_data'   => '',
				'src'     => $plugin_root.'/jquery-1.6.min.js'
				);
				
			$noConflict = "jQuery.noConflict();";
		}
		
		$syntax_root = $plugin_root.'/jquery-syntax/';
		$event->data['script'][] = array(
			'type'    => 'text/javascript',
			'charset' => 'utf-8',
			'_data'   => "$noConflict jQuery(document).ready(function($) { $.syntax({blockLayout: 'table'}) });"
			);

		$event->data['script'][] = array(
			'type'    => 'text/javascript',
			'charset' => 'utf-8',
			'_data'   => '',
			'src'     => $plugin_root.'/jquery-syntax/jquery.syntax.min.js'
			);
			
		$event->data['link'][] = array(
			'type'    => 'text/css',
			'charset' => 'utf-8',
			'rel'     => 'stylesheet',
			'media'   => 'screen',
			'href'     => $plugin_root.'/dw-fixes.css'
			);
	}
}
