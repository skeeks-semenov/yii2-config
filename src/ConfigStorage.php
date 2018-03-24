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
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\Widget;
use yii\base\WidgetEvent;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @property ConfigBehavior $configBehavior
 *
 * Class ConfigStorage
 * @package skeeks\yii2\config
 */
class ConfigStorage extends Component implements IConfigStorage
{
    /**
     * @param ConfigBehavior $configBehavior
     * @param bool           $runValidation
     * @param null           $attributeNames
     * @return bool
     */
    public function save(ConfigBehavior $configBehavior, $runValidation = true, $attributeNames = null)
    {
        return true;
    }

    /**
     * @return array
     */
    public function fetch(ConfigBehavior $configBehavior)
    {
        return [];
    }

    /**
     * @return bool
     */
    public function delete(ConfigBehavior $configBehavior)
    {
        return true;
    }
}

