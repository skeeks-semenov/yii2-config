<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\yii2\config\storages;

use skeeks\yii2\config\ConfigBehavior;
use skeeks\yii2\config\ConfigStorage;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class ConfigDbModelStorage extends ConfigStorage
{
    /**
     * @var
     */
    public $modelClassName;

    /**
     * @var
     */
    public $primaryKey;

    /**
     * @var
     */
    public $attribute;

    /**
     * @var
     */
    protected $_model;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->model) {
            throw new InvalidConfigException('Need model');
        }

        if (!$this->attribute) {
            throw new InvalidConfigException('Need attribute');
        }

        if (!isset($this->model->{$this->attribute})) {
            throw new InvalidConfigException('Need exist attribute');
        }
    }

    /**
     * @param ActiveRecord $model
     * @return $this
     */
    /*public function setModel(ActiveRecord $model)
    {
        $r = new \ReflectionClass($model);
        $this->_model = $model;
        $this->modelClassName = $r->getName();
        $this->modelPrimaryKey = $model->primaryKey;
        return $this;
    }*/

    /**
     * @return ActiveRecord|null
     */
    public function getModel()
    {
        if ($this->_model === null) {
            $modelClassName = $this->modelClassName;
            $this->_model = $modelClassName::findOne($this->primaryKey);
        }

        return $this->_model;
    }

    public function save(ConfigBehavior $configBehavior, $runValidation = true, $attributeNames = null)
    {
        $configModel = $configBehavior->configModel;
        $configClassName = $configBehavior->configClassName;

        if ($runValidation && !$configModel->validate($attributeNames)) {
            \Yii::info('Model not inserted due to validation error.', $configClassName);
            return false;
        }

        $data = (array)$this->model->{$this->attribute};

        $data[$configClassName][$configBehavior->configKey] = $configModel->toArray();
        $this->model->{$this->attribute} = $data;

        if (!$this->model->save($runValidation, $attributeNames)) {
            throw new Exception(print_r($this->model->errors, true));
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function fetch(ConfigBehavior $configBehavior)
    {
        $data = (array)$this->model->{$this->attribute};
        return (array)ArrayHelper::getValue($data, $configBehavior->configClassName.'.'.$configBehavior->configKey, []);
    }

    /**
     * @return array
     */
    public function delete(ConfigBehavior $configBehavior)
    {
        $configModel = $configBehavior->configModel;
        $configClassName = $configBehavior->configClassName;
        
        $data = (array)$this->model->{$this->attribute};

        if (isset($data[$configClassName][$configBehavior->configKey])) {
            unset($data[$configClassName][$configBehavior->configKey]);
        }

        $this->model->{$this->attribute} = $data;

        if (!$this->model->save()) {
            throw new Exception(print_r($this->model->errors, true));
            return false;
        }

        return true;
    }
}