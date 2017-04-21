<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'My Post';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
     <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
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
             
            
            // 'owner',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}  {delete}'],
        ],
    ]); ?>
</div>
