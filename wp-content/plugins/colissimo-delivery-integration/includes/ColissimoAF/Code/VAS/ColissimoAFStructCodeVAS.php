<?php
/**
 * File for class ColissimoAFStructCodeVAS
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructCodeVAS originally named codeVAS
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructCodeVAS extends ColissimoAFWsdlClass
{
    /**
     * The deliveryMode
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $deliveryMode;
    /**
     * The mention
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $mention;
    /**
     * The reserve
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $reserve;
    /**
     * The signature
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $signature;
    /**
     * Constructor method for codeVAS
     * @see parent::__construct()
     * @param string $_deliveryMode
     * @param string $_mention
     * @param string $_reserve
     * @param string $_signature
     * @return ColissimoAFStructCodeVAS
     */
    public function __construct($_deliveryMode = NULL,$_mention = NULL,$_reserve = NULL,$_signature = NULL)
    {
        parent::__construct(array('deliveryMode'=>$_deliveryMode,'mention'=>$_mention,'reserve'=>$_reserve,'signature'=>$_signature),false);
    }
    /**
     * Get deliveryMode value
     * @return string|null
     */
    public function getDeliveryMode()
    {
        return $this->deliveryMode;
    }
    /**
     * Set deliveryMode value
     * @param string $_deliveryMode the deliveryMode
     * @return string
     */
    public function setDeliveryMode($_deliveryMode)
    {
        return ($this->deliveryMode = $_deliveryMode);
    }
    /**
     * Get mention value
     * @return string|null
     */
    public function getMention()
    {
        return $this->mention;
    }
    /**
     * Set mention value
     * @param string $_mention the mention
     * @return string
     */
    public function setMention($_mention)
    {
        return ($this->mention = $_mention);
    }
    /**
     * Get reserve value
     * @return string|null
     */
    public function getReserve()
    {
        return $this->reserve;
    }
    /**
     * Set reserve value
     * @param string $_reserve the reserve
     * @return string
     */
    public function setReserve($_reserve)
    {
        return ($this->reserve = $_reserve);
    }
    /**
     * Get signature value
     * @return string|null
     */
    public function getSignature()
    {
        return $this->signature;
    }
    /**
     * Set signature value
     * @param string $_signature the signature
     * @return string
     */
    public function setSignature($_signature)
    {
        return ($this->signature = $_signature);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructCodeVAS
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
