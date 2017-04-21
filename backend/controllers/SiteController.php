<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
      {
      return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $query = \app\models\Post::find();

        $pagination = new \yii\data\Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $query->count(),
        ]);
        $post = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'post' => $post,
            'pagination' => $pagination,
        ]);
            }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
     public function actionSignup()
    {
        $model = new \common\models\SignUp() ;

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
$newuser=new \app\models\UserE();

   
$newuser->username=$model->username ;

$newuser->password =$model->password;
$newuser->id = null;
$newuser->status = 10;
$newuser->save();

        return $this->goHome();

        
        }
          else {
            // either the page is initially displayed or there is some validation error
            return $this->render('signup', ['model' => $model]);
        }
    }
    
       public function actionMypost()
    {
           $id= Yii::$app->user->identity->id;
 $query = \app\models\Post::findBySql("select * from post where owner=:id",[':id'=>$id])->all();
       $count = count ( $query );

       
        $pagination = new \yii\data\Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $count,
        ]);
        $post = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('mypost', [
            'post' => $query,
            'count'=>$count,
            'pagination' => $post,
        ]);
    }
}
