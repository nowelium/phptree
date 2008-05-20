<?php

interface PHC {
    const PHC_NS = 'http://www.phpcompiler.org/phc-1.0';
    public function getXmlElement();
    public function asXML();
}

class PHCUtils {
    private static $acceptTokenNodes = array(
        IntegerAttributeMetaData::NODE_NAME,
        StringAttributeMetaData::NODE_NAME,
        BooleanAttributeMetaData::NODE_NAME,
        RealAttributeMetaData::NODE_NAME,
        ArrayAttributeMetaData::NODE_NAME
    );
    private function __construct(){
        // nop
    }
    private static function getTokenValue(SimpleXMLElement $element){
        return (string) $element->value;
    }
    private static function getInterfaceNameList(SimpleXMLElement $element){
        $list = new InterfaceTokenMetaDataList;
        foreach($element->Token_interface_name_list as $key => $names){
            if(strcasecmp($key, InterfaceTokenMetaDataList::NODE_NAME) !== 0){
                continue;
            }
            if(strcasecmp($key, InterfaceTokenMetaData::NODE_NAME) !== 0){
                continue;
            }
            $list->add(new InterfaceTokenMetaData(self::getTokenValue($name->Token_interface_name)));
        }
        return $list;
    }
    private static function getAttributeMeta(SimpleXMLElement $element){
        $token = new VariableTokenMetaData(self::getTokenValue($element->Token_variable_name));
        $attributeMeta = new AttributeMetaData;
        $attributeMeta->setToken($token);

        $tokenDef = null;
        $tokenMeta = null;
        $metaDataClass = null;
        $isArray = false;
        if(property_exists($element, StringAttributeMetaData::NODE_NAME)){
            $tokenDef = $element->Token_string;
            $metaDataClass = 'StringAttributeMetaData';
        }
        if(strcasecmp($element->getName(), StringAttributeMetaData::NODE_NAME) === 0){
            $tokenDef = $element;
            $metaDataClass = 'StringAttributeMetaData';
        }
        if(property_exists($element, IntegerAttributeMetaData::NODE_NAME)){
            $tokenDef = $element->Token_int;
            $metaDataClass = 'IntegerAttributeMetaData';
        }
        if(strcasecmp($element->getName(), IntegerAttributeMetaData::NODE_NAME) === 0){
            $tokenDef = $element;
            $metaDataClass = 'IntegerAttributeMetaData';
        }
        if(property_exists($element, BooleanAttributeMetaData::NODE_NAME)){
            $tokenDef = $element->Token_bool;
            $metaDataClass = 'BooleanAttributeMetaData';
        }
        if(strcasecmp($element->getName(), BooleanAttributeMetaData::NODE_NAME) === 0){
            $tokenDef = $element;
            $metaDataClass = 'BooleanAttributeMetaData';
        }
        if(property_exists($element, RealAttributeMetaData::NODE_NAME)){
            $tokenDef = $element->Token_real;
            $metaDataClass = 'RealAttributeMetaData';
        }
        if(strcasecmp($element->getName(), RealAttributeMetaData::NODE_NAME) === 0){
            $tokenDef = $element;
            $metaDataClass = 'RealAttributeMetaData';
        }
        if(property_exists($element, ArrayAttributeMetaData::NODE_NAME)){
            $tokenDef = $element->AST_array;
            $metaDataClass = 'ArrayAttributeMetaData';
            $isArray = true;
        }
        if(strcasecmp($element->getName(), ArrayAttributeMetaData::NODE_NAME) === 0){
            $tokenDef = $element;
            $metaDataClass = 'ArrayAttributeMetaData';
            $isArray = true;
        }
        if($metaDataClass === null){
            $attributeMeta->setAttributeValue(new NopAttributeValueMetaData);
            return $attributeMeta;
        }

        // TODO: metaDataクラスを探すまでが長い
        $tokenMeta = new $metaDataClass((string) $tokenDef->source_rep);

        if($isArray){
            $tokenMeta = new ArrayAttributeMetaData;
            $list = new ArrayElementMetaDataList;
            foreach($tokenDef->AST_array_elem_list as $elementList){
                $elements = $elementList->children();
                foreach($elements as $key => $e){
                    if(strcasecmp($key, ArrayElementMetaData::NODE_NAME) !== 0){
                        continue;
                    }
                    $children = (array) $e;
                    if(array_key_exists('AST_expr', $children)){
                        $meta = self::getAttributeMeta($e);
                        $meta->getToken()->setValue('value');
                        $list->add(new ArrayElementMetaData($meta));
                    } else {
                        if(3 === count($children)){
                            foreach($children as $k => $child){
                                if(!in_array($k, self::$acceptTokenNodes, true)){
                                    continue;
                                }
                                $keyToken = self::getAttributeMeta($child[0]);
                                $valueToken = self::getAttributeMeta($child[1]);
                                $keyToken->getToken()->setValue('key');
                                $valueToken->getToken()->setValue('value');
                                $list->add(new ArrayHashElementMetaData($keyToken, $valueToken));
                            }
                        } else {
                            $tokens = array();
                            foreach($children as $k => $child){
                                if(!in_array($k, self::$acceptTokenNodes, true)){
                                    continue;
                                }
                                $tokens [] = self::getAttributeMeta($child);
                            }
                            $tokens[0]->getToken()->setValue('key');
                            $tokens[1]->getToken()->setValue('value');
                            $list->add(new ArrayHashElementMetaData($tokens[0], $tokens[1]));
                        }
                    }
                }
            }
            $tokenMeta->setElementList($list);
        }
        if($tokenDef !== null && $tokenMeta !== null){
            $attributeMeta->setAttributeValue(new AttributeValueMetaData($tokenMeta));
        } else {
            $attributeMeta->setAttributeValue(new NopAttributeValueMetaData);
        }
        return $attributeMeta;
    }
    private static function getMemberList(SimpleXMLElement $element){
        $list = new MemberMetaDataList;
        foreach($element->AST_member_list as $memberList){
            $members = $memberList->children();
            foreach($members as $key => $member){
                if(strcasecmp($key, AttributeMetaData::NODE_NAME) === 0){
                    $list->add(self::getAttributeMeta($member));
                }
                if(strcasecmp($key, MethodMetaData::NODE_NAME) === 0){
                    $signature = $member->AST_signature;
                    $methodMeta = new MethodMetaData;
                    $methodMeta->setToken(new MethodTokenMetaData(self::getTokenValue($signature->Token_method_name)));
                    if(property_exists($signature, ParameterMetaDataList::NODE_NAME)){
                        $methodMeta->setParameterMetaDataList(self::getParameterList($signature));
                    }
                    $list->add($methodMeta);
                }
            }
        }
        return $list;
    }
    private static function getParameterList(SimpleXMLElement $element){
        $list = new ParameterMetaDataList;
        foreach($element->AST_formal_parameter_list as $key => $parameterList){
            if(strcasecmp($key, ParameterMetaDataList::NODE_NAME) !== 0){
                continue;
            }
            $parameters = $parameterList->children();
            foreach($parameters as $k => $parameterDef){
                if(strcasecmp($k, ParameterMetaData::NODE_NAME) !== 0){
                    continue;
                }
                $parameterMeta = new ParameterMetaData;
                $parameterMeta->setToken(new VariableTokenMetaData(self::getTokenValue($parameterDef->Token_variable_name)));
                if(strcasecmp($k, ParameterMetaData::NODE_NAME) === 0){
                    $astType = $parameterDef->AST_type;
                    $type = new TypeMetaData;
                    $type->setToken(new ClassTokenMetaData(self::getTokenValue($astType->Token_class_name)));
                    $parameterMeta->setType($type);
                }
                $list->add($parameterMeta);
            }
        }
        return $list;
    }
    public static function getInterfaceDefs(PHC $phc){
        $children = $phc->getXmlElement()->children(PHC::PHC_NS);
        $list = new InterfaceMetaDataList;
        foreach($children->AST_interface_def_list as $key => $listDefList){
            if(strcasecmp($key, InterfaceMetaDataList::NODE_NAME) !== 0){
                continue;
            }
            $children = $listDefList->children();
            foreach($children as $name => $interfaceDef){
                if(strcasecmp($name, InterfaceMetaData::NODE_NAME) !== 0){
                    continue;
                }
                $interfaceMeta = new InterfaceMetaData;
                $interfaceMeta->setToken(new InterfaceTokenMetaData(self::getTokenValue($interfaceDef->Token_interface_name)));
                $interfaceMeta->setInterfaceMetaDataList(self::getInterfaceNameList($interfaceDef));
                $interfaceMeta->setMemberList(self::getMemberList($interfaceDef));
                $list->add($interfaceMeta);
            }
        }
        return $list;
    }
    public static function getClassDefs(PHC $phc){
        $children = $phc->getXmlElement()->children(PHC::PHC_NS);
        $list = new ClassMetaDataList;
        foreach($children->AST_class_def_list as $key => $classDefList){
            if(strcasecmp($key, ClassMetaDataList::NODE_NAME) !== 0){
                continue;
            }
            $children = $classDefList->children();
            foreach($children as $name => $classDef){
                if(strcasecmp($name, ClassMetaData::NODE_NAME) !== 0){
                    continue;
                }
                $classMeta = new ClassMetaData;
                $classMeta->setToken(new ClassTokenMetaData(self::getTokenValue($classDef->Token_class_name)));
                $classMeta->setInterfaceMetaDataList(self::getInterfaceNameList($classDef));
                $classMeta->setMemberList(self::getMemberList($classDef));

                $list->add($classMeta);
            }
        }
        return $list;
    }
}

