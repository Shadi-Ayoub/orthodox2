<?php

namespace App\Controllers;

class LanguageController extends BaseController {
    public function index(){

         // Validate language input
         if(!$this->_allowed_language_code($_POST["lang"])) {
            $message = "Languge could not be changed. Invalid language code received!!";
            return redirect()->back()->with("fail-message", $message);
        }

        $user = $this->session->get("user");
        $username = $this->session->get("username");
        $profile_array = $user["UserAttributes"]["custom:profile"];
        $profile_array["language"] = $_POST["lang"];
       
        // Save the selected language in user profile
        $result = service('user')->save_profile($username, $profile_array);
        
        if($result["successful"] === false) {
            $message = "Languge could not be changed for some reason!";
            return redirect()->back()->with("fail-message", $message);
        }
        
        // Update the session data for persistance
        $user["UserAttributes"]["custom:profile"] = $result["profile"];        
        $this->session->set("user",$user);

        

        // set the new locale
        service('request')->setLocale($_POST["lang"]);

		return redirect()->back();
    }
    
    private function _allowed_language_code($lang) {
        return in_array($lang, ['en', 'ar']);
    }
}
