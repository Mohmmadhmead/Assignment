Open Sooq Assignment

===============================

[database]

![alt tag](https://f.top4top.net/p_476796bo1.png)



DIRECTORY STRUCTURE
-------------------

```
common
    config/                      contains shared configurations
    mail/                        contains view files for e-mails
    models/                      contains model classes used in both backend and frontend
    tests/                       contains tests for common classes    
console
    config/                      contains console configurations
    controllers/                 contains console controllers (commands)
.../TestController               contains console controllers (remove post older than 3 days )
    migrations/                  contains database migrations
.../m170417_160807_tags          contains database Tags table (create -table)
.../m170417_155901_categories    contains database categories table (create -table)
    models/                      contains console-specific model classes
    runtime/                     contains files generated during runtime
backend
    assets/                      contains application assets such as JavaScript and CSS
    config/                      contains backend configurations
    controllers/                 contains Web controller classes
 .../SiteController              contains the login and signup and home  controller 
 .../PostController              contains the Post controller create post ,edit post ,delete post  
    models/                      contains backend-specific model classes
.../Categories                   contains backend-specific model classes(Categories table)
.../Post                         contains backend-specific model classes(Post table)
.../Posttags                     contains backend-specific model classes(posttags table)
.../Tags                         contains backend-specific model classes(Tags table)
.../UserE                        contains backend-specific model classes(UserE table)

    runtime/                     contains files generated during runtime
    tests/                       contains tests for backend application    
    views/                       contains view files for the Web application
 .../post                        contains view files for post site
 .../site                        contains view files for Home site
    web/                         contains the entry script and Web resources


First siteController
```<php>
  public function actionIndex()
    {

        $query = \app\models\Post::find();//get all post (select * from post)

        $pagination = new \yii\data\Pagination([ // create Pagination for get result in more pages
            'defaultPageSize' => 2,
            'totalCount' => $query->count(),
        ]);
        
        $post = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [ // route to index in backend\views\site\index.php
            'post' => $post,
            'pagination' => $pagination,
        ]);
            }
-----------------------------------------------------------------------
 public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {// check if user has login
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) { // if user login then go to home with users rules
            return $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    
    ---------------------------------------------------------------------
    public function actionSignup()
    {
        $model = new \common\models\SignUp() ;//get form data after submit  from common\models\signup

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {// if validate data then save it in user table

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
           $id= Yii::$app->user->identity->id; //get user login id
 $query = \app\models\Post::findBySql("select * from post where owner=:id",[':id'=>$id])->all(); //get post for specific  user
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


------------
second PostController

    public function actionIndex() { // show the user post
        $id = Yii::$app->user->identity->id;

        $searchModel = new Postsearch();


        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }


public function actionCreate() {
        if (isset(Yii::$app->user->identity->id)) {// check if the request from user has login
            $model = new POST();
  
            if ($model->load(Yii::$app->request->post())) {//get result from _form

                $model->category = $_POST['Post']['category'];//get catagory
                $model->title = $_POST['Post']['title'];//get title
                $model->description = $_POST['Post']['description'];//get description
                $model->owner = Yii::$app->user->identity->id;//get owner for post
                $model->date = date('Y-m-d');//get today date
                $model->save();//save in post table
         $id2=  Yii::$app->db->getLastInsertID();// get the last id insert into post table
         $arr=$_POST['Post']['ManyTags'];// get manytags

  
   
         foreach ($arr as $key => $value) {
   $model2=new \app\models\Posttags();

             $model2->tagsid=$value;//get the tags id
              $model2->postid=$id2;// post id

           $model2->save();   //insert into posttags table
              
              
          }  
        
           $model2->save();   

                return $this->redirect(['index', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        } else {// if user not login
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
    
    
      public function actionUpdate($id) {
        if (isset(Yii::$app->user->identity->id)) {// check if user login

            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {//get data from _form

                $session = Yii::$app->session;// start session

	$edit = $session->get('ManyTags2');// get the manytags update
        

    if(count($_POST['Post']['ManyTags'])> count($edit)){ check if insert all manytags or remove all many tags
    
    // get the difference between the before slected many tags and after update
        
 $add= array_diff($_POST['Post']['ManyTags'],$edit); 
 $remove= array_diff($edit,$_POST['Post']['ManyTags']);   
   
//         

if(count($add)>0){ //insert new manytags for post in posttags table
    foreach ($add as $key => $value) {
        
    Yii::$app->db->createCommand('
    insert into posttags values (null,:postid,:tagsid)
', [':postid'=>$model->id,':tagsid'=>$value]) ->execute();; 
    
}
}

if(count($remove)>0){ //remove manytags for post in posttags table
  
    foreach ($remove as $key => $value) {
      
    Yii::$app->db->createCommand('
    delete from posttags where postid=:postid and tagsid=:tagsid
', [':postid'=>$model->id,':tagsid'=>$value]) ->execute(); 
    
} 
   

}
    
      }
      else {// if the edit for manytags is remove all or add all
      
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
        } else {// if user not login

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




    public function actionMangment() {// get duplicated content for a post this page just for admin 
        if (isset(Yii::$app->user->identity->id)) {//check if is a user
            $id = Yii::$app->user->identity->id;
            if ($id == 1) {// check if the user is admin
                $searchModel = new Postsearch();

                $dataProvider = $searchModel->deplication(Yii::$app->request->queryParams);// call method deplication in Postsearch model

//      

                return $this->render('mangment', [ // back the result for mangment page
                            'dataProvider' => $dataProvider,
                ]);
            } else {// if not admin  back to index  site
               

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
        } else {// if not login user


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
    
    
    
    third the Model 
    * 1)POST =2)Categories =3)Posttags=4)Tags =5)UserE =>this for config the tables in database .
    
    *Post search Model:
    extends the Post table hava Main two method 1)search 2)deplication;
  1)serach method : this method return the specific post by user id
  
  public function search($params)
    {$id= Yii::$app->user->identity->id;
    
//dataProvider it's  to display data and sort them by some columns. use  spefic serach for user .

$dataProvider = new ActiveDataProvider([  
    'query' => Post::findBySql(" select * from post where owner=:id 
", ['id'=>$id]),
    'pagination' => [
        'pageSize' => 10
    ],
]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        
        return $dataProvider;
    }
  
  
  2)deplication method : this method for admin mangment it's return the deplication Post same the  title or description
  
  
    public function deplication($params)
    {
  
$dataProvider = new ActiveDataProvider([
    'query' => Post::findBySql("select * from post where title in (SELECT title from post GROUP BY title having COUNT(*)>1) or description in (SELECT description from post GROUP BY description having COUNT(*)>1)"),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
      

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
   
        return $dataProvider;
    }
    
    
    
    
   Four the Views :
   
   #Post View
   
   1)_form :
   
   

    <?php $form = ActiveForm::begin(); // get the form 
$item = \app\models\Categories::find()->all(); // return the data for show the Categories in dropDownList from Categories table
    
    
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>// show text input  for title

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>//show text input  for description 
    <?php
    $item = yii\helpers\ArrayHelper::map($item, 'id', 'categories');// get the result into array from Categories table
    ?>

<?= $form->field($model, 'category')->dropDownList($item) ?>show  the result from array that fill from Categories table
    
    <?php       
    $item2 = \app\models\Tags::find()->all();// return the data for show the ManyTags in checkbox from Tags table
   
       $item2 = yii\helpers\ArrayHelper::map($item2, 'id', 'tags');//convert to array 
       
   if(!$model->isNewRecord) {// this for get the checked Many tags when want update the post 
   $checked = \app\models\Posttags::findBySql("select * from posttags where postid=$model->id")->all();  //get the selected tags
   $checked = yii\helpers\ArrayHelper::map($checked,'tagsid','id','postid');//convert to array
   $arr=array();
   foreach ($checked as $key => $value) {//insert checked id tags into array
       foreach ($value as $k => $v) {
           $arr[]=$k;
       } 
   } 
   
       
       $session = Yii::$app->session;//start session
       $session->set('ManyTags2', $arr);//set session['ManyTags2']=the checked id for tags before update
     $checkedList = $arr;
     $model->ManyTags = $checkedList;
  
       }
    
       
?>
<?= $form->field($model, 'ManyTags')->checkboxList($item2)->label(FALSE); ?>



2)index page :

this for get the Category  Name by get the id from Post table (call the method in  categories class)
 [
            'label' => 'Category',
            'value' => 'categories.categories',
        ]


3)mangment page : that for show the deplication post for the admin


----------------------------------------------------------------------------
   #Site View
   
   1)index page :
   show the all post that share by all user
   
<?php foreach ($post as $value): ?>// get the $post from the index controller 

     <?= Html::encode("{$value->title}"); ?>//get the title for post
     <?= Html::encode("Date:{$value->date}"); ?>// get the date
             <?= Html::encode($value->description) ?> // get the  description   
                    <?php
                    $username = new app\models\UserE();// create object from UserE to Get owner name

                    $c = new app\models\Categories();// create object from Categories to Get Category name
  
   $tags = \app\models\Posttags::findBySql("select * from posttags where postid=$value->id")->all();  // get many tags for post
   $tags = yii\helpers\ArrayHelper::map($tags,'tagsid','id','postid');
     $nametags = \app\models\Tags::findBySql("select * from tags ")->all();  
   $nametags = yii\helpers\ArrayHelper::map($nametags,'id','tags');
   $arr=array();
   $tagss="";
   foreach ($tags as $key => $t) {
       foreach ($t as $k => $v) {
           $arr[]=$k;
           $tagss.=$nametags[$k]." ,";// get the many tags for the post and save it in String Variable
       } 
   } 
   ?>
                    <?php
                    echo "<table>";//show the owner name and the Category and the Many tags in table 
                    echo ("<tr><td>Owner:   </td><td>" . $username->getusername($value->owner)->username . "</td></tr>");
                    ?>
                    
                    <br><?php echo "<tr><td>Category :</td><td>";
                    echo ($c->getcatt($value->category)->categories);
                    
                    ?><?php  echo "</td></tr>";
                   
                    echo "</td></tr>"; ?> <br><?php echo "<tr><td>Tag :</td><td>" ?><?php echo substr($tagss, 0, strlen($tagss)-1).  "</td></tr></table>"; ?></div>

            </div>
        </div>
    </div>
    <br>
<?php endforeach; ?>



finaly : the console command for remove the older post than 3 days 

   {
\Yii::$app
    ->db
    ->createCommand()
    ->delete('post',"date<=CURDATE()-3")
    ->execute();
    }
    
    
 
 for automatic run want to run the cronjob
   
    ```
    
  ```
    preview for the project   

    
  ![alt tag](https://d.top4top.net/p_476r2all1.png)

![alt tag](https://e.top4top.net/p_476l6qe62.png)

![alt tag](https://f.top4top.net/p_476otjjd3.png)

![alt tag](https://a.top4top.net/p_476pm8x74.png)

![alt tag](https://b.top4top.net/p_4762x5805.png)

![alt tag](https://c.top4top.net/p_476nxz5c6.png)

![alt tag](https://d.top4top.net/p_476jzsem7.png)

![alt tag](https://e.top4top.net/p_476fiinh8.png)

