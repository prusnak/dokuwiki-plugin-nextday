<?php
/**
 * Nextday Plugin: Display the date of the closest $WEEKDAY
 *
 * @license    MIT (http://www.opensource.org/licenses/mit-license.php)
 * @author     Pavol Rusnak <stick@gk2.sk>
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) die();
require_once(DOKU_PLUGIN.'syntax.php');

class syntax_plugin_nextday extends DokuWiki_Syntax_Plugin {

    function getType() { return 'substition'; }

    function getPType() { return 'normal'; }

    function getSort() { return 155; }

    function connectTo($mode) {
        $this->Lexer->addSpecialPattern('~~NEXTDAY:[^~]*~~', $mode, 'plugin_nextday');
    }

    function handle($match, $state, $pos, Doku_Handler $handler) {
        $in = explode(' ', substr($match,10,-2));
        $day = NULL;
        if (count($in) == 1) {
            if (in_array($in[0], array('mon','tue','wed','thu','fri','sat','sun'))) {
                $day = strtotime('next ' . $in[0], strtotime('yesterday'));
            }
        } else if (count($in) == 2) {
            if (in_array($in[0], array('first','second','third','fourth','fifth','last')) &&
                in_array($in[1], array('mon','tue','wed','thu','fri','sat','sun'))) {
                $day_today = strtotime('today');
                $day_next = strtotime("${in[0]} ${in[1]} of next month");
                $day_this = strtotime("${in[0]} ${in[1]} of this month");
                $day = ($day_this < $day_today) ? $day_next : $day_this;
            }
        }
        return $day ? strftime('%d %B %Y', $day) : '';
    }

    function render($mode, Doku_Renderer $renderer, $data) {
        $renderer->doc .= $data;
        return true;
    }

}

?>
