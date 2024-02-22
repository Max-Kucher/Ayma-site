<?php

namespace App\Contracts\Response;

use Illuminate\Http\Response;

class XmlResponseStrategy implements ResponseStrategy
{

    private function arrayToXml($data, \SimpleXMLElement &$xml, $parentKeyName = null)
    {
        foreach ($data as $key => $value) {
            $elementName = is_numeric($key) ? 'item' : $key;

            if (is_array($value)) {
                if (!is_numeric($key) && $key !== $parentKeyName) {
                    $subnode = $xml->addChild($key);
                    $this->arrayToXml($value, $subnode, $key);
                } else {
                    $subnode = $xml->addChild('items');
                    $this->arrayToXml($value, $subnode, $elementName);
                }
            } else {
                $xml->addChild($elementName, htmlspecialchars($value));
            }
        }
    }

    public function render($data): Response
    {
        $xml = new \SimpleXMLElement('<root/>');
        $this->arrayToXml($data, $xml);
        return response($xml->asXML(), 200)->header('Content-Type', 'application/xml');
    }
}
