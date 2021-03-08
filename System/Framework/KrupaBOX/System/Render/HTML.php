<?php

namespace Render
{

    use KrupaBOX\Internal\Library;

    class HTML extends \DOMDocument
    {
        public static function getFromString($stringValue, $reportErrors = false)
        {
            $stringValue = stringEx($stringValue)->toHtmlEntities();

            if ($reportErrors == false)
            {
                libxml_use_internal_errors(true);
                libxml_clear_errors();
            }

            $html = new HTML();
            $html->recover = true;
            $html->preserveWhiteSpace = true;
            $html->loadHTML($stringValue);
            return $html;
        }

        public static function getFromPath($path)
        {
            if (\File::exists($path))
            {
                $content = \File::getContents($path);
                return self::getFromString($content);
            }

            return null;
        }

        public function __construct()
        { parent::__construct("1.0", "UTF-8"); }

        public function saveInnerHTML(\DOMElement $element)
        {
            $document = $element->ownerDocument;
            $html = "";

            foreach ($element->childNodes as $node)
                $html .= $document->saveHTML($node);

            return $html;
        }

        public function saveHTML(\DomNode $domNode = null)
        {
            if ($domNode == null)
                return $this->saveHTML($this->getElementsByTagName("html")->item(0));
            else return parent::saveHTML($domNode);
        }

        public function saveIdentedHTML(\DomNode $domNode = null)
        {


            $content = self::saveHTML($domNode);
            if ($content == null) return null;
            $contentEntities = stringEx($content)->toHtmlEntities();

            \KrupaBOX\Internal\Library::load("Dindent");
            $indenter = new \Gajus\Dindent\Indenter();

            $identedContentEntities = stringEx($indenter->indent($contentEntities))->toString();
            $htmlUtf8 = \stringEx::fromHtmlEntities($identedContentEntities);

            return $htmlUtf8;
        }

        public function toArr(\DomNode $domNode = null)
        {
            if ($domNode == null)
                $domNode = $this->getElementsByTagName("html")->item(0);

            return Arr($this->_toArr($domNode));
        }

        public function _toArr($root)
        {
            $array = array();
            //list attributes
            if($root->hasAttributes()) {
                foreach($root->attributes as $attribute) {
                    $array['@attributes'][$attribute->name] = $attribute->value;
                }
            }
            //handle classic node
            if($root->nodeType == XML_ELEMENT_NODE) {
                $array['@type'] = $root->nodeName;
                if($root->hasChildNodes()) {
                    $children = $root->childNodes;
                    for($i = 0; $i < $children->length; $i++) {
                        $child = $this->_toArr( $children->item($i) );
                        //don't keep textnode with only spaces and newline
                        if(!empty($child)) {
                            $array['@childrens'][] = $child;
                        }
                    }
                }
                //handle text node
            } elseif($root->nodeType == XML_TEXT_NODE || $root->nodeType == XML_CDATA_SECTION_NODE) {
                $value = $root->nodeValue;
                if(!empty($value)) {
                    $array['@type'] = '@text';
                    $array['@content'] = $value;
                }
            }
            return $array;
        }

        public static function fromArr($arr)
        {
            $html = new HTML();
            $htmlElement = $html->createElement("html");

            if ($arr->containsKey("@type") && $arr["@type"] == html)
                if ($arr->containsKey("@attributes"))
                    foreach ($arr["@attributes"] as $attribute => $value)
                        $htmlElement->setAttribute($attribute, $value);

            $html->appendChild($htmlElement);

            if ($arr->containsKey("@childrens"))
                foreach ($arr["@childrens"] as $children)
                    self::_fromArr($children, $htmlElement, $html);

            return $html;
        }

        protected static function _fromArr($arr, $node, $html)
        {
            if ($arr->containsKey("@type"))
            {
                $element = null;

                if ($arr["@type"] == "@text")
                {
                    $element = $html->createTextNode($arr->containsKey("@content") ? $arr["@content"] : "");
                    $node->appendChild($element);
                }
                else
                {
                    $element = $html->createElement($arr["@type"]);

                    //if ($arr->containsKey("@type") && $arr["@type"] == html)
                        if ($arr->containsKey("@attributes"))
                            foreach ($arr["@attributes"] as $attribute => $value)
                                $element->setAttribute($attribute, $value);

                    $node->appendChild($element);
                }

                if ($arr->containsKey("@childrens") && $element != null)
                    foreach ($arr["@childrens"] as $children)
                        self::_fromArr($children, $element, $html);
            }
        }
    }
}