<?php
/**
 * MainMenu class file.
 * @copyright (c) 2015, Pavel Bariev
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\pageAbstractModule\widgets;
use bariew\dropdown\Nav;
use \bariew\pageAbstractModule\models\Page;
use yii\helpers\Url;

/**
 * Widget for the site main menu.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class MainMenu extends Nav
{
    /**
     * @inheritdoc
     */
    public $activateParents = true;
    
    /**
     * @inheritdoc
     */
    public function init() 
    {
        $cssClass = @$this->options['class'];
        parent::init();// significant order
        if ($cssClass != $this->options['class']) {
            \yii\helpers\Html::removeCssClass($this->options, 'nav');
        }
        $this->items = Page::find()
            ->select(['*', 'parent_id' => '(IF(pid=1,"",pid))', 'name' => 'title'])
            ->where(['visible' => true])
            ->andWhere(['<>', 'pid', ''])
            ->indexBy('id')
            ->orderBy(['rank' => SORT_ASC])
            ->asArray()
            ->all();
    }

    /**
     * @inheritdoc
     */
    protected function isPageActive($page)
    {
        return is_numeric(strpos('/'.\Yii::$app->request->pathInfo .'/', $page['url'][0]));
    }
}
