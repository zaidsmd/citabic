<?php

namespace App\Helpers;
class NumberWrapper
{
    /**
     * Main method to wrap numbers with span
     * Handles all number formats including decimals, negatives, percentages, currency, and large numbers
     */
    public static function wrapNumbers($text)
    {
        if (empty($text) || !is_string($text)) {
            return $text;
        }

        // Comprehensive regex pattern for numbers
        $pattern = '/
            (?:^|\s|\(|\[|{|>|&nbsp;|")  # Lookbehind (start or specific characters)
            \K                            # Keep match, exclude lookbehind from replacement
            (
                [-+]?                     # Optional sign
                (?:
                    \d{1,3}(?:,\d{3})*    # Numbers with commas (1,000,000)
                    (?:\.\d+)?             # Optional decimal
                    |
                    \d+(?:\.\d+)?          # Simple numbers with optional decimal
                )
                (?:[kKmMbBtT])?            # Optional compact suffix (k, m, b, t)
                (?:\+)?                    # Optional trailing plus
                (?:%|€|\$|£|¥|₪|₩|₹)?     # Optional percentage or currency symbol after
                (?:[a-zA-Z]*[²³])?         # Optional unit suffix with superscript (m², km², ft², etc.)
                |
                [€\$£¥₪₩₹]                 # Currency symbol before
                \s*
                \d{1,3}(?:,\d{3})*
                (?:\.\d+)?
                (?:[kKmMbBtT])?            # Optional compact suffix (k, m, b, t)
                (?:\+)?                    # Optional trailing plus
            )
            (?=\s|$|\)|\]|\}|<|,|\.|;|:|&nbsp;|"|[a-zA-Z]{2,})  # Lookahead (end, specific characters, or word boundary before multi-char word)
        /ux';

        return preg_replace_callback($pattern, function ($matches) {
            $number = $matches[1];

            // Don't wrap if it's already inside a span
            if (self::isInsideSpan($number)) {
                return $number;
            }

            // Split number into numeric part and suffix
            // Supports: optional sign, digits, optional compact letter, optional +, optional currency/%, optional unit+superscript
            preg_match(
                '/^([-+]?(?:\d{1,3}(?:,\d{3})*|\d+)(?:\.\d+)?)([kKmMbBtT]?\+?(?:%|€|\$|£|¥|₪|₩|₹)?(?:[a-zA-Z]*[²³])?)$'
                . '|^([€\$£¥₪₩₹]\s*(?:\d{1,3}(?:,\d{3})*|\d+)(?:\.\d+)?)([kKmMbBtT]?\+?)$/u',
                $number,
                $parts
            );

            if (!empty($parts)) {
                if (!empty($parts[1])) {
                    $numericPart = $parts[1];
                    $suffix = $parts[2];
                } else {
                    $numericPart = $parts[3];
                    $suffix = $parts[4];
                }
            } else {
                $numericPart = $number;
                $suffix = '';
            }

            // Clean the numeric part for validation
            $cleanNumber = preg_replace('/[,$€£¥₪₩₹\s]/u', '', $numericPart);

            // Check if it's actually a valid number
            if (is_numeric($cleanNumber)) {
                // Store raw numeric value in span so JS counter can parse it correctly (parseFloat)
                // The sign is preserved but no locale formatting (spaces/commas) that would break JS parsing
                return '<span class="counter-number">' . htmlspecialchars($cleanNumber) . '</span>' . htmlspecialchars($suffix);
            }

            return $number;
        }, $text);
    }

    /**
     * Format a number according to the application locale
     */
    private static function formatNumber($numericPart, $cleanNumber)
    {
        // If already has commas (pre-formatted), return as-is
        if (strpos($numericPart, ',') !== false) {
            return $numericPart;
        }

        // Preserve leading sign if present
        $sign = '';
        if ($numericPart[0] === '+' || $numericPart[0] === '-') {
            $sign = $numericPart[0];
        }

        // Only format plain integers (no compact suffix like k/m/b)
        if (!preg_match('/[kKmMbBtT]/', $numericPart) && is_numeric($cleanNumber)) {
            try {
                $locale = config('app.locale', 'fr');
            } catch (\Throwable $e) {
                $locale = 'fr';
            }

            if (class_exists('NumberFormatter')) {
                $fmt = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
                $fmt->setAttribute(\NumberFormatter::GROUPING_USED, true);
                $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 10);
                $formatted = $fmt->format((float) $cleanNumber);
                return $sign !== '' ? ($sign === '+' ? '+' . $formatted : $formatted) : $formatted;
            }

            // Fallback: use number_format with locale-aware separator
            $formatted = number_format((float) $cleanNumber, strpos($cleanNumber, '.') !== false ? strlen(substr(strrchr($cleanNumber, '.'), 1)) : 0, '.', ',');
            return $sign !== '' ? ($sign === '+' ? '+' . $formatted : $formatted) : $formatted;
        }

        return $numericPart;
    }

    /**
     * Process HTML content safely
     */
    public static function wrapNumbersInHtml($html)
    {
        // Parse HTML safely
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        // Get all text nodes that are not inside script, style, or existing counter-number spans
        $textNodes = $xpath->query('//text()[not(ancestor::script)][not(ancestor::style)][not(ancestor::span[@class="counter-number"])]');

        foreach ($textNodes as $node) {
            $wrappedText = self::wrapNumbers($node->nodeValue);

            if ($wrappedText !== $node->nodeValue) {
                // Create a document fragment to insert multiple nodes
                $fragment = $dom->createDocumentFragment();
                $fragment->appendXML($wrappedText);
                $node->parentNode->replaceChild($fragment, $node);
            }
        }

        return $dom->saveHTML();
    }

    /**
     * Check if number is already inside a counter-number span
     */
    private static function isInsideSpan($text)
    {
        return preg_match('/<span[^>]*class="[^"]*counter-number[^"]*"[^>]*>.*?<\/span>/', $text);
    }

    /**
     * Laravel Blade Directive
     */
    public static function registerBladeDirective()
    {
        if (app()->bound('blade.compiler')) {
            app('blade.compiler')->directive('numbers', function ($expression) {
                return "<?php echo NumberWrapper::wrapNumbers($expression); ?>";
            });
        }
    }
}
