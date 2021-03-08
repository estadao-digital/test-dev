<?php

namespace Render\Front\Extensions
{
    class StringEx
    {
        public function toLower($value) { return stringEx($value)->toLower(); }
        public function toUpper($value) { return stringEx($value)->toUpper(); }
        public function toSlug($value, $delimiter = "-") { return stringEx($value)->toSlug($delimiter); }
        public function toAscii($value) { return stringEx($value)->toAscii(); }
        public function append($value, $append) { return stringEx($value)->append($append); }
        public function contains($value, $contains = null) { return stringEx($value)->contains($contains); }
        public function getOnlyLetters($value) { return stringEx($value)->getOnlyLetters(); }
        public function getOnlyNumbers($value) { return stringEx($value)->getOnlyNumbers(); }
        public function trim($value, $extraCharList = "") { return stringEx($value)->trim($extraCharList); }
        public function startsWith($value, $startsWith = "") { return stringEx($value)->startsWith($startsWith); }
        public function endsWith($value, $endsWith = "") { return stringEx($value)->startsWith($endsWith); }
        public function length($value) { return stringEx($value)->count; }
        public function split($value, $search = ",") { return stringEx($value)->split($search); }
    }
}
