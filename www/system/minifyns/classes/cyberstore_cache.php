<?php
class CyberstoreCache {
    public static $path;
    public static $dir = 'ns-cache/';
    public static $page_cache_file = null;
    private $developer_mode = '1';
    private $hostname = '';
    private $request;
	
    public function __construct($registry) {
        $config = $registry->get('config');
        $this->request = $registry->get('request');    
        $this->hostname = md5(CyberstoreUtils::getHostName());
    }
    public function setDeveloperMode($mode) {
        $this->developer_mode = self::canCache() ? $mode : false;
    }
    public function getDeveloperMode() {
		
        if (self::canCache()) {
            if ($this->developer_mode) {
                self::createCacheFiles();
            }
            return $this->developer_mode;
        }
        return true;
    }
    public static function getCachePath() {
        return self::$path . DIRECTORY_SEPARATOR . self::$dir;
    }

    public static function getCacheDir() {
        return self::$dir;
    }

    public static function canCache() {
        $cache_path = self::getCachePath();
        if (file_exists($cache_path) && is_writable($cache_path)) {
            return true;
        }
        if (is_writable(self::$path) && @mkdir($cache_path)) {
            return true;
        }
        return false;
    }

    public static function createCacheFiles() {
        $path = self::getCachePath();
        if (!file_exists($path . '.htaccess')) {
            file_put_contents($path . '.htaccess', file_get_contents(DIR_SYSTEM . 'minifyns/data/cache.htaccess'));
        }
        if (!file_exists($path . 'empty.css')) {
            file_put_contents($path . 'empty.css', '');
        }
        if (!file_exists($path . 'empty.js')) {
            file_put_contents($path . 'empty.js', '');
        }
    }
    public static function deleteCache($pattern = '*') {
        $path = self::getCachePath();
        if (!$path) return;
        $files = glob($path . $pattern);
        if ($files) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }
}
CyberstoreCache::$path = realpath(DIR_SYSTEM . '../');
