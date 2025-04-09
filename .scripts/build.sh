# Build ACTIONS-FILTERS.md
php create-actions-filters-docs.php

# Generate .pot file
php -n $(which wp) i18n make-pot ../ ../languages/integrate-posthog-web-analytics.pot

# Build ZIP file, excluding non-Plugin files
cd ..
rm integrate-posthog-web-analytics.zip
zip -r integrate-posthog-web-analytics.zip . \
-x "*.scss" \
-x "*.git*" \
-x ".scripts/*" \
-x "scss" \
-x "tests/*" \
-x "vendor/*" \
-x "*.distignore" \
-x "*.env.*" \
-x ".gitignore" \
-x "*.md" \
-x "*codeception.*" \
-x "composer.json" \
-x "composer.lock" \
-x "config.codekit3" \
-x "phpcs.tests.xml" \
-x "phpcs.xml" \
-x "phpstan.neon" \
-x "phpstan.neon.dist" \
-x "phpstan.neon.example" \
-x "*.DS_Store" \