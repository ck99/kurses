<?php
/**
 * NcursesFormatterStyle.php
 * @author ciaran
 * @date 15/07/14 08:50
 *
 */

namespace Kurses\Formatter;

use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;

class NcursesFormatterStyle implements OutputFormatterStyleInterface
{
    protected $colPair;

    function __construct($colPair)
    {
        $this->colPair = $colPair;
    }

    /**
     * Sets style foreground color.
     *
     * @param string $color The color name
     *
     * @api
     */
    public function setForeground($color = null)
    {
        // TODO: Implement setForeground() method.
    }

    /**
     * Sets style background color.
     *
     * @param string $color The color name
     *
     * @api
     */
    public function setBackground($color = null)
    {
        // TODO: Implement setBackground() method.
    }

    /**
     * Sets some specific style option.
     *
     * @param string $option The option name
     *
     * @api
     */
    public function setOption($option)
    {
        // TODO: Implement setOption() method.
    }

    /**
     * Unsets some specific style option.
     *
     * @param string $option The option name
     */
    public function unsetOption($option)
    {
        // TODO: Implement unsetOption() method.
    }

    /**
     * Sets multiple style options at once.
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        // TODO: Implement setOptions() method.
    }

    /**
     * Applies the style to a given text.
     *
     * @param string $text The text to style
     *
     * @return string
     */
    public function apply($text)
    {

    }
}