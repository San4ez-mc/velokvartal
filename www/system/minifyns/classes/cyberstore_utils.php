<?php
class CyberstoreUtils {
	public static $config;
	public function __construct($registry) {
		self::$config = $registry->get('config');  
    }
    public static function getHostName() {
        $protocol = isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1')) ? 'https' : 'http';
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        return $protocol . '://' . $host;
    }
    public static function staticAsset($url) {
        if (self::isExternalResource($url)) {
            return $url;
        }
        $https = isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'));
	
        if ($https && defined('HTTPS_STATIC_CDN')) {
            return HTTPS_STATIC_CDN . $url;
        }
        if (defined('HTTP_STATIC_CDN')) {
            return HTTP_STATIC_CDN . $url;
        }
       return ($https ? self::$config->get('config_ssl') : self::$config->get('config_url')) .  $url;
    }

    public static function isLocalResource($url) {
        if (strpos($url, '//') === 0) {
            return false;
        }
        return !filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function isExternalResource($url) {
        return !self::isLocalResource($url);
    }
  
}