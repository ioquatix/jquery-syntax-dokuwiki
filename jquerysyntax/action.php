<?php

//	This file is part of the "jQuery.Syntax" project, and is licensed under the GNU AGPLv3.
//	Copyright 2010 Samuel Williams. All rights reserved.
//	See <jquery.syntax.js> for licensing details.

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

class action_plugin_jquerysyntax extends DokuWiki_Action_Plugin {
	function getInfo() {
		return array(
			'author' => 'Samuel Williams',
			'email'  => 'samuel.williams@oriontransfer.co.nz',
			'date'   => '2010-04-23',
			'name'   => 'jQuery.Syntax release-1.9',
			'desc'   => 'Extreme Client-side Syntax Highlighting. Inserts required JavaScript code.',
			'url'    => 'http://www.oriontransfer.co.nz/software/jquery-syntax',
		);
	}

	function register(&$controller) {
		$controller->register_hook('TPL_METAHEADER_OUTPUT','BEFORE', $this, '_inject_js');
	}

	function _inject_js(&$event, $param) {
		$plugin_root = DOKU_BASE."lib/plugins/jquerysyntax";
		
		$event->data['script'][] = array(
			'type'    => 'text/javascript',
			'charset' => 'utf-8',
			'_data'   => '',
			'src'     => $plugin_root.'/jquery-1.4.1.min.js'
			);

		$syntax_root = $plugin_root.'/jquery-syntax/';
		$event->data['script'][] = array(
			'type'    => 'text/javascript',
			'charset' => 'utf-8',
			'_data'   => "jQuery.noConflict(); jQuery(document).ready(function($) { $.syntax({root: \"".$syntax_root."\" }) });"
			);

		$event->data['script'][] = array(
			'type'    => 'text/javascript',
			'charset' => 'utf-8',
			'_data'   => '',
			'src'     => $plugin_root.'/jquery-syntax/jquery.syntax.js'
			);

		$event->data['script'][] = array(
			'type'    => 'text/javascript',
			'charset' => 'utf-8',
			'_data'   => '',
			'src'     => $plugin_root.'/jquery-syntax/jquery.syntax.cache.js'
			);
	}
}
