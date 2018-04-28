<?php
/**
 * File for class ColissimoAFStructBaseResponse
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructBaseResponse originally named baseResponse
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
abstract class ColissimoAFStructBaseResponse extends ColissimoAFWsdlClass
{
    /**
     * The messages
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var ColissimoAFStructMessage
     */
    public $messages;
    /**
     * Constructor method for baseResponse
     * @see parent::__construct()
     * @param ColissimoAFStructMessage $_messages
     * @return ColissimoAFStructBaseResponse
     */
    public function __construct($_messages = NULL)
    {
        parent::__construct(array('messages'=>$_messages),false);
    }
    /**
     * Get messages value
     * @return ColissimoAFStructMessage|null
     */
    public function getMessages()
    {
        return $this->messages;
    }
    /**
     * Set messages value
     * @param ColissimoAFStructMessage $_messages the messages
     * @return ColissimoAFStructMessage
     */
    public function setMessages($_messages)
    {
        return ($this->messages = $_messages);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructBaseResponse
     */
    public static function __set_state(array $_array,$_className = __CLASS__)
    {
        return parent::__set_state($_array,$_className);
    }
    /**
     * Method returning the class name
     * @return string __CLASS__
     */
    public function __toString()
    {
        return __CLASS__;
    }
}
