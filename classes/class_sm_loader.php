<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class loader for Stable Master plugin
 * 
 * @since 0.0.2
 */
class SM_Loader {
    private array $directories = array();
    private string $namespacePrefix = '';

    public function __construct( array $directories = array(), string $namespacePrefix = '' ) {
        $this->directories = $directories;
        $this->namespacePrefix = $namespacePrefix;
    }

    public function add_directory( string $directory ): void {
        $directory = rtrim( $directory, DIRECTORY_SEPARATOR );
        if ( ! in_array( $directory, $this->directories ) ) {
            $this->directories[] = $directory;
        }
    }

    public function load_class( string $className ): bool {
        if ( $this->namespacePrefix !== '' && strpos( $className, $this->namespacePrefix ) !== 0 ) {
            return false;
        }

        $relativeClass = $this->namespacePrefix !== '' ? substr( $className, strlen( $this->namespacePrefix ) ) : $className;

        $filePath = str_replace( '\\', DIRECTORY_SEPARATOR, "class_". $relativeClass ) . '.php';
        $filePathWithHypens = str_replace( '_', '-', $filePath );

        foreach ( $this->directories as $directory ) {
            $fullPath = $directory . DIRECTORY_SEPARATOR . $filePathWithHypens;
            $fullPathLowerCase = strtolower( $fullPath );
            if ( file_exists( $fullPathLowerCase ) ) {
                require_once $fullPathLowerCase;
                return true;
            }
        }

        return false;
    }

    public function register(): void {
        spl_autoload_register( array( $this, 'load_class' ) );
    }

    public function unregister(): void {
        spl_autoload_unregister( array( $this, 'load_class' ) );
    }
}
