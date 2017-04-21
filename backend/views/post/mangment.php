<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Post;

$this->title = 'Mangment';
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
  $posts = $dataProvider->getModels();  ?>
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description:ntext',
             [
            'label' => 'Category',
            'value' => 'categories.categories',
        ],
                  [
            'label' => 'Owner',
            'value' => 'userE.username',
        ],

        ['class' => 'yii\grid\ActionColumn', 'template' => '{update}  {delete}'],

        ],
    ]);
   ?>
  

    
</div>
