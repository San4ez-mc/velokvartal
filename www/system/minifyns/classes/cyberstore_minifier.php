<?php
require_once DIR_SYSTEM . 'minifyns/lib/Minify/CSS/Compressor.php';
require_once DIR_SYSTEM . 'minifyns/lib/Minify/CommentPreserver.php';
require_once DIR_SYSTEM . 'minifyns/lib/Minify/CSS/UriRewriter.php';
require_once DIR_SYSTEM . 'minifyns/lib/Minify/CSS.php';
require_once DIR_SYSTEM . 'minifyns/lib/Minify/JSMin.php';
require_once DIR_SYSTEM . 'minifyns/lib/Minify/HTML.php';

class CyberstoreMinifier {
    private $cache;

    private $minify_css = false;
    private $minify_js = false;

    private $path = null;
    private $dir = null;

    private $styles = array();
    private $scripts = array(
        'header'    => array(),
        'footer'    => array()
    );
	
    public function __construct($cache) {
        $this->cache = $cache;
        $this->path = CyberstoreCache::getCachePath();
        $this->dir = CyberstoreCache::getCacheDir();
    }

    public function getMinifyCss() {
        return $this->minify_css;
    }

    public function setMinifyCss($value) {
        $this->minify_css = $value;
    }

    public function getMinifyJs() {
        return $this->minify_js;
    }

    public function setMinifyJs($value) {
        $this->minify_js = $value;
    }

    public function addStyle($href) {
        $this->styles[md5($href)] = $href;
    }

    public function addScript($src, $position = 'header') {
        $this->scripts[$position][md5($src)] = $src;
    }
    public function css($src = false) {
        if ($this->cache->canCache() && !$this->cache->getDeveloperMode() && $this->minify_css) {
          
            $combined_css_file = '_' . $this->getHash($this->styles, 'css');
			
            if (!file_exists($this->path . $combined_css_file)) {
                /* parse all styles, generate corresponding minified css file */
                foreach ($this->styles as $style) {
                    $file = $this->path . $this->getHash($style, 'css');
                    if (!file_exists($file)) {
                        $css_file = realpath(DIR_SYSTEM . '../' . $this->removeQueryString($style));
                        if (!file_exists($css_file)) {
                            continue;
                        }
                        $content = file_get_contents($css_file);
						if ($style === 'catalog/view/javascript/bootstrap/css/bootstrap.min.css') {
							file_put_contents($file, $content, LOCK_EX);
						} else {
							$content_min = Minify_CSS::minify($content, array(
								'preserveComments' => false,
								'currentDir' => dirname($css_file)
							));
							file_put_contents($file, $content_min, LOCK_EX);
						}
                        
                    }
                }
                /* combine all styles into one file */
                $fh = @fopen($this->path . $combined_css_file, 'w');
                flock($fh, LOCK_EX);
                foreach ($this->styles as $style) {
                    $file = $this->path . $this->getHash($style, 'css');
                    if (!file_exists($file)) {
                        continue;
                    }
                    $content = file_get_contents($file);
                    fwrite($fh, $content);
                } 
            }
            /* return link tag */
            if ($src) {
                return CyberstoreUtils::staticAsset($this->dir . $combined_css_file);
            }
            return $this->printStyle($this->dir . $combined_css_file);
        }
        $assets = '';
        foreach ($this->styles as $style) {
            $assets .= $this->printStyle($style);
        }
        return $assets;
    }

    public function js($position = 'header', $src= false) {
        if ($this->cache->canCache() && !$this->cache->getDeveloperMode() && $this->minify_js) {
            /* generate file if not exits */
            $combined_js_file = '_' . $this->getHash($this->scripts[$position], 'js');
            if (!file_exists($this->path . $combined_js_file)) {
                /* parse all scripts, generate corresponding minified js file */
                foreach ($this->scripts[$position] as $script) {
                    $file = $this->path . $this->getHash($script, 'js');
                    if (!file_exists($file)) {
                        $js_file = realpath(DIR_SYSTEM . '../' . $this->removeQueryString($script));
                        if (!file_exists($js_file)) {
                            continue;
                        }
                        $content = file_get_contents($js_file);
                        $content_min = JSMin::minify($content);
                        file_put_contents($file, $content_min, LOCK_EX);
                    }
                }

                /* combine all scripts into one file */
                $fh = @fopen($this->path . $combined_js_file, 'w');
                flock($fh, LOCK_EX);
                foreach ($this->scripts[$position] as $script) {
                    $file = $this->path . $this->getHash($script, 'js');
                    if (!file_exists($file)) {
                        continue;
                    }
                    $content = file_get_contents($file);
                    fwrite($fh, ';' . $content);
                }
            }
            /* return link tag */
            if ($src) {
                return CyberstoreUtils::staticAsset($this->dir . $combined_js_file);
            }
            if ($position === 'footer') {
                return $this->printScript($this->dir . $combined_js_file, ' defer');
            }
            return $this->printScript($this->dir . $combined_js_file);
        }
        $assets = '';
        foreach ($this->scripts[$position] as $script) {
            $assets .= $this->printScript($script);
        }
        return $assets;
    }

    private function getHash($files, $ext) {
        $hash = '';
        if (is_array($files)) {
            foreach ($files as $file) {
                $hash .= $file;
            }
        } else {
            $hash = $files;
        }
        $hash .= CYBERSTORE_VERSION;
        $hash .= CyberstoreUtils::getHostName();
        return md5($hash) . '.' . $ext;
    }

    private function printStyle($href) {
        return '<link rel="preload" as="style" href="' . CyberstoreUtils::staticAsset($this->addCyberstorelVersion($href, $this->minify_css)) . '"/><link rel="stylesheet" href="' . CyberstoreUtils::staticAsset($this->addCyberstorelVersion($href, $this->minify_css)) . '"/>' . PHP_EOL;
    }

    private function printScript($src, $def = '') {
        $def = rtrim($def) . ' ';
        return '<link rel="preload" as="script" href="' . CyberstoreUtils::staticAsset($this->addCyberstorelVersion($src, $this->minify_css)) . '"/><script' . $def . 'src="' . CyberstoreUtils::staticAsset($this->addCyberstorelVersion($src, $this->minify_css)) .  '"></script>' . PHP_EOL;
    }

    private function removeQueryString($file) {
        $file = explode('?', $file);
        return $file[0];
    }

    private function addCyberstorelVersion($url, $is_minified) {
        if (!$this->cache->getDeveloperMode() && $is_minified) {
            return $url;
        }
        if (strpos($url, '?') === false) {
            return $url . '?cs2v=' . CYBERSTORE_VERSION;
        }
        return $url . '&amp;cs2v=' . CYBERSTORE_VERSION;
    }

}