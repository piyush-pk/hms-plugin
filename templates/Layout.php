<?php

namespace HMS\Templates;

class Layout {
    public static function layout(string $content) {
        \HMS\Templates\Header::class::header();
        echo $content;
        \HMS\Templates\Footer::class::footer();
    }

    public static function footer() {
        return \HMS\Templates\Footer::class::footer();
    }

    public static function header() {
        return \HMS\Templates\Header::class::header();
    }
}