<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$viewDirectory = $root.'/resources/views/pages';

if (! is_dir($viewDirectory) && ! mkdir($viewDirectory, 0777, true) && ! is_dir($viewDirectory)) {
    fwrite(STDERR, "Failed to create view directory.\n");
    exit(1);
}

$pages = [
    'index.html' => 'home',
    'about.html' => 'about',
    'appointment.html' => 'appointment',
    'blog-details.html' => 'blog-details',
    'blog.html' => 'blog',
    'cart.html' => 'cart',
    'checkout.html' => 'checkout',
    'contact.html' => 'contact',
    'error.html' => 'error',
    'faq.html' => 'faq',
    'pricing.html' => 'pricing',
    'project-details.html' => 'project-details',
    'project.html' => 'project',
    'service-details.html' => 'service-details',
    'service.html' => 'service',
    'shop-details.html' => 'shop-details',
    'shop.html' => 'shop',
    'team-details.html' => 'team-details',
    'team.html' => 'team',
    'testimonial.html' => 'testimonial',
    'typography.html' => 'typography',
    'wishlist.html' => 'wishlist',
];

$routeReplacements = [];

foreach ($pages as $file => $routeName) {
    $routeReplacements['href="'.$file.'"'] = 'href="{{ route(\''.$routeName.'\') }}"';
}

foreach (glob($root.'/*.html') as $htmlFile) {
    $basename = basename($htmlFile);

    if (! array_key_exists($basename, $pages)) {
        continue;
    }

    $content = file_get_contents($htmlFile);

    if ($content === false) {
        fwrite(STDERR, "Failed to read {$basename}.\n");
        exit(1);
    }

    $content = preg_replace(
        '/="assets\/([^"]+)"/',
        '="{{ asset(\'assets/$1\') }}"',
        $content
    );

    $content = preg_replace(
        '/href="home-\d+(?:-op)?\.html"/',
        'href="{{ route(\'home\') }}"',
        $content
    );

    $content = str_replace(
        array_keys($routeReplacements),
        array_values($routeReplacements),
        $content
    );

    $content = str_replace(
        'action="mail.php"',
        'action="{{ route(\'contact.submit\') }}"',
        $content
    );

    $content = str_replace(
        '<textarea placeholder="Type Your Message" class="form-control"></textarea>',
        '<textarea name="message" placeholder="Type Your Message" class="form-control"></textarea>',
        $content
    );

    $content = preg_replace(
        '/(<form\b[^>]*\bmethod="(?:POST|post)"[^>]*>)/',
        "$1\n@csrf",
        $content
    );

    $target = $viewDirectory.'/'.$pages[$basename].'.blade.php';

    if (file_put_contents($target, $content) === false) {
        fwrite(STDERR, "Failed to write {$target}.\n");
        exit(1);
    }
}

echo 'Converted '.count($pages)." pages.\n";
