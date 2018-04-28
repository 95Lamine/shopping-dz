<?php
/**
 * File for class ColissimoPRStructPointRetraitAcheminementResult
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoPRStructPointRetraitAcheminementResult originally named pointRetraitAcheminementResult
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/pointretrait-ws-cxf/PointRetraitServiceWS/2.0?wsdl}
 * @package ColissimoPR
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoPRStructPointRetraitAcheminementResult extends ColissimoPRWsdlClass
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
     * The listePointRetraitAcheminement
     * Meta informations extracted from the WSDL
     * - maxOccurs : unbounded
     * - minOccurs : 0
     * - nillable : true
     * @var ColissimoPRStructPointRetraitAcheminement
     */
    public $listePointRetraitAcheminement;
    /**
     * The qualiteReponse
     * @var int
     */
    public $qualiteReponse;
    /**
     * The wsRequestId
     * Meta informations extracted from the WSDL
     * - minOccurs : 0
     * @var string
     */
    public $wsRequestId;
    /**
     * Constructor method for pointRetraitAcheminementResult
     * @see parent::__construct()
     * @param int $_errorCode
     * @param string $_errorMessage
     * @param ColissimoPRStructPointRetraitAcheminement $_listePointRetraitAcheminement
     * @param int $_qualiteReponse
     * @param string $_wsRequestId
     * @return ColissimoPRStructPointRetraitAcheminementResult
     */
    public function __construct($_errorCode = NULL,$_errorMessage = NULL,$_listePointRetraitAcheminement = NULL,$_qualiteReponse = NULL,$_wsRequestId = NULL)
    {
        parent::__construct(array('errorCode'=>$_errorCode,'errorMessage'=>$_errorMessage,'listePointRetraitAcheminement'=>$_listePointRetraitAcheminement,'qualiteReponse'=>$_qualiteReponse,'wsRequestId'=>$_wsRequestId),false);
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
     * Get listePointRetraitAcheminement value
     * @return ColissimoPRStructPointRetraitAcheminement|null
     */
    public function getListePointRetraitAcheminement()
    {
        return $this->listePointRetraitAcheminement;
    }
    /**
     * Set listePointRetraitAcheminement value
     * @param ColissimoPRStructPointRetraitAcheminement $_listePointRetraitAcheminement the listePointRetraitAcheminement
     * @return ColissimoPRStructPointRetraitAcheminement
     */
    public function setListePointRetraitAcheminement($_listePointRetraitAcheminement)
    {
        return ($this->listePointRetraitAcheminement = $_listePointRetraitAcheminement);
    }
    /**
     * Get qualiteReponse value
     * @return int|null
     */
    public function getQualiteReponse()
    {
        return $this->qualiteReponse;
    }
    /**
     * Set qualiteReponse value
     * @param int $_qualiteReponse the qualiteReponse
     * @return int
     */
    public function setQualiteReponse($_qualiteReponse)
    {
        return ($this->qualiteReponse = $_qualiteReponse);
    }
    /**
     * Get wsRequestId value
     * @return string|null
     */
    public function getWsRequestId()
    {
        return $this->wsRequestId;
    }
    /**
     * Set wsRequestId value
     * @param string $_wsRequestId the wsRequestId
     * @return string
     */
    public function setWsRequestId($_wsRequestId)
    {
        return ($this->wsRequestId = $_wsRequestId);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoPRWsdlClass::__set_state()
     * @uses ColissimoPRWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoPRStructPointRetraitAcheminementResult
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
