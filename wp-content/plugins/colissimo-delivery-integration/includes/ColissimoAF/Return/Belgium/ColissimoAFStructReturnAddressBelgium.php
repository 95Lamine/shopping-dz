<?php
/**
 * File for class ColissimoAFStructReturnAddressBelgium
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructReturnAddressBelgium originally named returnAddressBelgium
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructReturnAddressBelgium extends ColissimoAFWsdlClass
{
    /**
     * The line1
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $line1;
    /**
     * The line2
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $line2;
    /**
     * The mention
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $mention;
    /**
     * Constructor method for returnAddressBelgium
     * @see parent::__construct()
     * @param string $_line1
     * @param string $_line2
     * @param string $_mention
     * @return ColissimoAFStructReturnAddressBelgium
     */
    public function __construct($_line1 = NULL,$_line2 = NULL,$_mention = NULL)
    {
        parent::__construct(array('line1'=>$_line1,'line2'=>$_line2,'mention'=>$_mention),false);
    }
    /**
     * Get line1 value
     * @return string|null
     */
    public function getLine1()
    {
        return $this->line1;
    }
    /**
     * Set line1 value
     * @param string $_line1 the line1
     * @return string
     */
    public function setLine1($_line1)
    {
        return ($this->line1 = $_line1);
    }
    /**
     * Get line2 value
     * @return string|null
     */
    public function getLine2()
    {
        return $this->line2;
    }
    /**
     * Set line2 value
     * @param string $_line2 the line2
     * @return string
     */
    public function setLine2($_line2)
    {
        return ($this->line2 = $_line2);
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
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructReturnAddressBelgium
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
