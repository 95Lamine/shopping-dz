<?php
/**
 * File for class ColissimoAFStructGenerateLabelRequestType
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructGenerateLabelRequestType originally named GenerateLabelRequestType
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructGenerateLabelRequestType extends ColissimoAFWsdlClass
{
    /**
     * The contractNumber
     * @var string
     */
    public $contractNumber;
    /**
     * The password
     * @var string
     */
    public $password;
    /**
     * The outputFormat
     * @var ColissimoAFStructOutputFormat
     */
    public $outputFormat;
    /**
     * The letter
     * @var ColissimoAFStructLetter
     */
    public $letter;
    /**
     * The fields
     * @var ColissimoAFStructFields
     */
    public $fields;
    /**
     * Constructor method for GenerateLabelRequestType
     * @see parent::__construct()
     * @param string $_contractNumber
     * @param string $_password
     * @param ColissimoAFStructOutputFormat $_outputFormat
     * @param ColissimoAFStructLetter $_letter
     * @param ColissimoAFStructFields $_fields
     * @return ColissimoAFStructGenerateLabelRequestType
     */
    public function __construct($_contractNumber = NULL,$_password = NULL,$_outputFormat = NULL,$_letter = NULL,$_fields = NULL)
    {
        parent::__construct(array('contractNumber'=>$_contractNumber,'password'=>$_password,'outputFormat'=>$_outputFormat,'letter'=>$_letter,'fields'=>$_fields),false);
    }
    /**
     * Get contractNumber value
     * @return string|null
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }
    /**
     * Set contractNumber value
     * @param string $_contractNumber the contractNumber
     * @return string
     */
    public function setContractNumber($_contractNumber)
    {
        return ($this->contractNumber = $_contractNumber);
    }
    /**
     * Get password value
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * Set password value
     * @param string $_password the password
     * @return string
     */
    public function setPassword($_password)
    {
        return ($this->password = $_password);
    }
    /**
     * Get outputFormat value
     * @return ColissimoAFStructOutputFormat|null
     */
    public function getOutputFormat()
    {
        return $this->outputFormat;
    }
    /**
     * Set outputFormat value
     * @param ColissimoAFStructOutputFormat $_outputFormat the outputFormat
     * @return ColissimoAFStructOutputFormat
     */
    public function setOutputFormat($_outputFormat)
    {
        return ($this->outputFormat = $_outputFormat);
    }
    /**
     * Get letter value
     * @return ColissimoAFStructLetter|null
     */
    public function getLetter()
    {
        return $this->letter;
    }
    /**
     * Set letter value
     * @param ColissimoAFStructLetter $_letter the letter
     * @return ColissimoAFStructLetter
     */
    public function setLetter($_letter)
    {
        return ($this->letter = $_letter);
    }
    /**
     * Get fields value
     * @return ColissimoAFStructFields|null
     */
    public function getFields()
    {
        return $this->fields;
    }
    /**
     * Set fields value
     * @param ColissimoAFStructFields $_fields the fields
     * @return ColissimoAFStructFields
     */
    public function setFields($_fields)
    {
        return ($this->fields = $_fields);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructGenerateLabelRequestType
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
