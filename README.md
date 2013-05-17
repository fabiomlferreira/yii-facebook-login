yii-facebook-login
==================

Plugin usado para fazer a integração com o facebook em sistemas com YII.

Configuracao
-------


* /protect/conf/main.php

		'facebook' => array(
			'class' => 'application.components.facebook.FacebookAPP',
		),

Uso
-----

* nos controllers

		Yii::app()->facebook->run();
		$fb_user = Yii::app()->facebook->getUser();
		$fb_user_profile = Yii::app()->facebook->getUserProfile();
		$fb_url = Yii::app()->facebook->getLoginUrl($redirect_uri);

		$model->fb_id = $fb_user_profile[id];
		$model->email = $fb_user_profile[email];
		$model->nome = $fb_user_profile[name];
