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
        return 'substition'; //FIXME: Should find correct type to use in getType()
    }
    //FIXME: Not able to put DW syntax inside a button or a bubble

    function getSort(){
        return 150; //FIXME: Should find correct sort value to use in getSort()
    }

    /**
     * Connect lookup pattern to lexer
     */
    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('\[\^.*?\^\]\^\^.*?\^\^', $mode, 'plugin_popup');
    }
    // FIXME: Bracket syntax conflicts with link syntax

    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler) {
        // get button and bubble texts
        $data = explode('^]^^', substr($match, strlen('[^'), -2));
        return $data;
    }

    /**
     * Create output
     */
    function render($format, Doku_Renderer $renderer, $data) {
        if ($format == 'xhtml') {
            // create a button and a bubble
            $renderer->doc .= '<div class="popup" onclick="myFunction()">'.hsc($data[0]); //FIXME: Button is a div, meaning no inline
            $renderer->doc .= '<span class="popuptext" id="myPopup">'.hsc($data[1]).'</span>'; //FIXME: Bubble is still using id, so different buttons will call the same bubble
            $renderer->doc .= '</div>';
        }
        if ($format == 'metadata') {
            // when the format is "metadata" (abstract)
            if ($renderer->capture) $renderer->doc .= hsc($data[0]) . '(' . hsc($data[1]) . ')';
        }

    }
}
