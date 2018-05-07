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
use yii\base\Event;
use yii\helpers\ArrayHelper;

/**
 * Class DynamicConfigModel
 * @package skeeks\yii2\config
 */
class DynamicConfigModel extends DynamicModel implements IHasForm
{
    /**
     * @var ConfigBehavior
     */
    public $_configBehavior;
    /**
     * @var string
     */
    public $formName = 'f';
    /**
     * @var array
     */
    protected $_attributeDefines;
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

    /**
     * @var array
     */
    protected $_builderModels = [];

    /**
     * @return null|string
     */
    public function formName()
    {
        if ($this->formName === null) {
            return parent::formName();
        }

        return $this->formName;
    }

    public function init()
    {
        if ($this->_attributeDefines && is_array($this->_attributeDefines)) {
            foreach ($this->_attributeDefines as $key => $value) {
                if (is_int($key) && is_string($value)) {
                    $this->defineAttribute($value, null);
                } else {
                    $this->defineAttribute($key, $value);
                }
            }
        }

        if ($this->_fields) {
            foreach ($this->_fields as $key => $value) {
                if (is_string($key)) {
                    if (!isset($this->{$key})) {
                        $this->defineAttribute($key, null);
                    }
                }
                //TODO:доделать другие случаи
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
        $labels = ArrayHelper::merge(parent::attributeLabels(), (array)$this->_attributeLabels);

        foreach ($this->builderFields() as $key => $field) {
            if (!ArrayHelper::getValue($labels, $key)) {
                if (is_object($field)) {
                    $labels[$key] = ArrayHelper::getValue($field, 'label');
                } else if (is_array($field)) {
                    $labels[$key] = ArrayHelper::getValue($field, 'label');
                }
            }
        }

        return $labels;
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
     * @param array $attributeDefines
     * @return $this
     */
    public function setattributeDefines($attributeDefines = [])
    {
        $this->_attributeDefines = $attributeDefines;
        return $this;
    }
    /**
     * @see Builder
     * @return array
     */
    public function builderModels()
    {
        return $this->_builderModels;
    }

    /**
     * @param array $models
     * @return $this
     */
    public function setBuilderModels($models = [])
    {
        $this->_builderModels = $models;
        return $this;
    }

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

    /**
     * @param array $data
     * @param null  $formName
     * @return bool
     */
    /*public function load($data, $formName = null)
    {
        $result = parent::load($data, $formName);

        $this->trigger('load', new Event([
            'data' => $data
        ]));

        return $result;
    }*/
}