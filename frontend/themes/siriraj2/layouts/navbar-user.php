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
<li class="<?= ($moduleId == 'museum' && $controllerId == 'default' && $actionId=='index') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/']);?>"><i class='fa fa-home'></i> <?= Yii::t('section', 'HOME') ?></a></li>
<li class="<?= ($moduleId == 'account' && $controllerId == 'default' && $actionId=='settings') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/account/default/settings']);?>"><i class="fa fa-user"></i> <?= Yii::t('appmenu', 'MY PROFILE') ?></a></li>

<li class="<?= ($controllerId == 'site' && $actionId=='about') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/site/about']);?>"><?= Yii::t('section', 'ABOUT US') ?></a></li>
<li class="<?= ($controllerId == 'site' && $actionId=='contact') ? 'nav_active' : 'bg-green'?>"><a href="<?= Url::to(['/site/contact']);?>"><?= Yii::t('section', 'CONTACT US') ?></a></li>
<li class="<?= ($moduleId == 'sections' && $controllerId == 'cart' && $actionId=='my-cart') ? 'nav_active' : 'bg-green'?>">
    <a href="<?= Url::to(['/sections/cart/my-cart']);?>" >
        <img src="<?= \yii\helpers\Url::to('@web/images/cart-icon.png') ?>" style="width:20px;"/>
        ตะกร้าขอข้อมูล
        <span class="my-cart">
            <?php if (!empty($cart)): ?>
                <span class="badge" id="globalCart"><?= $cart ?></span>  
            <?php endif; ?>
        </span>
    </a>
</li>
<li class="dropdown <?= ($moduleId == 'sections' && $controllerId == 'order' && $actionId=='my-order') ? 'nav_active' : 'bg-green'?>">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= Yii::t('section', 'MORE...') ?> <span class="caret"></span></a>
    <ul class="dropdown-menu ">
        <li><a href="<?= Url::to(['/sections/order/my-order']);?>"><?= Yii::t('appmenu', 'REQUEST INFORMATION') ?></a></li>

        <li><a href="<?= Url::to(['/account/sign-in/logout'])?>" data-method="post" tabindex="-1"><i class="fa fa-unlock-alt"></i>  <?= Yii::t('appmenu', 'LOGOUT') ?></a></li>
    </ul>
</li>
<li class="clip-right <?= ($moduleId == 'sections' && $controllerId == 'order' && $actionId=='my-order') ? 'nav_active' : 'bg-green'?>"><a class="menu-height"></a></li>
