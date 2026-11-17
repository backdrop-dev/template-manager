<?php
/**
 * Dependency free tests. Run with: php tests/run.php
 */

require __DIR__ . '/bootstrap.php';

use Backdrop\Template\Manager\Component;
use Backdrop\Template\Manager\Template;
use Backdrop\Template\Manager\Templates;

$failed = 0;

function check( string $label, $actual, $expected ): void {
    global $failed;
    if ( $actual === $expected ) {
        echo "ok   - {$label}\n";
        return;
    }
    $failed++;
    echo "FAIL - {$label}\n       expected: " . var_export( $expected, true ) . "\n       actual:   " . var_export( $actual, true ) . "\n";
}

// Template.
$all = new Template( 'wide.php', [ 'label' => 'Wide' ] );
check( 'filename', $all->filename(), 'wide.php' );
check( 'label', $all->label(), 'Wide' );
check( 'string cast is the filename', (string) $all, 'wide.php' );
check( 'defaults to the post type', $all->isType( 'post' ), true );
check( 'no subtype means every post type', $all->forPostType( 'book' ), true );

$page = new Template( 'page.php', [ 'label' => 'Page', 'subtype' => [ 'page' ] ] );
check( 'subtype match', $page->forPostType( 'page' ), true );
check( 'subtype mismatch', $page->forPostType( 'post' ), false );

$alias = new Template( 'a.php', [ 'label' => 'A', 'post_types' => 'book' ] );
check( 'post_types alias', [ $alias->forPostType( 'book' ), $alias->forPostType( 'page' ) ], [ true, false ] );

$term = new Template( 't.php', [ 'label' => 'T', 'type' => 'term' ] );
check( 'other types are not post templates', $term->forPostType( 'page' ), false );

// Templates collection.
$templates = new Templates();
$templates->add( 'wide.php', [ 'label' => 'Wide' ] );
check( 'collection wraps values in Template', $templates->all()['wide.php'] instanceof Template, true );

// Component.
$component = new Component( $templates );
$component->boot();
$seen = null;
add_action( 'backdrop/templates/register', function ( $t ) use ( &$seen ) {
    $seen = $t;
    $t->add( 'page.php', [ 'label' => 'A <b>Page</b>', 'subtype' => [ 'page' ] ] );
} );
do_action( 'init' );
check( 'register action receives the collection', $seen, $templates );

$list = apply_filters( 'theme_templates', [ 'x.php' => 'X' ], null, null, 'page' );
check( 'dropdown lists templates for the post type', array_keys( $list ), [ 'x.php', 'wide.php', 'page.php' ] );
check( 'labels are escaped', $list['page.php'], 'A &lt;b&gt;Page&lt;/b&gt;' );

$list = apply_filters( 'theme_templates', [], null, null, 'post' );
check( 'subtype templates are left out for other types', array_keys( $list ), [ 'wide.php' ] );

echo $failed ? "\n{$failed} failed\n" : "\nAll passed\n";
exit( $failed ? 1 : 0 );
