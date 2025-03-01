<?php

defined('ABSPATH') || exit;

class SMClassLoader {
    private $directories = [];
    private $namespacePrefix = '';

    public function __construct(array $directories = [], string $namespacePrefix = '') {
        $this->directories = $directories;
        $this->namespacePrefix = $namespacePrefix;
    }

    public function addDirectory(string $directory) {
        $directory = rtrim($directory, DIRECTORY_SEPARATOR);
        if (!in_array($directory, $this->directories)) {
            $this->directories[] = $directory;
        }
    }

    public function loadClass(string $className): bool {
        if ($this->namespacePrefix !== '' && 
            strpos($className, $this->namespacePrefix) !== 0) {
            return false;
        }

        $relativeClass = $this->namespacePrefix !== '' 
            ? substr($className, strlen($this->namespacePrefix))
            : $className;

        $filePath = str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.class.php';

        foreach ($this->directories as $directory) {
            $fullPath = $directory . DIRECTORY_SEPARATOR . $filePath;
            $fullPathLowerCase = strtolower($fullPath);
            if (file_exists($fullPathLowerCase)) {
                require_once $fullPathLowerCase;
                return true;
            }
        }

        return false;
    }

    public function register(): void {
        spl_autoload_register([$this, 'loadClass']);
    }

    public function unregister(): void {
        spl_autoload_unregister([$this, 'loadClass']);
    }
}
