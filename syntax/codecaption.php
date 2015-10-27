<?php
/**
 * Plugin imagereference
 *
 * Syntax: <coderef linkname> - creates a code ("listing") link to a code block
 *         <codecaption linkname <orientation> | Table caption> Table</codecaption>
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Gerrit Uitslag <klapinklapin@gmail.com>
 */

if(!defined('DOKU_INC')) die();

/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_imagereference_codecaption extends syntax_plugin_imagereference_imgcaption {

    /**
     * @return string Syntax type
     */
    public function getType() {
        return 'formatting';
    }
    /**
     * @return string Paragraph type
     */
    public function getPType() {
        return 'block';
    }
    /**
     * @return int Sort order
     */
    public function getSort() {
        return 196;
    }

    /**
     * Specify modes allowed in the imgcaption/tabcaption/codecaption
     * Using getAllowedTypes() includes too many modes.
     *
     * @param string $mode Parser mode
     * @return bool true if $mode is accepted
     */
    public function accepts($mode) {
        $allowedsinglemodes = array(
            'code', //allowed content
            'plugin_diagram_main'    //plugins
        );
        if(in_array($mode, $allowedsinglemodes)) return true;

        return parent::accepts($mode);
    }

    /**
     * Connect lookup pattern to lexer.
     *
     * @param string $mode Parser mode
     */
    public function connectTo($mode) {
        $this->Lexer->addEntryPattern('<codecaption.*?>(?=.*?</codecaption>)', $mode, 'plugin_imagereference_codecaption');
    }

    public function postConnect() {
        $this->Lexer->addExitPattern('</codecaption>', 'plugin_imagereference_codecaption');
    }

    /**
     * @var string $captionStart opening tag of caption, image/table/code dependent
     * @var string $captionEnd closing tag of caption, image/table/code dependent
     */
    protected $captionStart = '<div id="%s" class="codecaptionbox%s"><div class="codecaption%s">';
    protected $captionEnd   = '</div></div>';
}

