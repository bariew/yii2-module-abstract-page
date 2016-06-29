<?php
/**
 * PageController class file.
 * @copyright (c) 2014, Bariew
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace bariew\pageAbstractModule\controllers;

use bariew\abstractModule\controllers\AbstractModelController;
use Yii;
use bariew\pageAbstractModule\models\Page;

/**
 * Manages page models. Also has menu tree.
 * @author Pavel Bariev <bariew@yandex.ru>
 */
class PageController extends AbstractModelController
{
    public $updateRedirectAction = 'update';

    /**
     * Renders JSTree menu
     * @return string|void
     */
    public function getMenu()
    {
        $model = $this->findModel();
        return $model->findOne(['pid'=>0])->menuWidget();
    }

    /**
     * @inheritdoc
     */
    public function actions() 
    {
        $path = "/files/".$this->module->id."/".$this->id."/".Yii::$app->user->id;
        return array_merge(array_intersect_key(parent::actions(), ['update' => '', 'delete' => '']), [
            'tree-move'      => 'bariew\nodeTree\actions\TreeMoveAction',
            'tree-create'    => 'bariew\nodeTree\actions\TreeCreateAction',
            'tree-update'    => 'bariew\nodeTree\actions\TreeUpdateAction',
            'tree-delete'    => 'bariew\nodeTree\actions\TreeDeleteAction',
            'file-upload'    => [
                'class'         => 'yii\imperavi\actions\FileUpload',
                'uploadPath'    => Yii::getAlias('@app/web'.$path),
                'uploadUrl'     => $path
            ],
            'image-upload'    => [
                'class'         => 'yii\imperavi\actions\ImageUpload',
                'uploadPath'    => Yii::getAlias('@app/web'.$path),
                'uploadUrl'     => $path
            ],
            'image-list'    => [
                'class'         => 'yii\imperavi\actions\ImageList',
                'uploadPath'    => Yii::getAlias('@app/web'.$path),
                'uploadUrl'     => $path
            ],
        ]);
    }
    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = $this->findModel();
        $model->pid = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('modules/page', 'Success'));
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

//    public function findModel($id = null)
//    {
//        if ($id === null) {
//            return new Item();
//        }
//        if (($model = Item::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException(Yii::t('modules/page', 'The requested page does not exist.'));
//        }
//    }
}
