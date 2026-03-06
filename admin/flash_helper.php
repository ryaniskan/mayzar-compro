<?php
/**
 * Flash Message Helper
 */

function set_flash($type, $message)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash'] = [
        'type' => $type, // success, danger, warning, info
        'message' => $message
    ];
}

function display_flash()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        $icon = 'fas fa-check';
        $title = 'Success!';
        if ($flash['type'] === 'danger' || $flash['type'] === 'error') {
            $icon = 'fas fa-ban';
            $title = 'Error!';
            $flash['type'] = 'danger'; // Ensure CSS class is alert-danger
        } elseif ($flash['type'] === 'warning') {
            $icon = 'fas fa-exclamation-triangle';
            $title = 'Warning!';
        } elseif ($flash['type'] === 'info') {
            $icon = 'fas fa-info';
            $title = 'Notice!';
        }

        echo "
        <div class='alert alert-{$flash['type']} alert-dismissible shadow-sm rounded-0'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5 class='mb-1'><i class='icon {$icon}'></i> {$title}</h5>
            {$flash['message']}
        </div>";
    }
}
?>