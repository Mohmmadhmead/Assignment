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
```


