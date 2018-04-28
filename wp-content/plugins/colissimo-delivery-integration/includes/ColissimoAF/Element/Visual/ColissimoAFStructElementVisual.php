<?php
/**
 * File for class ColissimoAFStructElementVisual
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructElementVisual originally named elementVisual
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructElementVisual extends ColissimoAFWsdlClass
{
    /**
     * The name
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $name;
    /**
     * The position
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $position;
    /**
     * The shortcut
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $shortcut;
    /**
     * Constructor method for elementVisual
     * @see parent::__construct()
     * @param string $_name
     * @param string $_position
     * @param string $_shortcut
     * @return ColissimoAFStructElementVisual
     */
    public function __construct($_name = NULL,$_position = NULL,$_shortcut = NULL)
    {
        parent::__construct(array('name'=>$_name,'position'=>$_position,'shortcut'=>$_shortcut),false);
    }
    /**
     * Get name value
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Set name value
     * @param string $_name the name
     * @return string
     */
    public function setName($_name)
    {
        return ($this->name = $_name);
    }
    /**
     * Get position value
     * @return string|null
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * Set position value
     * @param string $_position the position
     * @return string
     */
    public function setPosition($_position)
    {
        return ($this->position = $_position);
    }
    /**
     * Get shortcut value
     * @return string|null
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }
    /**
     * Set shortcut value
     * @param string $_shortcut the shortcut
     * @return string
     */
    public function setShortcut($_shortcut)
    {
        return ($this->shortcut = $_shortcut);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructElementVisual
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
