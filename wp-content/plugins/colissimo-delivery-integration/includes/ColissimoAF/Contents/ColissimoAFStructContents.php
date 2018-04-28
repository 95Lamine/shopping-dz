<?php
/**
 * File for class ColissimoAFStructContents
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
/**
 * This class stands for ColissimoAFStructContents originally named contents
 * Meta informations extracted from the WSDL
 * - from schema : {@link https://ws.colissimo.fr/sls-ws/SlsServiceWS?wsdl}
 * @package ColissimoAF
 * @subpackage Structs
 * @author WsdlToPhp Team <contact@wsdltophp.fr>
 * @version 20150429-01
 * @date 2016-05-24
 */
class ColissimoAFStructContents extends ColissimoAFWsdlClass
{
    /**
     * The article
     * @var ColissimoAFStructArticle
     */
    public $article;
    /**
     * The category
     * @var ColissimoAFStructCategory
     */
    public $category;
    /**
     * The original
     * @var ColissimoAFStructOriginal
     */
    public $original;
    /**
     * Constructor method for contents
     * @see parent::__construct()
     * @param ColissimoAFStructArticle $_article
     * @param ColissimoAFStructCategory $_category
     * @param ColissimoAFStructOriginal $_original
     * @return ColissimoAFStructContents
     */
    public function __construct($_article = NULL,$_category = NULL,$_original = NULL)
    {
        parent::__construct(array('article'=>$_article,'category'=>$_category,'original'=>$_original),false);
    }
    /**
     * Get article value
     * @return ColissimoAFStructArticle|null
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * Set article value
     * @param ColissimoAFStructArticle $_article the article
     * @return ColissimoAFStructArticle
     */
    public function setArticle($_article)
    {
        return ($this->article = $_article);
    }
    /**
     * Get category value
     * @return ColissimoAFStructCategory|null
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Set category value
     * @param ColissimoAFStructCategory $_category the category
     * @return ColissimoAFStructCategory
     */
    public function setCategory($_category)
    {
        return ($this->category = $_category);
    }
    /**
     * Get original value
     * @return ColissimoAFStructOriginal|null
     */
    public function getOriginal()
    {
        return $this->original;
    }
    /**
     * Set original value
     * @param ColissimoAFStructOriginal $_original the original
     * @return ColissimoAFStructOriginal
     */
    public function setOriginal($_original)
    {
        return ($this->original = $_original);
    }
    /**
     * Method called when an object has been exported with var_export() functions
     * It allows to return an object instantiated with the values
     * @see ColissimoAFWsdlClass::__set_state()
     * @uses ColissimoAFWsdlClass::__set_state()
     * @param array $_array the exported values
     * @return ColissimoAFStructContents
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
