<?php

interface IMetaData {
    public function getNodeName();
    public function toJSValue(IJSExchange $exchange);
}

class PHPScriptMetaData implements IMetaData {
    const NODE_NAME = 'AST_php_script';
    private $interfaceList;
    private $classList;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setInterfaceList(InterfaceMetaDataList $interfaceList){
        $this->interfaceList = $interfaceList;
    }
    public function setClassList(ClassMetaDataList $classList){
        $this->classList = $classList;
    }
    public function getInterfaceList(){
        return $this->interfaceList;
    }
    public function getClassList(){
        return $this->classList;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitPHPScriptMeta($this);
    }
}

class InterfaceMetaData implements IMetaData {
    const NODE_NAME = 'AST_interface_def';
    private $token;
    private $interfaceList;
    private $memberList;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setToken(InterfaceTokenMetaData $token){
        $this->token = $token;
    }
    public function setInterfaceMetaDataList(InterfaceTokenMetaDataList $interfaceList){
        $this->interfaceList = $interfaceList;
    }
    public function setMemberList(MemberMetaDataList $memberList){
        $this->memberList = $memberList;
    }
    public function getToken(){
        return $this->token;
    }
    public function getInterfaceList(){
        return $this->interfaceList;
    }
    public function getMemberList(){
        return $this->memberList;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitInterfaceMeta($this);
    }
}

class ClassMetaData implements IMetaData {
    const NODE_NAME = 'AST_class_def';
    private $token;
    private $interfaceList;
    private $memberList;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setToken(ClassTokenMetaData $token){
        $this->token = $token;
    }
    public function setInterfaceMetaDataList(InterfaceTokenMetaDataList $interfaceList){
        $this->interfaceList = $interfaceList;
    }
    public function setMemberList(MemberMetaDataList $memberList){
        $this->memberList = $memberList;
    }
    public function getToken(){
        return $this->token;
    }
    public function getInterfaceList(){
        return $this->interfaceList;
    }
    public function getMemberList(){
        return $this->memberList;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitClassMeta($this);
    }
}

class MethodMetaData implements IMetaData {
    const NODE_NAME = 'AST_method';
    private $token;
    private $parameterList;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setToken(MethodTokenMetaData $token){
        $this->token = $token;
    }
    public function setParameterMetaDataList(ParameterMetaDataList $parameterList){
        $this->parameterList = $parameterList;
    }
    public function getToken(){
        return $this->token;
    }
    public function getParameterList(){
        return $this->parameterList;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitMethodMeta($this);
    }
}

class AttributeMetaData implements IMetaData {
    const NODE_NAME = 'AST_attribute';
    private $token;
    private $attribute;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setToken(VariableTokenMetaData $token){
        $this->token = $token;
    }
    public function setAttributeValue(AttributeValueMetaData $attribute){
        $this->attribute = $attribute;
    }
    public function getToken(){
        return $this->token;
    }
    public function getAttribute(){
        return $this->attribute;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitAttributeMeta($this);
    }
}

class ParameterMetaData implements IMetaData {
    const NODE_NAME = 'AST_formal_parameter';
    private $typeMeta;
    private $token;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setType(TypeMetaData $typeMeta){
        $this->typeMeta = $typeMeta;
    }
    public function setToken(VariableTokenMetaData $token){
        $this->token = $token;
    }
    public function getType(){
        return $this->typeMeta;
    }
    public function getToken(){
        return $this->token;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitParameterMeta($this);
    }
}

class TypeMetaData implements IMetaData {
    const NODE_NAME = 'AST_type';
    private $token;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setToken(ClassTokenMetaData $token){
        $this->token = $token;
    }
    public function getToken(){
        return $this->token;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitTypeMeta($this);
    }
}

class AttributeValueMetaData implements IMetaData {
    private $attribute;
    public function __construct(IAttributeToken $attribute){
        $this->attribute = $attribute;
    }
    public function getNodeName(){
        return $this->attribute->getNodeName();
    }
    public function getAttribute(){
        return $this->attribute;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitAttributeValueMeta($this);
    }
}
class NopAttributeValueMetaData extends AttributeValueMetaData {
    /**
     * override
     */
    public function __construct(){
    }
    /**
     * override
     */
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitNopAttributeValueMeta($this);
    }
}

class InterfaceTokenMetaData implements IMetaData {
    const NODE_NAME = 'Token_interface_name';
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitInterfaceTokenMeta($this);
    }
}
class ClassTokenMetaData implements IMetaData {
    const NODE_NAME = 'Token_class_name';
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitClassTokenMeta($this);
    }
}
class MethodTokenMetaData implements IMetaData {
    const NODE_NAME = 'Token_method_name';
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitMethodTokenMeta($this);
    }
}
class VariableTokenMetaData implements IMetaData {
    const NODE_NAME = 'Token_variable_name';
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function setValue($value){
        $this->value = $value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitVariableTokenMeta($this);
    }
}

interface IAttributeToken extends IMetaData {
}
class IntegerAttributeMetaData implements IAttributeToken {
    const NODE_NAME = 'Token_int';
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitIntegerAttributeMeta($this);
    }
}
class StringAttributeMetaData implements IAttributeToken {
    const NODE_NAME = 'Token_string';
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitStringAttributeMeta($this);
    }
}
class BooleanAttributeMetaData implements IAttributeToken {
    const NODE_NAME = 'Token_bool';
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitBooleanAttributeMeta($this);
    }
}
class RealAttributeMetaData implements IAttributeToken {
    const NODE_NAME = 'Token_real';
    private $value;
    public function __construct($value){
        $this->value = $value;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getValue(){
        return $this->value;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitRealAttributeMeta($this);
    }
}
class ArrayAttributeMetaData implements IAttributeToken {
    const NODE_NAME = 'AST_array';
    private $elementList;
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function setElementList(ArrayElementMetaDataList $elementList){
        $this->elementList = $elementList;
    }
    public function getElementList(){
        return $this->elementList;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitArrayAttributeMeta($this);
    }
}
class ArrayElementMetaData implements IAttributeToken {
    const NODE_NAME = 'AST_array_elem';
    private $token;
    public function __construct(AttributeMetaData $token){
        $this->token = $token;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getToken(){
        return $this->token;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitArrayElementMeta($this);
    }
}
class ArrayHashElementMetaData implements IAttributeToken {
    const NODE_NAME = 'AST_array_elem';
    private $keyToken;
    private $valueToken;
    public function __construct(AttributeMetaData $keyToken, AttributeMetaData $valueToken){
        $this->keyToken = $keyToken;
        $this->valueToken = $valueToken;
    }
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function getKeyToken(){
        return $this->keyToken;
    }
    public function getValueToken(){
        return $this->valueToken;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitArrayHashElementMeta($this);
    }
}

interface IMetaDataList extends IMetaData {
    public function add(IMetaData $metaData);
    public function getList();
}
class InterfaceMetaDataList implements IMetaDataList {
    const NODE_NAME = 'AST_interface_def_list';
    private $metas = array();
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function add(IMetaData $meta){
        $this->metas []= $meta;
    }
    public function getList(){
        return $this->metas;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitInterfaceListMeta($this);
    }
}
class ClassMetaDataList implements IMetaDataList {
    const NODE_NAME = 'AST_class_def_list';
    private $metas = array();
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function add(IMetaData $meta){
        $this->metas []= $meta;
    }
    public function getList(){
        return $this->metas;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitClassListMeta($this);
    }
}
class InterfaceTokenMetaDataList implements IMetaDataList {
    const NODE_NAME = 'Token_interface_name_list';
    private $metas = array();
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function add(IMetaData $meta){
        $this->metas []= $meta;
    }
    public function getList(){
        return $this->metas;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitInterfaceTokenListMeta($this);
    }
}
class MemberMetaDataList implements IMetaDataList {
    const NODE_NAME = 'AST_member_list';
    private $metas = array();
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function add(IMetaData $meta){
        $this->metas []= $meta;
    }
    public function getList(){
        return $this->metas;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitMemberListMeta($this);
    }
}
class ArrayElementMetaDataList implements IMetaDataList {
    const NODE_NAME = 'AST_array_elem_list';
    private $metas = array();
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function add(IMetaData $meta){
        $this->metas []= $meta;
    }
    public function getList(){
        return $this->metas;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitArrayElementListMeta($this);
    }
}
class ParameterMetaDataList implements IMetaDataList {
    const NODE_NAME = 'AST_formal_parameter_list';
    private $metas = array();
    public function getNodeName(){
        return self::NODE_NAME;
    }
    public function add(IMetaData $meta){
        $this->metas []= $meta;
    }
    public function getList(){
        return $this->metas;
    }
    public function toJSValue(IJSExchange $exchange){
        return $exchange->visitParameterListMeta($this);
    }
}

