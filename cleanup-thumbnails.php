<?php
/**
 * Automated batch cleanup of deleted thumbnail sizes from attachment metadata.
 * Continuously refreshes until finished.
 */

require_once('wp-load.php');

// Thumbnail sizes you deleted
$sizes_to_remove = [
    '1024x1024','1080x1080','1080x675','1280x1280','1536x1536',
    '1920x1800','400x250','400x284','400x516','480x480','510x382',
    '768x768','980x980'
];

// Batch size
$batch_size = isset($_GET['batch']) ? intval($_GET['batch']) : 500;

// Track progress via a transient
$offset = get_transient('cleanup_thumb_offset');
if ($offset === false) $offset = 0;

// Fetch attachments
$attachments = get_posts([
    'post_type'      => 'attachment',
    'posts_per_page' => $batch_size,
    'offset'         => $offset,
    'fields'         => 'ids',
    'orderby'        => 'ID',
    'order'          => 'ASC',
]);

if (empty($attachments)) {
    delete_transient('cleanup_thumb_offset');
    echo "<h2>🎉 Cleanup complete!</h2>";
    exit;
}

$processed = 0;

foreach ($attachments as $id) {
    $meta = wp_get_attachment_metadata($id);

    if (!$meta || empty($meta['sizes'])) {
        $processed++;
        continue;
    }

    $changed = false;
    foreach ($sizes_to_remove as $size) {
        if (isset($meta['sizes'][$size])) {
            unset($meta['sizes'][$size]);
            $changed = true;
        }
    }

    if ($changed) {
        wp_update_attachment_metadata($id, $meta);
    }

    $processed++;
}

// Update offset for the next batch
$offset += $batch_size;
set_transient('cleanup_thumb_offset', $offset, 12 * HOUR_IN_SECONDS);

// Output progress
echo "<p>Processed $processed attachments.<br>Next offset: $offset</p>";

// Auto-refresh after 2 seconds
echo "
<script>
setTimeout(function() {
    window.location.reload();
}, 2000);
</script>
";
