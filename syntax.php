<?php
/**
 * Nextday Plugin: Display the date of the closest $WEEKDAY
 *
 * @license    MIT (http://www.opensource.org/licenses/mit-license.php)
 * @author     Pavol Rusnak <stick@gk2.sk>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_nextday extends DokuWiki_Syntax_Plugin {

    function getType() { return 'substition'; }

    function getPType() { return 'normal'; }

    function getSort() { return 155; }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~NEXTDAY:[^~]*~~',$mode,'plugin_nextday');
    }

    function handle($match, $state, $pos, &$handler) {
        $day = strtotime('next friday', strtotime('yesterday'));
        return strftime('%d %B %Y', $day);
    }

    function render($mode, &$renderer, $data) {
        $renderer->doc .= $data;
        return true;
    }

}

?>
