<?php

namespace HMS\Templates;

class Footer {
    public static function footer() {
        echo <<< 'Footer_HTML'
                <footer class="bg-gray-800 text-white py-4">
                    <div class="container mx-auto text-center">
                        <p>&copy; 2024 Dinesh Patel. All rights reserved.</p>
                    </div>
                </footer>
            Footer_HTML;
    }
}