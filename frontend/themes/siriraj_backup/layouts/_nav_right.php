<?php ?>
<?php
$cart = isset(Yii::$app->session["cart"]) ? count(Yii::$app->session["cart"]) : 0;
?>
<div class="col-lg-3 col-md-12">
    <div class="cart-box mt-all-30">
        <ul class="d-flex justify-content-center align-items-center">                                     
            <li>
                <a href="/sections/cart/my-cart">
                    <i class="lnr lnr-cart"></i>
                    <span class="my-cart">
                        <span class="total-pro" id="globalCart"> <?= $cart ?></span>
                        <span><?= Yii::t('appmenu', 'My Cart') ?></span>                                            
                    </span>
                </a>
            </li>                                    
            <li>
                <?php
                $userProfile = isset(Yii::$app->user->identity->userProfile) ? Yii::$app->user->identity->userProfile : '';
                $avatar_img = '<img class="img-circle" width="18" src="' . Yii::$app->user->identity->userProfile->image . '"/>';
                ?>
                <a href="#">

                    <img src="<?= "{$userProfile->image}"?>" style='width:40px;' class="img img-circle">
                    <ul class="ht-dropdown cart-box-width">
                        <li><a href="/account/default/settings"><i class="fa fa-user"></i>  <?= Yii::t('appmenu', 'My Profile') ?></a></li>
                        <li><a href="/sections/order/my-order"><i class="fa fa-check-square-o"></i>  <?= Yii::t('appmenu', 'My Orders') ?></a></li>
                        <li><a href="/account/sign-in/logout" data-method="post" tabindex="-1"><i class="fa fa-unlock-alt"></i>  <?= Yii::t('appmenu', 'Logout') ?></a></li>
                    </ul>
                    <span class="my-cart">
                        <span><?= "{$userProfile->firstname}"?></span>
                        <span> 
                            <strong><?= "{$userProfile->lastname}"; ?></strong>
                        </span>

                    </span>
                </a>



            </li>
        </ul>
    </div>
</div>