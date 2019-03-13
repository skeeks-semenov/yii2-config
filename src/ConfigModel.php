<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 11.03.2018
 */

namespace skeeks\yii2\config;

use skeeks\yii2\form\IHasForm;
use yii\base\Model;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;

/**
 * @property ConfigBehavior $configBehavior
 *
 * Class ConfigModel
 * @package skeeks\yii2\config
 */
class ConfigModel extends Model implements IHasForm
{
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























    /**
     * @var array attribute values indexed by attribute names
     */
    private $_attributes = [];
    /**
     * @var array|null old attribute values indexed by attribute names.
     * This is `null` if the record [[isNewRecord|is new]].
     */
    private $_oldAttributes;



    /**
     * @param $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $event = new ModelEvent();
        $this->trigger($insert ? ActiveRecord::EVENT_BEFORE_INSERT : ActiveRecord::EVENT_BEFORE_UPDATE, $event);

        return $event->isValid;
    }

    /**
     * @param $insert
     * @param $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $this->trigger($insert ? ActiveRecord::EVENT_AFTER_INSERT : ActiveRecord::EVENT_AFTER_UPDATE, new AfterSaveEvent([
            'changedAttributes' => $changedAttributes,
        ]));
    }


    /**
     * @return bool
     */
    public function beforeDelete()
    {
        $event = new ModelEvent();
        $this->trigger(ActiveRecord::EVENT_BEFORE_DELETE, $event);

        return $event->isValid;
    }

    /**
     *
     */
    public function afterDelete()
    {
        $this->trigger(ActiveRecord::EVENT_AFTER_DELETE);
    }



    /**
     * Returns a value indicating whether the model has an attribute with the specified name.
     * @param string $name the name of the attribute
     * @return bool whether the model has an attribute with the specified name.
     */
    public function hasAttribute($name)
    {
        return isset($this->_attributes[$name]) || in_array($name, $this->attributes(), true);
    }

    /**
     * Returns the named attribute value.
     * If this record is the result of a query and the attribute is not loaded,
     * `null` will be returned.
     * @param string $name the attribute name
     * @return mixed the attribute value. `null` if the attribute is not set or does not exist.
     * @see hasAttribute()
     */
    public function getAttribute($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }
}