<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use skeeks\yii2\config\storages\ConfigSessionStorage;
use skeeks\yii2\form\IHasForm;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 *
 * @property string         $configKey
 * @property ConfigStorage  $configStorage
 * @property Model|IHasForm $configModel
 *
 * Class HasConfigBehavior
 * @package skeeks\yii2\config
 */
class ConfigBehavior extends Behavior
{
    /**
     * @var string
     */
    public $_configKey;

    /**
     * @var ConfigStorage
     */
    public $_configStorage = [];

    /**
     * @var Model|IHasForm
     */
    protected $_configModel = [];

    /**
     * Атрибуты вызова компонента
     * @var array
     */
    protected $_callAttributes = [];

    /**
     * @param Component $owner
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if (!$this->owner instanceof Component) {
            throw new InvalidConfigException('The behavior must be connected to the child class '.Component::class);
        }

        //Атрибуты вызова компонента
        $this->_callAttributes = ArrayHelper::toArray($this->owner);

        //Загрузка данных модели из хранилища
        $data = $this->configStorage->fetch();
        if ($data) {
            $this->configModel->setAttributes($data);
        } else {
            //Если в хранилище нет данных
            $this->configModel->setAttributes($this->_callAttributes);
        }

        //Установка в текущий owner
        foreach ($this->configModel->toArray() as $key => $value) {
            if ($owner->canSetProperty($key)) {
                $owner->{$key} = $value;
            }
        }
    }

    /**
     * @return Component
     */
    public function refresh()
    {
        foreach ($this->configModel->toArray() as $key => $value) {
            if ($this->owner->canSetProperty($key)) {
                $this->owner->{$key} = $value;
            }
        }

        return $this->owner;
    }



    /**
     * @param array|IHasForm $configModel
     * @return $this
     */
    public function setConfigModel($configModel)
    {
        $this->_configModel = $configModel;
        return $this;
    }

    /**
     * @return Model|IHasForm
     */
    public function getConfigModel()
    {
        if (is_array($this->_configModel)) {

            if (!ArrayHelper::getValue($this->_configModel, 'class')) {
                $this->_configModel['class'] = DynamicConfigModel::class;
            }

            $this->_configModel = \Yii::createObject($this->_configModel);
        }

        $this->_configModel->setConfgiBehavior($this);

        return $this->_configModel;
    }

    /**
     * @return object|ConfigStorage
     */
    public function getConfigStorage()
    {
        if (is_array($this->_configStorage)) {

            if (!ArrayHelper::getValue($this->_configStorage, 'class')) {
                $this->_configStorage['class'] = ConfigSessionStorage::class;
            }

            $this->_configStorage = \Yii::createObject($this->_configStorage);
        }

        $this->_configStorage->setConfgiBehavior($this);

        return $this->_configStorage;
    }

    /**
     * @param array|ConfigStorage $configStorage
     * @return $this
     */
    public function setConfigStorage($configStorage)
    {
        $this->_configStorage = $configStorage;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfigKey()
    {
        return $this->_configKey;
    }
    /**
     * @param string $configKey
     * @return $this
     */
    public function setConfigKey($configKey = '')
    {
        $this->_configKey = $configKey;
        return $this;
    }


    /**
     * @return bool
     */
    public function saveConfig($runValidation = true, $attributeNames = null)
    {
        return $this->configStorage->save($runValidation, $attributeNames);
    }


}

