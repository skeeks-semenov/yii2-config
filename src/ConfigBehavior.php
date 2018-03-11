<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 *
 * @property Model $configModel
 *
 * Class HasConfigBehavior
 * @package skeeks\yii2\config
 */
class ConfigBehavior extends Behavior
{
    /**
     * @var string
     */
    public $namespace;
    /**
     * @var ???
     */
    public $storage;
    /**
     * @var Model
     */
    protected $_configModel = null;
    /**
     * @var array
     */
    protected $_configModelArray = [];
    /**
     * @param Component $owner
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if (!$this->owner instanceof Component) {
            throw new InvalidConfigException('The behavior must be connected to the child class '.Component::class);
        }

        foreach ($this->configModel->toArray() as $key => $value) {
            if ($owner->canSetProperty($key)) {
                $owner->{$key} = $value;
            }
        }
    }

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
    }
    /**
     * @return Model
     */
    public function getConfigModel()
    {
        if ($this->_configModel === null) {
            $this->_configModel = \Yii::createObject($this->_configModelArray);
        }

        return $this->_configModel;
    }
    public function setConfigModel($configModel = [])
    {
        if (!ArrayHelper::getValue($configModel, 'class')) {
            $this->_configModelArray['class'] = DynamicConfigModel::class;
        }

        $this->_configModelArray = ArrayHelper::merge($this->_configModelArray, $configModel);
        return $this;
    }


}

