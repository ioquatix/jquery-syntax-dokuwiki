<?php

//	This file is part of the "jQuery.Syntax" project, and is distributed under the MIT License.
//	See <jquery.syntax.js> for licensing details.
//	Copyright (c) 2011 Samuel G. D. Williams. <http://www.oriontransfer.co.nz>

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once DOKU_PLUGIN.'syntax.php';

class syntax_plugin_jquerysyntax_code extends DokuWiki_Syntax_Plugin {
	var $syntax = "";

	function getInfo() {
		return array(
			'author' => 'Samuel Williams',
			'email'  => 'samuel.williams@oriontransfer.co.nz',
			'date'   => '2011-05-08',
			'name'   => 'jQuery.Syntax',
			'desc'   => "Extreme Client-side Syntax Highlighting. Replaces DokuWiki's <code> handler.",
			'url'    => 'http://www.oriontransfer.co.nz/software/jquery-syntax',
		);
	}

	function getType() {
		return 'protected';
	}

	function getPType() {
		return 'block';
	}

	// must return a number lower than returned by native 'code' mode (200)
	function getSort() {
		return 100;
	}

	// Connect pattern to lexer
	function connectTo($mode) {       
		$this->Lexer->addEntryPattern('<code(?=[^\r\n]*?>.*?</code>)', $mode, 'plugin_jquerysyntax_code');
	}

	function postConnect() {
		$this->Lexer->addExitPattern('</code>', 'plugin_jquerysyntax_code');
	}

	// Process DokuWiki Source
	function handle($match, $state, $pos, &$handler) {
		switch ($state) {
			case DOKU_LEXER_ENTER:
			$this->syntax = substr($match, 1);
			return false;

			case DOKU_LEXER_UNMATCHED:
			// will include everything from <code ... to ... </code >
			// e.g. ... [lang] [|title] > [content]
			list($attr, $content) = preg_split('/>/u',$match,2);
			list($lang, $title) = preg_split('/\|/u',$attr,2);

			return array($this->syntax, trim($lang), trim($title), $content);
		}       
		return false;
	}

	// Create output HTML
	function render($mode, &$renderer, $data) {
		if($mode == 'xhtml') {
			if (count($data) == 4) {
				list($syntax, $lang, $title, $content) = $data;

				if ($title)
					$renderer->doc .= "<div class='$syntax'><p>".$renderer->_xmlEntities($title)."</p>";

				if ($syntax == 'code') 
					$renderer->doc .= "<pre class=\"syntax brush-$lang\">".$renderer->_xmlEntities($content)."</pre>";
				else 
					$renderer->file($content);

				if ($title)
					$renderer->doc .= "</div>";
			}

			return true;
		}

		return false;
	}
}
