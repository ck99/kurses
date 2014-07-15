<?php
/**
 * NcursesOutputFormatter.php
 * @author ciaran
 * @date 15/07/14 08:55
 *
 */

namespace Kurses\Formatter;


use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyleInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyleStack;

class NcursesOutputFormatter implements OutputFormatterInterface
{
    private $decorated = false;
    private $styles = [];
    private $styleStack;
    private $window;

    function __construct($decorated = false)
    {
        $this->decorated = $decorated;
        $this->styleStack = new OutputFormatterStyleStack();
        $this->setStyle('1', new NcursesFormatterStyle(1));
        $this->setStyle('2', new NcursesFormatterStyle(2));
    }

    public function setWindow($window)
    {
        $this->window = $window;
    }

    /**
     * Sets the decorated flag.
     *
     * @param bool $decorated Whether to decorate the messages or not
     *
     * @api
     */
    public function setDecorated($decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * Gets the decorated flag.
     *
     * @return bool    true if the output will decorate messages, false otherwise
     *
     * @api
     */
    public function isDecorated()
    {
        return (bool) $this->decorated;
    }

    /**
     * Sets a new style.
     *
     * @param string $name The style name
     * @param OutputFormatterStyleInterface $style The style instance
     *
     * @api
     */
    public function setStyle($name, OutputFormatterStyleInterface $style)
    {
        $this->styles[strtolower($name)] = $style;
    }

    /**
     * Checks if output formatter has style with specified name.
     *
     * @param string $name
     *
     * @return bool
     *
     * @api
     */
    public function hasStyle($name)
    {
        return isset($this->styles[strtolower($name)]);
    }

    /**
     * Gets style options from style with specified name.
     *
     * @param string $name
     *
     * @return OutputFormatterStyleInterface
     *
     * @throws \InvalidArgumentException When style isn't defined
     *
     * @api
     */
    public function getStyle($name)
    {
        if (!$this->hasStyle($name)) {
            throw new \InvalidArgumentException(sprintf('Undefined style: %s', $name));
        }

        return $this->styles[strtolower($name)];
    }

    public function writeFormattedLine($window, $row, $col, $text)
    {
        ncurses_mvwaddstr($window, $row, $col, $text);
    }

    /**
     * Formats a message according to the given styles.
     *
     * @param string $message The message to style
     *
     * @return string The styled message
     *
     * @api
     */
    public function format($message)
    {
        $offset = 0;
        $output = '';
        $tagRegex = '[a-z][a-z0-9_=;-]*';
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#isx", $message, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $i => $match) {
            $pos = $match[1];
            $text = $match[0];

            // add the text up to the next tag
            $this->applyCurrentStyle(substr($message, $offset, $pos - $offset));
            $offset = $pos + strlen($text);

            // opening tag?
            if ($open = '/' != $text[1]) {
                $tag = $matches[1][$i][0];
            } else {
                $tag = isset($matches[3][$i][0]) ? $matches[3][$i][0] : '';
            }

            if (!$open && !$tag) {
                // </>
                $this->styleStack->pop();
            } elseif ($pos && '\\' == $message[$pos - 1]) {
                // escaped tag
                $this->applyCurrentStyle($text);
            } elseif (false === $style = $this->createStyleFromString(strtolower($tag))) {
                $this->applyCurrentStyle($text);
            } elseif ($open) {
                $this->styleStack->push($style);
            } else {
                $this->styleStack->pop($style);
            }
        }

        $this->applyCurrentStyle(substr($message, $offset));

        return str_replace('\\<', '<', $output);
    }

    /**
     * @return OutputFormatterStyleStack
     */
    public function getStyleStack()
    {
        return $this->styleStack;
    }

    /**
     * Tries to create new style instance from string.
     *
     * @param string $string
     *
     * @return bool    false if string is not format string
     */
    private function createStyleFromString($string)
    {
        return false;
    }

    /**
     * Applies current style from stack to text, if must be applied.
     *
     * @param string $text Input text
     *
     * @return string Styled text
     */
    private function applyCurrentStyle($text)
    {
        return $this->isDecorated() && strlen($text) > 0 ? $this->styleStack->getCurrent()->apply($text) : $text;
    }


} 