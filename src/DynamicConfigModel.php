<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use skeeks\yii2\form\IHasForm;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * Class DynamicConfigModel
 * @package skeeks\yii2\config
 */
class DynamicConfigModel extends DynamicModel implements IHasForm
{
    /**
     * @var array
     */
    protected $_defineAttributes;

    /**
     * @var array
     */
    protected $_fields = [];

    /**
     * @var array
     */
    protected $_rules = [];
    /**
     * @var array
     */
    protected $_attributeLabels = [];

    /**
     * @var array
     */
    protected $_attributeHints = [];

    public function init()
    {
        if ($this->_defineAttributes && is_array($this->_defineAttributes)) {
            foreach ($this->_defineAttributes as $key => $value) {
                if (is_int($key) && is_string($value)) {
                    $this->defineAttribute($value, null);
                } else {
                    $this->defineAttribute($key, $value);
                }

            }
        }

        parent::init();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), (array)$this->_rules);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), (array)$this->_attributeLabels);
    }

    /**
     * @return array
     */
    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), (array)$this->_attributeHints);
    }


    /**
     * @param array $fields
     * @return $this
     */
    public function setFields($fields = [])
    {
        $this->_fields = $fields;
        return $this;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function setRules($rules = [])
    {
        $this->_rules = $rules;
        return $this;
    }

    /**
     * @param array $attributeLabels
     * @return $this
     */
    public function setAttributeLabels($attributeLabels = [])
    {
        $this->_attributeLabels = $attributeLabels;
        return $this;
    }

    /**
     * @param array $attributeHints
     * @return $this
     */
    public function setAttributeHints($attributeHints = [])
    {
        $this->_attributeHints = $attributeHints;
        return $this;
    }

    /**
     * @param array $defineAttributes
     * @return $this
     */
    public function setDefineAttributes($defineAttributes = [])
    {
        $this->_defineAttributes = $defineAttributes;
        return $this;
    }

    /**
     * @see Builder
     * @return array
     */
    public function builderFields()
    {
        return $this->_fields;
    }

    /**
     * @see Builder
     * @return array
     */
    public function builderModels()
    {
        return [];
    }

    /**
     * @var ConfigBehavior
     */
    public $_configBehavior;

    /**
     * @return ConfigBehavior
     */
    public function getConfigBehavior()
    {
        return $this->_configBehavior;
    }
    /**
     * @return ConfigBehavior
     */
    public function setConfgiBehavior(ConfigBehavior $configBehavior)
    {
        $this->_configBehavior = $configBehavior;
        return $this;
    }
}