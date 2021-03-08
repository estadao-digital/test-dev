<?php

class Regex
{
    protected $seed;

    protected $pattern   = array();
    protected $prefixes  = array();
    protected $suffixes  = array();
    protected $modifiers = array();

    protected $constructRegex = null;

    public function __construct($regex = null)
    {
        $regex = stringEx($regex)->toString();
        if (!stringEx($regex)->isEmpty())
            $this->constructRegex = $regex;
    }

    public function __toString()  { return $this->compile(); }
    public function toString()    { return $this->compile(); }
    public function getCompiled() { return $this->compile(); }
    public function toRegex()     { return $this->compile(); }
    public function getPattern()  { return $this->compile(); }

    public function addSeed($seed) { return $this->setSeed($seed); }
    public function setSeed($seed) { $this->seed = $seed; return $this; }
    public function removeSeed()   { $this->seed = null; return $this; }
    public function getSeed()      { return $this->seed; }

    protected function compile()
    {
        if ($this->constructRegex != null)
            return $this->constructRegex;
        if (strlen(trim($this->seed)))
            return $this->seed;

        $pattern   = implode('', $this->pattern);
        $prefixes  = implode('', $this->prefixes);
        $suffixes  = implode('', $this->suffixes);
        $modifiers = implode('', $this->modifiers);
        return sprintf('/%s%s%s/%s', $prefixes, $pattern, $suffixes, $modifiers);
    }

    public function clear()
    {
        $this->seed      = false;
        $this->pattern   = array();
        $this->prefixes  = array();
        $this->suffixes  = array();
        $this->modifiers = array();
        return $this;
    }

    public function add($value, $format = '(%s)') { array_push($this->pattern, sprintf($format, $this->sanitize($value))); return $this; }
    public function raw($value, $format = '%s')   { array_push($this->pattern, sprintf($format, $value)); return $this; }

    public function length($min = null, $max = null)
    {
        $lastSegmentKey = $this->getLastSegmentKey();
        if (!is_null($min) && !is_null($max) && $max > $min)
            $lengthPattern = sprintf('{%d,%d}', (int) $min, (int) $max);
        elseif (!is_null($min) && !$max)
            $lengthPattern = sprintf('{%d}', (int) $min);
        else
            $lengthPattern = '{1}';
        return $this->replaceQuantifierByKey($lastSegmentKey, $lengthPattern);
    }

    public function getSegment($position = 1)
    {
        $position = ($position > 0) ? --$position : 0;
        if (array_key_exists($position, $this->pattern))
            return $this->pattern[$position];
        return false;
    }

    public function removeSegment($position = 1)
    {
        if (array_key_exists($position, $this->pattern))
            unset($this->pattern[$position]);
        return $this;
    }

    public function getSegments()
    { return $this->pattern; }

    public function getLastSegmentKey()
    {
        if (count($this->pattern)) {
            $patternKeys = array_keys($this->pattern);
            return array_shift($patternKeys);
        }
        return false;
    }

    protected function replaceQuantifierByKey($key, $replacement = '')
    {
        $subject = $this->pattern[$key];
        if (strripos($subject, ')') !== false)
        {
            $subject             = rtrim($subject, ')');
            $subject             = $this->removeQuantifier($subject);
            $this->pattern[$key] = sprintf('%s%s)', $subject, $replacement);
        }
        else
        {
            $subject             = $this->removeQuantifier($subject);
            $this->pattern[$key] = sprintf('%s%s', $subject, $replacement);
        }
        return $this;
    }

    protected function removeQuantifier($pattern)
    {
        if (strripos($pattern, '+') !== false && strripos($pattern, '\+') === false)
            return rtrim($pattern, '+');
        if (strripos($pattern, '*') !== false && strripos($pattern, '\*') === false)
            return rtrim($pattern, '*');
        if (strripos($pattern, '?') !== false && strripos($pattern, '\?') === false)
            return rtrim($pattern, '?');
        return $pattern;
    }

    public function addModifier($modifier)
    {
        if (!in_array($modifier, $this->modifiers))
            array_push($this->modifiers, trim($modifier));
        return $this;
    }

    public function removeModifier($modifier)
    {
        if (in_array($modifier, $this->modifiers))
            unset($this->modifiers[$modifier]);
        return $this;
    }

    public function addPrefix($prefix)
    {
        if (!in_array($prefix, $this->prefixes))
            array_push($this->prefixes, trim($prefix));
        return $this;
    }

    public function addSuffix($suffix)
    {
        if (!in_array($suffix, $this->suffixes))
            array_push($this->suffixes, trim($suffix));
        return $this;
    }

    // MODIFIERS
    public function startOfLine()   { $this->constructRegex = null; return $this->addPrefix('^'); }
    public function endOfLine()     { $this->constructRegex = null; return $this->addSuffix('$'); }
    public function ignoreCase()    { $this->constructRegex = null; return $this->addModifier('i'); }
    public function inAnyCase()     { $this->constructRegex = null; return $this->ignoreCase(); }
    public function oneLine()       { $this->constructRegex = null; return $this->removeModifier('m'); }
    public function searchOneLine() { $this->constructRegex = null; return $this->oneLine(); }
    public function multiline()     { $this->constructRegex = null; return $this->addModifier('m'); }
    public function matchNewLine()  { $this->constructRegex = null; return $this->addModifier('s'); }
    public function dotAll()        { $this->constructRegex = null; return $this->matchNewLine(); }

    // LANGUAGE
    public function find($value)        { $this->constructRegex = null; return $this->then($value); }
    public function then($value)        { $this->constructRegex = null; return $this->add($value); }
    public function maybe($value)       { $this->constructRegex = null; return $this->add($value, '(%s)?'); }
    public function either()            { $this->constructRegex = null; return $this->raw(implode('|', func_get_args()), '(%s)'); }
    public function any($value)         { $this->constructRegex = null; return $this->add($value, '([%s])'); }
    public function anyOf($value)       { $this->constructRegex = null; return $this->any($value); }
    public function anything()          { $this->constructRegex = null; return $this->raw('(.*)'); }
    public function anythingBut($value) { $this->constructRegex = null; return $this->add($value, '([^%s]*)'); }
    public function br()                { $this->constructRegex = null; return $this->raw('(\\n|\\r\\n)'); }
    public function tab()               { $this->constructRegex = null; return $this->raw('(\\t)'); }
    public function word()              { $this->constructRegex = null; return $this->raw('(\\w+)'); }
    public function lineBreak()         { $this->constructRegex = null; return $this->br();  }

    public function letters($min = null, $max = null)
    {
        $this->constructRegex = null;
        if (!is_null($min) && !is_null($max))
            return $this->raw(sprintf('([a-zA-Z]{%d,%d})', $min, $max));
        elseif (!is_null($min) && is_null($max))
            return $this->raw(sprintf('([a-zA-Z]{%d})', $min));
        else
            return $this->raw('([a-zA-Z]+)');
    }

    public function digits($min = null, $max = null)
    {
        $this->constructRegex = null;
        if (!is_null($min) && !is_null($max))
            return $this->raw(sprintf('(\\d{%d,%d})', $min, $max));
        elseif (!is_null($min) && is_null($max))
            return $this->raw(sprintf('(\\d{%d})', $min));
        else
            return $this->raw('(\\d+)');
    }

    public function orTry($value = '')
    {
        $this->constructRegex = null;
        if (empty($value))
            return $this->addPrefix('(')->addSuffix(')')->raw(')|(');
        return $this->addPrefix('(')->addSuffix(')')->raw($value, ')|((%s)');
    }

    public function range()
    {
        $this->constructRegex = null;

        $row    = 0;
        $args   = func_get_args();
        $ranges = array();
        foreach ($args as $segment) {
            $row++;
            if ($row % 2) array_push($ranges, sprintf('%s-%s', $args[$row - 1], $args[$row]));
        }
        return $this->raw(implode('', $ranges), '([%s])');
    }

    // FUNCTIONS
    public function match($subject, $seed = '')
    {
        $subject = stringEx($subject)->toString();
        if (!empty($seed))
            $this->addSeed($seed);
        return preg_match($this->compile(), $subject);
    }

    public function replace($subject, $replacement = "", $seed = '')
    {
        $subject = stringEx($subject)->toString();
        $replacement = stringEx($replacement)->toString();

        if (!empty($seed))
        { $this->addSeed($seed); }
        return preg_replace($this->compile(), $replacement, $subject);
    }

    public function sanitize($value)
    { return preg_quote($value, '/'); }
}