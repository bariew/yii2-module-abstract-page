<?php
/**
 * UrlRule class file.
 * @copyright (c) 2016, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\pageAbstractModule\components;


use bariew\pageAbstractModule\models\Page;

/**
 * Routing rule for app config.
 * @see README
 * @author Pavel Bariev <bariew@yandex.ru>
 *
 */
class UrlRule extends \yii\web\UrlRule
{
    /**
     * @inheritdoc
     */
    public function parseRequest($manager, $request)
    {
        if (!$result = parent::parseRequest($manager, $request)) {
            return false;
        }
        $manager->rules = array_filter($manager->rules, function($rule) {
            return !$rule instanceof $this;
        });
        if (!$result2 = $manager->parseRequest($request)) {
            return $result;
        }

        return \Yii::$app->createController($result2[0]) ? $result2 : $result;
    }
}