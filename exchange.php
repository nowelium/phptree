<?php

interface IExchange {
    public function visit(IMetaData $meta);
    public function visitPHPScriptMeta(PHPScriptMetaData $meta);
    public function visitInterfaceMeta(InterfaceMetaData $meta);
    public function visitClassMeta(ClassMetaData $meta);
    public function visitMethodMeta(MethodMetaData $meta);
    public function visitAttributeMeta(AttributeMetaData $meta);
    public function visitParameterMeta(ParameterMetaData $meta);
    public function visitTypeMeta(TypeMetaData $meta);
    public function visitAttributeValueMeta(AttributeValueMetaData $meta);
    public function visitInterfaceTokenMeta(InterfaceTokenMetaData $meta);
    public function visitClassTokenMeta(ClassTokenMetaData $meta);
    public function visitMethodTokenMeta(MethodTokenMetaData $meta);
    public function visitVariableTokenMeta(VariableTokenMetaData $meta);
    public function visitIntegerAttributeMeta(IntegerAttributeMetaData $meta);
    public function visitStringAttributeMeta(StringAttributeMetaData $meta);
    public function visitBooleanAttributeMeta(BooleanAttributeMetaData $meta);
    public function visitRealAttributeMeta(RealAttributeMetaData $meta);
    public function visitArrayAttributeMeta(ArrayAttributeMetaData $meta);
    public function visitArrayElementMeta(ArrayElementMetaData $meta);
    public function visitInterfaceListMeta(InterfaceMetaDataList $meta);
    public function visitClassListMeta(ClassMetaDataList $meta);
    public function visitInterfaceTokenListMeta(InterfaceTokenMetaDataList $meta);
    public function visitMemberListMeta(MemberMetaDataList $meta);
    public function visitArrayElementListMeta(ArrayElementMetaDataList $meta);
    public function visitParameterListMeta(ParameterMetaDataList $meta);
}

class DefaultBuffer {
    private $buf = '';
    public function write($str){
        $this->buf .= (string) $str;
    }
    public function writeln($str){
        $this->buf .= (string) $str;
        $this->buf .= PHP_EOL;
    }
    public function __toString(){
        return $this->buf;
    }
}

class DebugExchange implements IExchange {
    public function visit(IMetaData $meta){
        throw new Exception('Unsupported type: ' . get_class($meta));
    }
    public function visitPHPScriptMeta(PHPScriptMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getInterfaceList()->toJSValue($this));
        $buf->writeln($meta->getClassList()->toJSValue($this));
        return $buf;
    }
    public function visitInterfaceMeta(InterfaceMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getInterfaceList()->toJSValue($this));
        $buf->writeln($meta->getMemberList()->toJSValue($this));
        return $buf;
    }
    public function visitClassMeta(ClassMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getInterfaceList()->toJSValue($this));
        $buf->writeln($meta->getMemberList()->toJSValue($this));
        return $buf;
    }
    public function visitMethodMeta(MethodMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getParameterList()->toJSValue($this));
        return $buf;
    }
    public function visitAttributeMeta(AttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getAttribute()->toJSValue($this));
        return $buf;
    }
    public function visitParameterMeta(ParameterMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getType()->toJSValue($this));
        $buf->writeln($meta->getToken()->toJSValue($this));
        return $buf;
    }
    public function visitTypeMeta(TypeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        return $buf;
    }
    public function visitAttributeValueMeta(AttributeValueMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getAttribute()->toJSValue($this));
        return $buf;
    }
    public function visitNopAttributeValueMeta(NopAttributeValueMetaData $meta){
        return '';
    }
    public function visitInterfaceTokenMeta(InterfaceTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue()  . ']');
        return $buf;
    }
    public function visitClassTokenMeta(ClassTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitMethodTokenMeta(MethodTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitVariableTokenMeta(VariableTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitIntegerAttributeMeta(IntegerAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitStringAttributeMeta(StringAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitBooleanAttributeMeta(BooleanAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitRealAttributeMeta(RealAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitArrayAttributeMeta(ArrayAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getElementList()->toJSValue($this));
        return $buf;
    }
    public function visitArrayElementMeta(ArrayElementMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        return $buf;
    }
    public function visitArrayHashElementMeta(ArrayHashElementMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getKeyToken()->toJSValue($this));
        $buf->writeln($meta->getValueToken()->toJSValue($this));
        return $buf;
    }
    public function visitInterfaceListMeta(InterfaceMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $interface){
            $buf->writeln($interface->toJSValue($this));
        }
        return $buf;
    }
    public function visitClassListMeta(ClassMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $class){
            $buf->writeln($class->toJSValue($this));
        }
        return $buf;
    }
    public function visitInterfaceTokenListMeta(InterfaceTokenMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $interface){
            $buf->writeln($interface->toJSValue($this));
        }
        return $buf;
    }
    public function visitMemberListMeta(MemberMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $member){
            $buf->writeln($member->toJSValue($this));
        }
        return $buf;
    }
    public function visitArrayElementListMeta(ArrayElementMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $arrayElement){
            $buf->writeln($arrayElement->toJSValue($this));
        }
        return $buf;
    }
    public function visitParameterListMeta(ParameterMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $parameter){
            $buf->writeln($parameter->toJSValue($this));
        }
        return $buf;
    }
}

class JSExchange implements IExchange {
    public function visit(IMetaData $meta){
        throw new Exception('Unsupported type: ' . get_class($meta));
    }
    public function visitPHPScriptMeta(PHPScriptMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getInterfaceList()->toJSValue($this));
        $buf->writeln($meta->getClassList()->toJSValue($this));
        return $buf;
    }
    public function visitInterfaceMeta(InterfaceMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getInterfaceList()->toJSValue($this));
        $buf->writeln($meta->getMemberList()->toJSValue($this));
        return $buf;
    }
    public function visitClassMeta(ClassMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getInterfaceList()->toJSValue($this));
        $buf->writeln($meta->getMemberList()->toJSValue($this));
        return $buf;
    }
    public function visitMethodMeta(MethodMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getParameterList()->toJSValue($this));
        return $buf;
    }
    public function visitAttributeMeta(AttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln($meta->getToken()->toJSValue($this));
        $buf->writeln($meta->getAttribute()->toJSValue($this));
        return $buf;
    }
    public function visitParameterMeta(ParameterMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getType()->toJSValue($this));
        $buf->writeln($meta->getToken()->toJSValue($this));
        return $buf;
    }
    public function visitTypeMeta(TypeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        return $buf;
    }
    public function visitAttributeValueMeta(AttributeValueMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getAttribute()->toJSValue($this));
        return $buf;
    }
    public function visitNopAttributeValueMeta(NopAttributeValueMetaData $meta){
        return '';
    }
    public function visitInterfaceTokenMeta(InterfaceTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue()  . ']');
        return $buf;
    }
    public function visitClassTokenMeta(ClassTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitMethodTokenMeta(MethodTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitVariableTokenMeta(VariableTokenMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitIntegerAttributeMeta(IntegerAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitStringAttributeMeta(StringAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitBooleanAttributeMeta(BooleanAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitRealAttributeMeta(RealAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ': ' . $meta->getValue() . ']');
        return $buf;
    }
    public function visitArrayAttributeMeta(ArrayAttributeMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getElementList()->toJSValue($this));
        return $buf;
    }
    public function visitArrayElementMeta(ArrayElementMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getToken()->toJSValue($this));
        return $buf;
    }
    public function visitArrayHashElementMeta(ArrayHashElementMetaData $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $buf->writeln($meta->getKeyToken()->toJSValue($this));
        $buf->writeln($meta->getValueToken()->toJSValue($this));
        return $buf;
    }
    public function visitInterfaceListMeta(InterfaceMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $interface){
            $buf->writeln($interface->toJSValue($this));
        }
        return $buf;
    }
    public function visitClassListMeta(ClassMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $class){
            $buf->writeln($class->toJSValue($this));
        }
        return $buf;
    }
    public function visitInterfaceTokenListMeta(InterfaceTokenMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $interface){
            $buf->writeln($interface->toJSValue($this));
        }
        return $buf;
    }
    public function visitMemberListMeta(MemberMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $member){
            $buf->writeln($member->toJSValue($this));
        }
        return $buf;
    }
    public function visitArrayElementListMeta(ArrayElementMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $arrayElement){
            $buf->writeln($arrayElement->toJSValue($this));
        }
        return $buf;
    }
    public function visitParameterListMeta(ParameterMetaDataList $meta){
        $buf = new DefaultBuffer;
        $buf->writeln('[' . $meta->getNodeName() . ']');
        $list = $meta->getList();
        foreach($list as $parameter){
            $buf->writeln($parameter->toJSValue($this));
        }
        return $buf;
    }
}
