<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use skeeks\cms\components\Cms;
use skeeks\yii2\form\IHasForm;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\base\WidgetEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Interface IConfigStorage
 * @package skeeks\yii2\config
 */
interface IConfigStorage
{
    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null);

    /**
     * @param ConfigBehavior $configBehavior
     * @return array
     */
    public function fetch();

    /**
     * @return bool
     */
    public function delete();
}

