<?php
//

use yii\helpers\Html;
use yii\widgets\LinkPager;
$this->title = 'HOME';
?>

<?php foreach ($post as $value): ?>
    <div class="container">

        <div class="col-md-12">
            <div class="row" style="background: #0097cf">
                <div class="col-md-8">

                    <h3 style="color: white"><?= Html::encode("{$value->title}"); ?></h3></div> <div class="col-md-4"><h4><?= Html::encode("Date:{$value->date}"); ?></h4> </div>
            </div>
            <div class="row" style="background: wheat">
                <br><div class="col-md-2"><?= Html::encode($value->description) ?>                </div>
                <div class="col-md-10 col-md-12" align="right">
                    <?php
                    $username = new app\models\UserE();

                    $c = new app\models\Categories();
  
   $tags = \app\models\Posttags::findBySql("select * from posttags where postid=$value->id")->all();  
   $tags = yii\helpers\ArrayHelper::map($tags,'tagsid','id','postid');
     $nametags = \app\models\Tags::findBySql("select * from tags ")->all();  
   $nametags = yii\helpers\ArrayHelper::map($nametags,'id','tags');
   $arr=array();
   $tagss="";
   foreach ($tags as $key => $t) {
       foreach ($t as $k => $v) {
           $arr[]=$k;
           $tagss.=$nametags[$k]." ,";
       } 
   } 
   ?>
                    <?php
                    echo "<table>";
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


<?= LinkPager::widget(['pagination' => $pagination]) ?>