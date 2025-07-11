<?php

namespace App\Core;

use App\Core\Exceptions\ViewNotFoundException;

class View {
    public static function render($view, $data = []) {
        $viewPath =  __DIR__ . '/../Views/' . $view . '.php';
        
        if(!file_exists($viewPath)) {
            throw new ViewNotFoundException('View ' . $view . 'doesnt');
        }

        $content = file_get_contents($viewPath);
        $cachePath = self::generateCachePath($content);
       
        if(!self::isCacheValid($cachePath)) {
            $compiled = self::compile($content);
            self::writeCache($cachePath, $compiled);
        }
        
        extract($data);
        ob_start();

        require $cachePath;

        return ob_get_clean();
    }

    private static function generateCachePath(string $content): string
    {
        return CACHE_DIR . '/' . md5($content) . '.php';
    }

    private static function isCacheValid($cachePath) {
        return file_exists($cachePath) && (time() - filemtime($cachePath)) < CACHE_TIME;
    }

    private static function writeCache($cachePath, $content) {
        file_put_contents($cachePath, $content);
    }

    private static function compile($content) {
        $patterns = [
            '/@use\s*\(\s*[\'"]([^\'"]+)[\'"]\s*,\s*(.+?)\s*\)/',
            '/@use\s*\(\s*[\'"]([^\'"]+)[\'"]\s*\)/',
            '/@foreach\s*\((.*?)\)/',
            '/@endforeach/',
            '/@for\s*\((.*?)\)/',
            '/@endfor/',
            '/@if\s*\((.*?)\)/',
            '/@elseif\s*\((.*?)\)/',
            '/@else/',
            '/@endif/',
            '/\{\{\s*(.+?)\s*\}\}/'
        ];
    
        $replacements = [
            '<?php echo \App\Core\View::render("$1", $2); ?>',
            '<?php echo \App\Core\View::render("$1"); ?>',  
            '<?php foreach ($1): ?>',
            '<?php endforeach; ?>',
            '<?php for ($1): ?>',
            '<?php endfor; ?>',
            '<?php if ($1): ?>',
            '<?php elseif ($1): ?>',
            '<?php else: ?>',
            '<?php endif; ?>',
            '<?php echo htmlspecialchars($1, ENT_QUOTES, "UTF-8"); ?>'
        ];
    
        return preg_replace($patterns, $replacements, $content);
    }
}
