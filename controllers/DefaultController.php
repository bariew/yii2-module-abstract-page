<?php
/**
 * DefaultController class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\pageAbstractModule\controllers;

use bariew\pageAbstractModule\models\Page;
use yii\web\Controller;

/**
 * Renders common page.
 *
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class DefaultController extends Controller
{
    /**
     * Renders common page view.
     * @param string $url relative url from route.
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionView($url = '/')
    {
        /**
         * @var Page $model
         */
        if (!$model = Page::childClass(true)->getCurrentPage($url)) {
            throw new \yii\web\HttpException(404, \Yii::t('modules/page', "Page not found"));
        }
        if ($model->layout) {
            $this->layout = $model->layout;
        }
        $this->view->title = $model->page_title;
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => strip_tags($model->page_description),
        ]);
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => strip_tags($model->page_keywords),
        ]);
        return $this->render('view', compact('model'));
    }
}
