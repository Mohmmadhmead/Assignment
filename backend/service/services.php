<?php



 class services {
    
     public function post (){
             $query = \app\models\Post::find();

        $pagination = new \yii\data\Pagination([
            'defaultPageSize' => 2,
            'totalCount' => $query->count(),
        ]);
        $post = $query
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        
        return $post;
     }
}
