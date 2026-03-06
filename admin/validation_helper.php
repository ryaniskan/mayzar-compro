<?php
/**
 * Validation Helper
 * Ensures HTML input follows strict rules:
 * 1. Only <span>, <br>, <br />, and <b> allowed.
 * 2. No attributes allowed in <span> (no style, class, etc).
 * 3. Tags must be balanced.
 */

function validate_input_html($str, $allow_naked_span = true, $allow_links = false)
{
    if (empty($str))
        return true;

    // 1. Check for disallowed tags
    $allowed = '<span><br><b>';
    if ($allow_links) {
        $allowed .= '<a>';
    }

    if (strip_tags($str, $allowed) !== $str) {
        return false;
    }

    // Global check for dangerous attribute smuggling or event handlers
    // Blocks any "on" followed by word characters and "=" (e.g. onclick=)
    if (preg_match('/(?:\s|\/|^)on\w+\s*=/i', $str)) {
        return false;
    }

    // 2. Attribute Validation for <span>
    if (preg_match_all('/<span([^>]*)>/i', $str, $matches)) {
        foreach ($matches[1] as $attrs) {
            $attrs = trim($attrs);
            if (empty($attrs)) {
                if (!$allow_naked_span)
                    return false;
                continue;
            }
            // Only allow exactly class="color-blue4" or class="editor-span"
            if (!preg_match('/^class=["\'](color-blue4|editor-span)["\']$/i', $attrs)) {
                return false;
            }
        }
    }

    // 3. Attribute Validation for <br> and <b>
    if (preg_match_all('/<(br|b)([^>]*)>/i', $str, $matches)) {
        foreach ($matches[2] as $attrs) {
            $attrs = trim($attrs);
            if (!empty($attrs) && $attrs !== '/') {
                return false;
            }
        }
    }

    // 4. Attribute Validation for <a>
    if ($allow_links && preg_match_all('/<a([^>]*)>/i', $str, $matches)) {
        foreach ($matches[1] as $attrs) {
            $attrs = trim($attrs);
            if (empty($attrs))
                continue;

            // Extract all attributes for inspection
            if (preg_match_all('/(\w+)\s*=\s*(["\'])(.*?)\2/i', $attrs, $attr_matches)) {
                $found_attrs = array_map('strtolower', $attr_matches[1]);
                $values = $attr_matches[3];

                // Whitelist allowed attribute names
                $allowed_attr_names = ['href', 'class', 'target', 'rel'];
                foreach ($found_attrs as $name) {
                    if (!in_array($name, $allowed_attr_names))
                        return false;
                }

                foreach ($attr_matches[1] as $idx => $name) {
                    $name = strtolower($name);
                    $val = $values[$idx];

                    if ($name === 'href') {
                        // Protocol Whitelist / Blacklist dangerous schemes
                        // Block javascript:, data:, vbscript:, etc.
                        if (preg_match('/^\s*(javascript|data|vbscript|file):/i', $val)) {
                            return false;
                        }
                    }

                    if ($name === 'target') {
                        // Only allow standard targets
                        if (!preg_match('/^(_blank|_self|_parent|_top)$/i', $val)) {
                            return false;
                        }
                    }
                }
            }

            // Final check: Strip valid attribute patterns and see if anything residue remains
            $remaining = preg_replace('/(href|class|target|rel)\s*=\s*(["\'])(.*?)\2/i', '', $attrs);
            if (trim($remaining, " \t\n\r\0\x0B/") !== '') {
                return false;
            }
        }
    }

    // 5. Balance check
    $opened_span = substr_count(strtolower($str), '<span');
    $closed_span = substr_count(strtolower($str), '</span>');
    if ($opened_span !== $closed_span)
        return false;

    $opened_b = preg_match_all('/<b(?:\s|>)/i', $str, $m);
    $closed_b = substr_count(strtolower($str), '</b>');
    if ($opened_b !== $closed_b)
        return false;

    if ($allow_links) {
        $a_opened = substr_count(strtolower($str), '<a');
        $a_closed = substr_count(strtolower($str), '</a>');
        if ($a_opened !== $a_closed)
            return false;
    }

    return true;
}

/**
 * Basic input validation/sanitization
 * @param string $str The input string
 * @param bool $allow_html Whether to allow the specific <span>/<br> tags
 * @return string Sanitized string or original if invalid (handlers should check validate_recursive first)
 */
function validate_input($str, $allow_html = false)
{
    $str = trim($str);
    if ($allow_html) {
        // We assume validate_recursive was called or we call validate_input_html here
        // For now, just return as is, assuming global validation happened
        return $str;
    }
    return strip_tags($str);
}

// Helper to render Anchor ID input
function render_anchor_input($current_value, $default_value)
{
    ?>
    <div class="mb-4 p-3 bg-light rounded text-center">
        <label class="form-label fw-bold text-uppercase small text-muted">Section Anchor ID</label>
        <div class="input-group" style="max-width: 300px; margin: 0 auto;">
            <span class="input-group-text bg-white text-muted">#</span>
            <input type="text" name="anchor_id" class="form-control"
                value="<?php echo htmlspecialchars($current_value ?? $default_value); ?>" placeholder="section-id"
                pattern="[a-zA-Z0-9-_]+" title="Only letters, numbers, hyphens, and underscores allowed">
        </div>
        <div class="form-text small">Unique ID for linking to this section (e.g. <code>#about</code>)</div>
    </div>
    <?php
}

/**
 * Validates an array of strings or nested arrays
 */
function validate_recursive($data, $allow_naked_span = true, $allow_links = false)
{
    if (is_array($data)) {
        foreach ($data as $val) {
            if (!validate_recursive($val, $allow_naked_span, $allow_links))
                return false;
        }
    } else {
        if (!validate_input_html($data, $allow_naked_span, $allow_links))
            return false;
    }
    return true;
}
?>