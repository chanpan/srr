<?php
$this->title = isset($_GET['txtsearch']) ? $_GET['txtsearch'] : Yii::t('section', 'Section');
//$sectionProvider , $contentProvider

?>

<div class="" style="margin-top:20px;"> 

    <div class="">
        <?php
        $itemCount = $dataProvider->getModels();
        echo "<h1>";
        echo Yii::t('section', 'Keyword');
        echo " : ";
        echo (\Yii::$app->request->get('txtsearch', '') == '') ? 'ทั้งหมด' : \Yii::$app->request->get('txtsearch');

        echo " ";
        echo Yii::t('section', 'Found all');
        echo " ";
        echo count($itemCount);
        echo " ";
        echo Yii::t('section', 'Item');
        echo "</h1>";
        ?>
        <?php
        
        if(isset($sectionProvider->models) && count($sectionProvider->models) > 0){
            //พิพิธภัณฑ์ศิริราช
//            appxq\sdii\utils\VarDumper::dump($sectionProvider->models);
            echo yii\widgets\ListView::widget([
                'dataProvider' => $sectionProvider,
                'itemOptions' => ['class' => 'item col-md-4 col-xs-6'],
                //'layout' => "{items}",
                //'layout' => '<div class=" sidebar-nav-title text-left" ><h3>{summary}</h3></div><div class="row">{items}</div><div class="clearfix"><div class="row " style="margin:0 auto;text-align:center;">{pager}</div></div>',
                'layout' =>'{items}',
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_item', [
                                'model' => $model,
                                'key' => $key,
                                'index' => $index,
                                'data_type'=>'section',
                                //'widget' => $widget,
                                'ezf_id' => $model['id'],
                    ]);
                }
            ]);
        }
        
        if(isset($contentProvider->models) && count($contentProvider->models) > 0){
            //พิพิธภัณฑ์ศิริราช
//            appxq\sdii\utils\VarDumper::dump($sectionProvider->models);
            echo yii\widgets\ListView::widget([
                'dataProvider' => $contentProvider,
                'itemOptions' => ['class' => 'item col-md-4 col-xs-6'],
                //'layout' => "{items}",
                'layout' =>'{items}',
                //'layout' => '<div class=" sidebar-nav-title text-left" ><h3>{summary}</h3></div><div class="row">{items}</div><div class="clearfix"><div class="row " style="margin:0 auto;text-align:center;">{pager}</div></div>',

                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_item', [
                                'model' => $model,
                                'key' => $key,
                                'index' => $index,
                                'data_type'=>'content',
                                //'widget' => $widget,
                                'ezf_id' => $model['id'],
                    ]);
                }
            ]);
        }
        if(isset($dataProvider->models) && count($dataProvider->models) > 0){
            echo yii\widgets\ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'item col-md-4 col-xs-6'],
                //'layout' => "{items}",
                'layout' => '<div class=" sidebar-nav-title text-left" ><h3></h3></div><div class="row">{items}</div><div class="clearfix"><div class="row " style="margin:0 auto;text-align:center;">{pager}</div></div>',

                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_item', [
                                'model' => $model,
                                'key' => $key,
                                'index' => $index,
                                'data_type'=>'file',
                                //'widget' => $widget,
                                'ezf_id' => $model['id'],
                    ]);
                }
            ]);
        }
        
        ?> 
    </div>
</div>
<?php appxq\sdii\widgets\CSSRegister::begin() ?>
<style>
    @media only screen and (min-width: 768px)
    {
        .cd-breadcrumb, .cd-multi-steps {
            width: 100%;
            max-width: 100%;
            margin-left: 0px;
            border: 1px solid #d2d6de;
            background:#fff;
        }
        .cd-breadcrumb li, .cd-multi-steps li {
            margin: 0.2em 0;
        }
    }
    .cd-breadcrumb.custom-separator li::after, .cd-multi-steps.custom-separator li::after {
        content: '/';
        height: 22px;
        width: 1px;
        background: transparent;
        vertical-align: bottom;
    }
    .cd-breadcrumb, .cd-multi-steps { ;
                                      padding: 1px; 
                                      margin-bottom:30px;
    }
    .ias-spinner{
        text-align: center;
        position: absolute;
        bottom: -20px;
        width: 100%;
        font-size: 20pt;
    }
    a.btn.btn-primary.btn-block.btnScroll {
        color: #fff;
        font-size: 10pt;
        width: 50%;
        margin: 0 auto;
        /* position: absolute; */
    }
    .header-text-content{
        padding: 10px;  
        text-align: left; 
        background: #57a19f; 
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }
    .header-text-content small, .header-text-content i{ color:#2e5857;font-size: 14pt; } 
    .single-product{
        background:#fff;
        height:300px;
        padding:5px;
        border-radius: 3px;
        box-shadow: 1px 1px 1px #a5cdcc;
        margin-bottom: 10px;
    }
    .single-product .pro-img{
        width:99%;
        margin:0 auto;
        text-align: center;
    }
    .pro-img img {
        /* text-align: center; */
        margin: 0 auto;
        height: 100%;
    }
    .pro-content .pro-infos h2{
        font-size:16pt;
        text-align: center;
        overflow: hidden;

    }
    .pro-img{
        height:180px;overflow:hidden;
    }
    a:hover{text-decoration: none;}
    /* mobild */
    @media screen and (max-width:768px){
        .single-product .pro-img {
            /* width: 99%; */
            margin: 0 auto;
            text-align: center;
            height: 100px;
        }
        .pro-content .pro-infos h2{
            font-size:10pt;
            text-align: center;
        }
        .pro-img{
            height: auto;
        }
        .single-product{
            /*height: 170px;*/
            height:auto;
        }
        .pro-img img {
            /* text-align: center; */
            margin: 0 auto;
            height: 100%;
        }
        .pro-content .pro-infos p{
            display: none;
        }
    }
</style>
<?php appxq\sdii\widgets\CSSRegister::end(); ?>
