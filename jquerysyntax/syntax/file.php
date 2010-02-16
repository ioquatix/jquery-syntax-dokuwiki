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

	function handle($match, $state, $pos, &$handler) {
		switch ($state) {
			case DOKU_LEXER_ENTER:
			$this->syntax = substr($match, 1);
			return false;

			case DOKU_LEXER_UNMATCHED:
			// will include everything from <file ... to ... </file >
			// e.g. ... [lang] [|title] > [content]
			list($attr, $content) = preg_split('/>/u',$match,2);
			list($lang, $title) = preg_split('/\|/u',$attr,2);

			if ($this->syntax == 'code') {
				$lang = trim($lang);
				if ($lang == 'html') $lang = 'html4strict';
				if (!$lang) $lang = NULL;
			} else {
				$lang = NULL;
			}

			return array($this->syntax, $lang, trim($title), $content);
		}      
		return false;
	}
}
