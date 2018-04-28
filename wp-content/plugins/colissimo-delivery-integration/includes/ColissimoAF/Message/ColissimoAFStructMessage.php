<?php
/**
 * File for class ColissimoAFStructMessage
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructMessage originally named Message
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructMessage extends ColissimoAFWsdlClass
{
    /**
     * The id
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $id;
    /**
     * The messageContent
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $messageContent;
    /**
     * The type
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $type;
    /**
     * Constructor method for Message
     * @see parent::__construct()
     * @param string $_id
     * @param string $_messageContent
     * @param string $_type
     * @return ColissimoAFStructMessage
     */
    public function __construct($_id = NULL,$_messageContent = NULL,$_type = NULL)
    {
        parent::__construct(array('id'=>$_id,'messageContent'=>$_messageContent,'type'=>$_type),false);
    }
    /**
     * Get id value
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set id value
     * @param string $_id the id
     * @return string
     */
    public function setId($_id)
    {
        return ($this->id = $_id);
    }
    /**
     * Get messageContent value
     * @return string|null
     */
    public function getMessageContent()
    {
        return $this->messageContent;
    }
    /**
     * Set messageContent value
     * @param string $_messageContent the messageContent
     * @return string
     */
    public function setMessageContent($_messageContent)
    {
        return ($this->messageContent = $_messageContent);
    }
    /**
     * Get type value
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Set type value
     * @param string $_type the type
     * @return string
     */
    public function setType($_type)
    {
        return ($this->type = $_type);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructMessage
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
