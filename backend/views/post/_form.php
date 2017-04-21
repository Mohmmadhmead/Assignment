<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\POST */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin();
    $item = \app\models\Categories::find()->all();
    
    
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?php
    $item = yii\helpers\ArrayHelper::map($item, 'id', 'categories');
    ?>

<?= $form->field($model, 'category')->dropDownList($item) ?>
    
    <?php        $item2 = \app\models\Tags::find()->all();
   
       $item2 = yii\helpers\ArrayHelper::map($item2, 'id', 'tags');
       
   if(!$model->isNewRecord) {
   $checked = \app\models\Posttags::findBySql("select * from posttags where postid=$model->id")->all();  
   $checked = yii\helpers\ArrayHelper::map($checked,'tagsid','id','postid');
   $arr=array();
   foreach ($checked as $key => $value) {
       foreach ($value as $k => $v) {
           $arr[]=$k;
       } 
   } 
   
       
       $session = Yii::$app->session;
       $session->set('ManyTags2', $arr);
     $checkedList = $arr;
     $model->ManyTags = $checkedList;
  
       }
    
       
?>
<?= $form->field($model, 'ManyTags')->checkboxList($item2)->label(FALSE); ?>



    <div class="form-group">
<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
