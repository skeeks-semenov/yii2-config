<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
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
 * @property ConfigBehavior $configBehavior
 * @property Model|IHasForm $configModel
 * @property array          $callAttributes <p>Атрибуты с которыми был вызван компонент</p>
 * @property array          $editData <p>Данные для формы редактирования</p>
 * @property string         $configClassName <p>Название класса используемое для хранения настроек</p>
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class ConfigBehavior extends Behavior
{
    /**
     * @var string
     */
    public $_configKey = '__nokey__';

    /**
     * @var ConfigStorage
     */
    public $_configStorage = [];

    /**
     * @var Model|IHasForm
     */
    protected $_configModel = [];

    /**
     * Атрибуты с которыми был вызван компонент
     * @var array
     */
    protected $_callAttributes = [];

    /**
     * @var null|string Название класса используемое для хранения настроек
     */
    protected $_configClassName = null;

    public function events()
    {
        return [
            'init' => '_setSettings'
        ];
    }

    public function _setSettings()
    {
        $owner = $this->owner;
        //Атрибуты вызова компонента
        $this->_callAttributes = ArrayHelper::toArray($this->owner);

        //Загрузка данных модели из хранилища
        $data = $this->configStorage->fetch($this);
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
     * @param Component $owner
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if (!$this->owner instanceof Component) {
            throw new InvalidConfigException('The behavior must be connected to the child class '.Component::class);
        }


    }

    /**
     * @return Component
     */
    public function configRefresh()
    {
        //Загрузка данных модели из хранилища
        $data = $this->configStorage->fetch($this);
        if ($data) {
            $this->configModel->setAttributes($data);
        } else {
            //Если в хранилище нет данных
            $this->configModel->setAttributes($this->_callAttributes);
        }
        
        foreach ($this->configModel->toArray() as $key => $value) {
            if ($this->owner->canSetProperty($key)) {
                $this->owner->{$key} = $value;
            }
        }

        return $this->owner;
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

        return $this->_configModel;
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

        //$this->_configStorage->setConfgiBehavior($this);

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
        return $this->configStorage->save($this, $runValidation, $attributeNames);
    }
    /**
     * Атрибуты вызова
     * @return array
     */
    public function getCallAttributes()
    {
        return $this->_callAttributes;
    }
    /**
     * Данные необходимые для редактирования компонента, при открытии нового окна
     * @return array
     */
    public function getEditData()
    {
        return [
            'callAttributes' => $this->callAttributes,
        ];
    }

    /**
     * @return string
     */
    public function getConfigClassName()
    {
        if ($this->_configClassName === null) {
            $r = new \ReflectionClass($this->owner);
            $this->_configClassName = $r->getName();
        }

        return $this->_configClassName;
    }

    /**
     * @param $className
     * @return Component
     */
    public function setConfigClassName($className)
    {
        $this->_configClassName = $className;
        return $this->owner;
    }

    /**
     * @return $this
     */
    public function getConfigBehavior()
    {
        return $this;
    }
}

