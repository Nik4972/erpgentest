<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Tables',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Address Types', 'icon' => 'envelope', 'url' => ['/address-type'],],
                            ['label' => 'Languages', 'icon' => 'text', 'url' => ['/language'],],
                            ['label' => 'Currencies', 'icon' => 'euro', 'url' => ['/currency'],],
                            ['label' => 'Macroregions GEO', 'icon' => 'globe', 'url' => ['/geo-macroregion-geo'],],
                            ['label' => 'Macroregions Com', 'icon' => 'envelope', 'url' => ['/geo-macroregion-com'],],
                            ['label' => 'Countries', 'icon' => 'envelope', 'url' => ['/geo-country'],],
                            ['label' => 'Regions', 'icon' => 'envelope', 'url' => ['/region'],],
                            ['label' => 'Cities', 'icon' => 'envelope', 'url' => ['/city'],],
                            ['label' => 'Streets', 'icon' => 'envelope', 'url' => ['/street'],],
                            ['label' => 'Contractors', 'icon' => 'paperclip', 'url' => ['/contractor'],],
                            ['label' => 'Companies', 'icon' => 'inbox', 'url' => ['/company'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
