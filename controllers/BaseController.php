<?php
namespace controllers;

class BaseController {

    const SEPARATOR = "\r\n";

    public function __construct() {
        add_action('admin_menu', array(&$this, 'addMenu'));
        add_shortcode('securelogin', array(&$this, 'secureLoginOutput'));
    }

    public function addMenu() {
        add_menu_page('SecureLogin', 'SecureLogin', 'edit_users', 'securelogin', array(&$this, 'secureLoginOptionPage'), 'dashicons-lock');
    }

    /**
     *
     */
    public function secureLoginOptionPage() {
        if(!current_user_can('edit_users')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        include(sprintf("%s/../views/options.php", dirname(__FILE__)));
    }

    /**
     *
     */
    public function secureLoginOutput($atts) {
        $attr = shortcode_atts( array(
            'subdomein' => 'sso',
            'background' => '#222',
            'text' => '#FFF',
        ), $atts);

        $username = "Username";
        $password = "Password";
        $login = "Login";
        if (get_locale() == "nl_NL") {
            $username = "Gebruikersnaam";
            $password = "Wachtwoord";
            $login = "Inloggen";
        }

        $this->assets();
        $postUrl = 'https://' . $attr['subdomein'] . '.securelogin.nu/login/exec';
        $html = array();
        $html[] = '<form method="post" action="' . $postUrl . '" class="sl-form" target="_blank">';
        $html[] = '<div class="sl-group">
				   	   <label class="sl-label">' . $username . '</label>
				   	   <div class="sl-controls">
				   	   	   <input type="text" name="username" id="username" value="" class="sl-input">
				   	   </div>
				   </div>
				   <div class="sl-group">
				   	   <label class="sl-label">' . $password . '</label>
				   	   <div class="sl-controls">
				   	   	   <input type="password" name="password" id="password" class="sl-input"><br>
				   	   </div>
				   </div>
				   <div class="sl-group">
				       <button type="submit" class="btn-login" style="background-color: ' . $attr['background'] . '; color: ' . $attr['text'] . ';">' . $login . '</button>
				   </div>';
        $html[] = '</form>';

        return implode($html, self::SEPARATOR);
    }

    protected function assets() {
        $cssPath = plugins_url('../assets/css/securelogin.css', __FILE__);
        wp_enqueue_style('securelogin', $cssPath);
    }
}

