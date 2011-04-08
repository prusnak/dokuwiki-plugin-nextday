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
        $this->Lexer->addSpecialPattern('~~NEXTDAY:[^~]*~~', $mode, 'plugin_nextday');
    }

    function handle($match, $state, $pos, &$handler) {
        $match = substr($match,10,-2);
        $day = NULL;
        if (strlen($match) == 3 && in_array($match, array('mon','tue','wed','thu','fri','sat','sun'))) {
            $day = strtotime('next ' . $match, strtotime('yesterday'));
        }
        if (strlen($match) == 4 && in_array(substr($match,0,3), array('mon','tue','wed','thu','fri','sat','sun'))) {
            $idx = (int)$match[3];
            // TODO: find this day :)
        }
        return $day ? strftime('%d %B %Y', $day) : '';
    }

    function render($mode, &$renderer, $data) {
        $renderer->doc .= $data;
        return true;
    }

}

?>
