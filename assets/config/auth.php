<?php
return array(
    'domains' => array(
        'default' => array(

            // репозиторий user из бандла app
            'repository' => 'app.user',
            'providers'  => array(

                // включаем поддержку сессий
                'session' => array(
                    'type' => 'http.session'
                ),

                // поддержка кукисов (для "remember me")
                'cookie' => array(
                    'type' => 'http.cookie',

                    // при логине сказать провайдеру session
                    // чтобы тот запомнил юзера
                    'persistProviders' => array('session'),

                    // где сохранять токены
                    'tokens' => array(
                        'storage' => array(
                            'type'            => 'database',
                            'table'           => 'tokens',
                            'defaultLifetime' => 3600*24*14 // две недели
                        )
                    )
                ),

                // поддержка логина паролем
                'password' => array(
                    'type' => 'login.password',

                    // запомнить пользователя в сессии.
                    // заметьте что в этом массиве нет 'cookies'
                    // ведь мы будем делать "remember me" логин
                    // не всегда, а только когда юзер сам попросит
                    'persistProviders' => array('session')
                )
            )
        )
    )
);