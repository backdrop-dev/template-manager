<?php
/**
 * Minimal stand-ins for the framework and WordPress/ClassicPress pieces that
 * the package uses, so the tests run without an install.
 */

namespace Backdrop\Contracts {
    interface Bootable { public function boot(): void; }
}

namespace Backdrop\Tools {
    class Collection extends \ArrayObject {
        public function add( string $name, $value ) { $this->offsetSet( $name, $value ); }
        public function all(): array { return $this->getArrayCopy(); }
    }
}

namespace {
    $GLOBALS['hooks'] = [];

    function esc_html( $s ) { return htmlspecialchars( (string) $s, ENT_QUOTES, 'UTF-8' ); }
    function add_action( $hook, $cb, $priority = 10, $args = 1 ) { $GLOBALS['hooks'][ $hook ][ $priority ][] = $cb; }
    function add_filter( $hook, $cb, $priority = 10, $args = 1 ) { add_action( $hook, $cb, $priority, $args ); }
    function do_action( $hook, ...$args ) {
        foreach ( $GLOBALS['hooks'][ $hook ] ?? [] as $callbacks ) {
            foreach ( $callbacks as $cb ) { $cb( ...$args ); }
        }
    }
    function apply_filters( $hook, $value, ...$args ) {
        foreach ( $GLOBALS['hooks'][ $hook ] ?? [] as $callbacks ) {
            foreach ( $callbacks as $cb ) { $value = $cb( $value, ...$args ); }
        }
        return $value;
    }

    spl_autoload_register( function ( $class ) {
        $prefix = 'Backdrop\\Template\\Manager\\';
        if ( 0 === strpos( $class, $prefix ) ) {
            $file = __DIR__ . '/../src/' . str_replace( '\\', '/', substr( $class, strlen( $prefix ) ) ) . '.php';
            if ( is_file( $file ) ) {
                require $file;
            }
        }
    } );
}
