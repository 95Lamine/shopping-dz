<?php
/**
 * File for class ColissimoPRStructPointRetraitAcheminementByIDResult
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructPointRetraitAcheminementByIDResult originally named pointRetraitAcheminementByIDResult
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructPointRetraitAcheminementByIDResult extends ColissimoPRWsdlClass
{
    /**
     * The errorCode
     * @var int
     */
    public $errorCode;
    /**
     * The errorMessage
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $errorMessage;
    /**
     * The pointRetraitAcheminement
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var ColissimoPRStructPointRetraitAcheminement
     */
    public $pointRetraitAcheminement;
    /**
     * Constructor method for pointRetraitAcheminementByIDResult
     * @see parent::__construct()
     * @param int $_errorCode
     * @param string $_errorMessage
     * @param ColissimoPRStructPointRetraitAcheminement $_pointRetraitAcheminement
     * @return ColissimoPRStructPointRetraitAcheminementByIDResult
     */
    public function __construct($_errorCode = NULL,$_errorMessage = NULL,$_pointRetraitAcheminement = NULL)
    {
        parent::__construct(array('errorCode'=>$_errorCode,'errorMessage'=>$_errorMessage,'pointRetraitAcheminement'=>$_pointRetraitAcheminement),false);
    }
    /**
     * Get errorCode value
     * @return int|null
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    /**
     * Set errorCode value
     * @param int $_errorCode the errorCode
     * @return int
     */
    public function setErrorCode($_errorCode)
    {
        return ($this->errorCode = $_errorCode);
    }
    /**
     * Get errorMessage value
     * @return string|null
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
    /**
     * Set errorMessage value
     * @param string $_errorMessage the errorMessage
     * @return string
     */
    public function setErrorMessage($_errorMessage)
    {
        return ($this->errorMessage = $_errorMessage);
    }
    /**
     * Get pointRetraitAcheminement value
     * @return ColissimoPRStructPointRetraitAcheminement|null
     */
    public function getPointRetraitAcheminement()
    {
        return $this->pointRetraitAcheminement;
    }
    /**
     * Set pointRetraitAcheminement value
     * @param ColissimoPRStructPointRetraitAcheminement $_pointRetraitAcheminement the pointRetraitAcheminement
     * @return ColissimoPRStructPointRetraitAcheminement
     */
    public function setPointRetraitAcheminement($_pointRetraitAcheminement)
    {
        return ($this->pointRetraitAcheminement = $_pointRetraitAcheminement);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructPointRetraitAcheminementByIDResult
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
