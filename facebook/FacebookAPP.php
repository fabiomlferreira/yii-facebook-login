<?php
/**
 * class Facebook
 * @author Igor Ivanović 
 */
 
require_once "facebook.php";

class FacebookAPP extends CApplicationComponent {

    public $Url;
    public $logoutUrl;
    public $fb_user;
    public $fb_user_profile;
    public $facebook;
    public $scope = 'email, publish_stream, user_birthday';
    public $pageId = 'produtooficialesportes';
    
    /**
    * Run Widget
    */
    public function run()
    {
		$this->renderFacebook();
    }
    
    private function renderFacebook()
    {
    	$this->facebook = new Facebook(array(
		  'appId'  => '',
		  'secret' => '',
		));
			
	    // Get User ID
		$this->fb_user = $this->facebook->getUser();
		
		if ($this->fb_user) {
		  try {
		    // Proceed knowing you have a logged in user who's authenticated.
		    $this->fb_user_profile = $this->facebook->api('/me');
		  } catch (FacebookApiException $e) {
		    error_log($e);
		    $this->fb_user = null;
		  }
		}
		
		if ($this->fb_user) {
		  $this->Url = $this->facebook->getLogoutUrl();
		} else {
		  $this->Url = $this->facebook->getLoginUrl();
		}
    }
    
    public function getUser() {
	    return $this->fb_user;
    }
    
    public function getUserProfile() {
	    return $this->fb_user_profile;
    }
    
    public function getLoginUrl($redirect_uri = null) {
    	if(!$redirect_uri) {
	    	$redirect_uri = Yii::app()->createAbsoluteUrl('site/index');
    	} 
    	$params = array(
		  'scope' => $this->scope,
		  'redirect_uri' => $redirect_uri,
		  'display'=>'popup',
		);
		
		$loginUrl = $this->facebook->getLoginUrl($params);
	    return $loginUrl;
    }
    
    public function postMSG($message, $name, $caption, $link, $description, $picture, $actions_name, $actions_link) {
    	if ($this->fb_user) {
			$attachment = array('message' => "$message",
			    'name' => "$name",
			    'caption' => "$caption",
			    'link' => "$link",
			    'description' => "$description",
			    'picture' => "$picture",
			    'actions' => array(array(
			    	'name' => "$actions_name",
			    	'link' => "$actions_link"
			    )));
			
		    try {
			    // Proceed knowing you have a user who is logged in and authenticated
			    $result = $this->facebook->api('/me/feed/','post',$attachment);
		    } catch (FacebookApiException $e) {
		    	print($e->getMessage());
		    	$user = null;
		    }		
		}    
    }
}

?>
