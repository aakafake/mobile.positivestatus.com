<?php
    use app\components\Y;
    use app\models\User;
    use yii\helpers\Url;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    // Parameters
    // $trans_dp    - ActiveDataProvider Trans::find()->where('user_id=:user_id AND pause=0)->orderBy('user_id DESC, pause DESC, date_int DESC'),
    // $user_id     - Yii::$app->user->id
    // $header
    // $is_owner    - whether to show edit panel (edit, pause, delete links) or not
    if (!isset($is_owner))
        $is_owner = false;

    // $isBusinessAccount - boolean. Determine show Synchronization Link or not
    $isBusinessAccount = ($is_owner && Yii::$app->user->identity->account_id == User::ACCOUNT_BUSINESS);

    // $isPrivateAccount - boolean. Determine show Amount limitation panel or not
    $isPrivateAccount = ($is_owner && Yii::$app->user->identity->account_id == User::ACCOUNT_BASIC);
?>


<?php if ($isPrivateAccount) {
    // echo $this->render('list_account_panel');
} ?>


<div class="content">
   <!-- <h2 class="predlo_h2"> <?= $header ?> </h2>-->

    <div class="catalog predlo">
    <?php
        Pjax::begin([
            'id' => 'listview_pjax',
            'timeout' => 3000,
            'options' => ['data-pjax' => 0],
        ]);

        echo ListView::widget([
            'dataProvider' => $trans_dp,
            'itemOptions' => ['tag' => false],
            'itemView' => '_list_listview',
            'viewParams' => ['is_owner' => $is_owner],
            'layout' => "{items}\n{pager}",
            'pager' => Y::getPagerSettings(),
        ]);

        Pjax::end();
    ?>
    </div>


<div class="right-menu contaks car nopadtop">
    <?= $this->render('list_limit_panel', ['user_id' => $user_id, 'isPrivateAccount' => $isPrivateAccount]); ?>

    <?php if ($isBusinessAccount) : ?>
        <div class="rek_mr">
            <a href="<?= Url::to(['/sync']) ?>"><img src="/images/smobile.jpg" width="242" height="72" alt=""></a>
        </div>

        <div class="synco">
            <form class="synco__forma" action="#">
                <input type="text" class="synco__pole" placeholder="Ваш сайт">
                <div class="synco__bstons">
                    <svg xmlns="http://www.w3.org/2000/svg" width="31.569" height="31.569" viewBox="0 0 31.569 31.569"><path style="fill:#00277a" d="M9.635 12.04c3.595-1.192 6.812-.584 6.812-.584l.01.937c.017 1.514.43 1.652.43 1.652.98.765 1.868-.053 1.868-.053l6.426-4.73c.165-.123 1.134-.724 1.137-2.3 0-1.578-1.33-2.33-1.33-2.33L18.775.402c-1.044-.71-1.63-.266-1.63-.266-.767.502-.697 1.16-.697 1.16v1.84c-5.81 1.193-9.875 4.722-9.875 4.722-5.587 4.75-4.05 11.353-4.05 11.353s.015.297.58.297c.644 0 .65-.396.65-.396.267-2.247 2.287-5.876 5.882-7.07zM29.046 12.355s-.015-.294-.578-.294c-.646 0-.65.397-.65.397-.268 2.247-2.286 5.875-5.882 7.07-3.597 1.192-6.812.584-6.812.584l-.01-.936c-.016-1.518-.43-1.652-.43-1.652-.978-.766-1.868.053-1.868.053L6.39 22.307c-.164.12-1.13.722-1.133 2.3-.004 1.575 1.327 2.33 1.327 2.33l6.21 4.228c1.044.71 1.63.27 1.63.27.768-.505.7-1.158.7-1.158v-1.843c5.81-1.19 9.874-4.724 9.874-4.724 5.587-4.752 4.048-11.355 4.048-11.355z"/></svg>
                </div>
            </form>
        </div>

        <br />
    <?php endif; ?>


</div>

</div>


