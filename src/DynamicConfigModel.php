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
    public $defineAttributes;
    /**
     * @var array
     */
    protected $_fields = [];

    /**
     * @var array
     */
    protected $_rules = [];

    public function init()
    {
        if ($this->defineAttributes && is_array($this->defineAttributes)) {
            foreach ($this->defineAttributes as $key => $value) {
                $this->defineAttribute($key, $value);
            }
        }

        parent::init();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), (array) $this->rules);
    }
    /**
     * @param $fields
     * @return $this
     */
    public function setFields($fields = [])
    {
        $this->_fields = $fields;
        return $this;
    }
    /**
     * @param $fields
     * @return $this
     */
    public function setRules($rules = [])
    {
        $this->_rules = $rules;
        return $this;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->_rules;
    }

    /**
     * @see Builder
     * @return array
     */
    public function builderFields()
    {
        return [];
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
     * @return string
     */
    public function renderActiveForm()
    {
        return '';
    }
}