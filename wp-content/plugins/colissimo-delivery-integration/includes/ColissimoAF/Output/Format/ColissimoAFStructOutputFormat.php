<?php
/**
 * File for class ColissimoAFStructOutputFormat
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructOutputFormat originally named outputFormat
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructOutputFormat extends ColissimoAFWsdlClass
{
    /**
     * The x
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $x;
    /**
     * The y
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var int
     */
    public $y;
    /**
     * The outputPrintingType
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $outputPrintingType;
    /**
     * The dematerialized
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $dematerialized;
    /**
     * The returnType
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $returnType;
    /**
     * The printCODDocument
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var boolean
     */
    public $printCODDocument;
    /**
     * Constructor method for outputFormat
     * @see parent::__construct()
     * @param int $_x
     * @param int $_y
     * @param string $_outputPrintingType
     * @param boolean $_dematerialized
     * @param string $_returnType
     * @param boolean $_printCODDocument
     * @return ColissimoAFStructOutputFormat
     */
    public function __construct($_x = NULL,$_y = NULL,$_outputPrintingType = NULL,$_dematerialized = NULL,$_returnType = NULL,$_printCODDocument = NULL)
    {
        parent::__construct(array('x'=>$_x,'y'=>$_y,'outputPrintingType'=>$_outputPrintingType,'dematerialized'=>$_dematerialized,'returnType'=>$_returnType,'printCODDocument'=>$_printCODDocument),false);
    }
    /**
     * Get x value
     * @return int|null
     */
    public function getX()
    {
        return $this->x;
    }
    /**
     * Set x value
     * @param int $_x the x
     * @return int
     */
    public function setX($_x)
    {
        return ($this->x = $_x);
    }
    /**
     * Get y value
     * @return int|null
     */
    public function getY()
    {
        return $this->y;
    }
    /**
     * Set y value
     * @param int $_y the y
     * @return int
     */
    public function setY($_y)
    {
        return ($this->y = $_y);
    }
    /**
     * Get outputPrintingType value
     * @return string|null
     */
    public function getOutputPrintingType()
    {
        return $this->outputPrintingType;
    }
    /**
     * Set outputPrintingType value
     * @param string $_outputPrintingType the outputPrintingType
     * @return string
     */
    public function setOutputPrintingType($_outputPrintingType)
    {
        return ($this->outputPrintingType = $_outputPrintingType);
    }
    /**
     * Get dematerialized value
     * @return boolean|null
     */
    public function getDematerialized()
    {
        return $this->dematerialized;
    }
    /**
     * Set dematerialized value
     * @param boolean $_dematerialized the dematerialized
     * @return boolean
     */
    public function setDematerialized($_dematerialized)
    {
        return ($this->dematerialized = $_dematerialized);
    }
    /**
     * Get returnType value
     * @return string|null
     */
    public function getReturnType()
    {
        return $this->returnType;
    }
    /**
     * Set returnType value
     * @param string $_returnType the returnType
     * @return string
     */
    public function setReturnType($_returnType)
    {
        return ($this->returnType = $_returnType);
    }
    /**
     * Get printCODDocument value
     * @return boolean|null
     */
    public function getPrintCODDocument()
    {
        return $this->printCODDocument;
    }
    /**
     * Set printCODDocument value
     * @param boolean $_printCODDocument the printCODDocument
     * @return boolean
     */
    public function setPrintCODDocument($_printCODDocument)
    {
        return ($this->printCODDocument = $_printCODDocument);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructOutputFormat
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
