<?php

namespace App\SRC\ADV;

use App\SRC\ADV\CabinetOffice;
use App\SRC\FW\Response;

class CustomParse
{   
    public function __construct()
    {
        $this->sub = [];   
    }
    public function toExcele($cmd, $url, $params, $response, $name) {
        $reader = new \XMLReader();
        $reader->XML($response);           
        $res = $this->custom_xml_parse($reader, ['type', 'display']);
        foreach ($this->sub as $key => $val) {
            $res['response']['table']['colnames'][$key] = [
                'name' => $res['response']['table']['colnames'][$key],
                'type' => $val['type'], 
                'display' => $val['display']
            ];
        }
        $office = new CabinetOffice($res['response']['table']);
        $office->excelExport();
        $office->toBrowser($name);
    }

    public function custom_xml_parse($XML, $atrs) {    
        $tree = null;     
        while( $XML->read() ) {
            switch ($XML->nodeType) {
                case $XML::END_ELEMENT: 
                    return $tree;
                case $XML::ELEMENT:
                    $node = $XML->isEmptyElement ? '' : $this->custom_xml_parse($XML, $atrs);
                    foreach($atrs as $val) {
                        if ($XML->getAttribute($val)) {
                            if (!isset($this->sub[$XML->name])) {
                                $this->sub[$XML->name] = ['name' => $node];
                            }
                            $this->sub[$XML->name] = array_merge($this->sub[$XML->name], [$val => $XML->getAttribute($val)]);
                        }
                    }                           
                    if ( $XML->name == "colvalues" ) {
                        if ( $node != '' ) {
                            $tree[$XML->name][] = $node; 
                        }
                    } else if ( is_array($tree) && in_array($XML->name, array_keys($tree)) ) {
                        if ( @!is_array($tree[$XML->name][0]) ) {
                            $TempTree = $tree[$XML->name];
                            $tree[$XML->name] = array();
                            $tree[$XML->name][0] = $TempTree;
                        }	
                        
                        if ( $XML->name == 'table' ) {
                            $node['colcount'] = $XML->getAttribute("col");
                            $node['rowcount'] = $XML->getAttribute("row");
                            $node['name'] = $XML->getAttribute("name");
                        }
                         
                            $tree[$XML->name][] = $node;
                        } else {
                            $tree[$XML->name] = $node;
                                    
                            if ( $XML->name == "table" ) {
                                $ColCount = $XML->getAttribute("col");
                                $RowCount = $XML->getAttribute("row");
                                $tree[$XML->name]['colcount'] = $ColCount;
                                $tree[$XML->name]['rowcount'] = $RowCount;
                                $tree[$XML->name]['name'] = $XML->getAttribute("name");
                            }
                        }
                        break;
                    case $XML::TEXT:
                    case $XML::CDATA:
                        $tree .= preg_replace('/<\!\[CDATA\[(.*?)\]\]>/is', '$1', $XML->value);
                }
            }
        return $tree;
    }
}