<?php
/**
 * DokuWiki Popup Plugin
 * [button]^^bubble content^^
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     GHSRobert <robertus0617@gmail.com>
 *
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

class syntax_plugin_popup extends DokuWiki_Syntax_Plugin {

    function getType(){
        return 'substition'; //?
    }

    function getSort(){
        return 150; //?
    }

    /**
     * Connect lookup pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\[.*?\]\^\^.*?\^\^', $mode, 'plugin_popup');
    }

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        // get ruby base and text component of a ruby annotation
        $data = explode(']^^', substr($match, strlen('['), -2));
        return $data;
    }

    /**
     * Create output
     */
    function render($format, Doku_Renderer $renderer, $data) {
        if ($format == 'xhtml') {
            // create a button and a bubble
            $renderer->doc .= '<div class="popup" onclick="myFunction()">'.hsc($data[0]);
            $renderer->doc .= '<span class="popuptext" id="myPopup">'.hsc($data[1]).'</span>';
            $renderer->doc .= '</div>';
        }
        if ($format == 'metadata') {
            // when the format is "metadata" (abstract)
            if ($renderer->capture) $renderer->doc .= hsc($data[0]) . '(' . hsc($data[1]) . ')';
        }

    }
}
