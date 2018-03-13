<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2018
 */

namespace skeeks\yii2\config\storages;

use skeeks\yii2\config\ConfigStorage;
use yii\helpers\ArrayHelper;

/**
 * Class ConfigSessionStorage
 * @package skeeks\yii2\config\storages
 */
class ConfigSessionStorage extends ConfigStorage
{
    public function save($runValidation = true, $attributeNames = null)
    {
        $model = $this->configBehavior->configModel;
        $className = $this->configBehavior->owner->className();

        if ($runValidation && !$model->validate($attributeNames)) {
            Yii::info('Model not inserted due to validation error.', $this->configBehavior->owner->className());
            return false;
        }

        $data = \Yii::$app->session->get($className, []);
        $data[$this->configBehavior->configKey] = $this->configBehavior->configModel->toArray();
        \Yii::$app->session->set($className, $data);

        return true;
    }

    /**
     * @return array
     */
    public function fetch()
    {
        $className = $this->configBehavior->owner->className();

        if (!$data = \Yii::$app->session->get($className)) {
            return [];
        }

        return (array)ArrayHelper::getValue($data, $this->configBehavior->configKey);
    }

    /**
     * @return array
     */
    public function delete()
    {
        $className = $this->configBehavior->owner->className();

        if (!$data = \Yii::$app->session->get($className)) {
            return true;
        }

        ArrayHelper::remove($data, $this->configBehavior->configKey);
        \Yii::$app->session->set($className, $data);
    }

}