<?php

//	This file is part of the "jQuery.Syntax" project, and is licensed under the GNU AGPLv3.
//	Copyright 2010 Samuel Williams. All rights reserved.
//	See <jquery.syntax.js> for licensing details.

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once dirname(__FILE__).'/code.php';

class syntax_plugin_jquerysyntax_file extends syntax_plugin_jquerysyntax_code {
	function getInfo() {
		return array(
			'author' => 'Samuel Williams',
			'email'  => 'samuel.williams@oriontransfer.co.nz',
			'date'   => '2010-02-17',
			'name'   => 'jQuery.Syntax',
			'desc'   => "Extreme Client-side Syntax Highlighting. Replaces DokuWiki's <file> handler.",
			'url'    => 'http://www.oriontransfer.co.nz/software/jquery-syntax',
		);
	}

	function connectTo($mode) {
		$this->Lexer->addEntryPattern('<file(?=[^\r\n]*?>.*?</file>)',$mode,'plugin_jquerysyntax_file');
	}

	function postConnect() {
		$this->Lexer->addExitPattern('</file>', 'plugin_jquerysyntax_file');
	}
}
