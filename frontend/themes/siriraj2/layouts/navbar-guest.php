<?php 
    use yii\helpers\Url;
    $moduleId        = (isset(Yii::$app->controller->module->id) && Yii::$app->controller->module->id != 'app-backend') ? Yii::$app->controller->module->id : '';
    $controllerId    = isset(Yii::$app->controller->id) ? Yii::$app->controller->id : '';
    $actionId        = isset(Yii::$app->controller->action->id) ? Yii::$app->controller->action->id : '';
    $viewId          = \Yii::$app->request->get('id', '');
    
    //\appxq\sdii\utils\VarDumper::dump($moduleId);
    ////museum
    //default
    //index
    
?>
<li class="<?= ($moduleId == 'museum' && $controllerId == 'default' && $actionId=='index') ? 'nav_active' : 'bg-green'?>"><a  href="<?= Url::to(['/'])?>"><i class='fa fa-home'></i> <?= Yii::t('section', 'HOME') ?></a></li>
<li class="<?= ($moduleId == 'account' && $controllerId == 'sign-in' && $actionId=='login') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/account/sign-in/login'])?>"><i class="fa fa-sign-in"></i> <?= Yii::t('section', 'SIGN IN') ?></a></li>
<li class="<?= ($moduleId == 'account' && $controllerId == 'sign-in' && $actionId=='signup') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/account/sign-in/signup'])?>"><i class=""></i> <?= Yii::t('section', 'SIGN UP') ?></a></li>
<li class="<?= ($controllerId == 'site' && $actionId=='about') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/site/about'])?>"><?= Yii::t('section', 'ABOUT US') ?></a></li>
<li class="<?= ($controllerId == 'site' && $actionId=='contact') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/site/contact'])?>"><?= Yii::t('section', 'CONTACT US') ?></a></li>
<li class="<?= ($moduleId == 'sections' && $controllerId == 'cart' && $actionId=='my-cart') ? 'nav_active' : 'bg-green'?>">
    <a href="<?= Url::to(['/sections/cart/my-cart'])?>" class="nav-cart-popup">
        <img src="<?= \yii\helpers\Url::to('@web/images/cart-icon.png') ?>" style="width:20px;"/>
        ตะกร้าขอข้อมูล
        <span class="my-cart">
            <?php if (!empty($cart)): ?>
                <span class="badge" id="globalCart"> 1<?= $cart ?></span>  
            <?php endif; ?>
        </span>
    </a>
</li>
<li class="clip-right bg-green"><a class="menu-height"></a></li>
