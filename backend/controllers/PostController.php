<?php

namespace backend\controllers;

use Yii;
use app\models\POST;
use app\models\Postsearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for POST model.
 */
class PostController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all POST models.
     * @return mixed
     */
    public function actionIndex() {
        $id = Yii::$app->user->identity->id;

        $searchModel = new Postsearch();


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single POST model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
     $id = Yii::$app->user->identity->id;

        $searchModel = new Postsearch();


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new POST model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (isset(Yii::$app->user->identity->id)) {
            $model = new POST();
  
            if ($model->load(Yii::$app->request->post())) {

                $model->category = $_POST['Post']['category'];
                $model->title = $_POST['Post']['title'];
                $model->description = $_POST['Post']['description'];
                $model->owner = Yii::$app->user->identity->id;
                $model->date = date('Y-m-d');
                $model->save();
         $id2=  Yii::$app->db->getLastInsertID();
         $arr=$_POST['Post']['ManyTags'];

  
   
         foreach ($arr as $key => $value) {
   $model2=new \app\models\Posttags();

             $model2->tagsid=$value;
              $model2->postid=$id2;

           $model2->save();   
              
              
          }  
        
           $model2->save();   

                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {
            $model = new \common\models\LoginForm();


            $query = \app\models\Post::find();

            $pagination = new \yii\data\Pagination([
                'defaultPageSize' => 2,
                'totalCount' => $query->count(),
            ]);
            $post = $query
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();

            return $this->render('/site/index', [
                        'post' => $post,
                        'pagination' => $pagination,
            ]);
        }
    }

    /**
     * Updates an existing POST model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        if (isset(Yii::$app->user->identity->id)) {

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                print_r($_POST['Post']['ManyTags']);
                $session = Yii::$app->session;

	$edit = $session->get('ManyTags2');
        

    if(count($_POST['Post']['ManyTags'])> count($edit)){
        
 $add= array_diff($_POST['Post']['ManyTags'],$edit);             
 $remove= array_diff($edit,$_POST['Post']['ManyTags']);   
   
//         

if(count($add)>0){
    foreach ($add as $key => $value) {
        
    Yii::$app->db->createCommand('
    insert into posttags values (null,:postid,:tagsid)
', [':postid'=>$model->id,':tagsid'=>$value]) ->execute();; 
    
}
}

if(count($remove)>0){
  
    foreach ($remove as $key => $value) {
      
    Yii::$app->db->createCommand('
    delete from posttags where postid=:postid and tagsid=:tagsid
', [':postid'=>$model->id,':tagsid'=>$value]) ->execute(); 
    
} 
   

}
    
      }
      else {
      
    foreach ($edit as $key => $value) {
      
    Yii::$app->db->createCommand('
    delete from posttags where postid=:postid and tagsid=:tagsid
', [':postid'=>$model->id,':tagsid'=>$value]) ->execute(); 
    
}     
      }

                
                
                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {

            $model = new \common\models\LoginForm();


            $query = \app\models\Post::find();

            $pagination = new \yii\data\Pagination([
                'defaultPageSize' => 2,
                'totalCount' => $query->count(),
            ]);
            $post = $query
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();

            return $this->render('/site/index', [
                        'post' => $post,
                        'pagination' => $pagination,
            ]);
        }
    }

    public function actionMangment() {
        if (isset(Yii::$app->user->identity->id)) {
            $id = Yii::$app->user->identity->id;
            if ($id == 1) {
                $searchModel = new Postsearch();

                $dataProvider = $searchModel->deplication(Yii::$app->request->queryParams);

//      

                return $this->render('mangment', [
                            'dataProvider' => $dataProvider,
                ]);
            } else {
                $model = new \common\models\LoginForm();


                $query = \app\models\Post::find();

                $pagination = new \yii\data\Pagination([
                    'defaultPageSize' => 2,
                    'totalCount' => $query->count(),
                ]);
                $post = $query
                        ->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();

                return $this->render('/site/index', [
                            'post' => $post,
                            'pagination' => $pagination,
                ]);
            }
        } else {
            $model = new \common\models\LoginForm();


            $query = \app\models\Post::find();

            $pagination = new \yii\data\Pagination([
                'defaultPageSize' => 2,
                'totalCount' => $query->count(),
            ]);
            $post = $query
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();

            return $this->render('/site/index', [
                        'post' => $post,
                        'pagination' => $pagination,
            ]);
        }
    }

    /**
     * Deletes an existing POST model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the POST model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return POST the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = POST::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
