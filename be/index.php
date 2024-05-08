<?php
require '../be/dbuser.php'; // Ensure the path is correct

function getRandomImage($dir, &$usedImages) {
    $files = array_diff(scandir($dir), array('.', '..'));
    $images = preg_grep('/\.(jpg|jpeg|png|gif)$/i', $files);
    $images = array_diff($images, $usedImages); // Remove already used images

    if (!empty($images)) {
        $keys = array_keys($images);
        $random_key = $keys[array_rand($keys)];
        $usedImages[] = $images[$random_key]; // Add to used images to avoid repetition
        return $dir . $images[$random_key];
    }
    return "default_image_path"; // Path to a default image
}

if (isset($_GET['action']) && $_GET['action'] == 'fetch_platters') {
    $sql = "SELECT platters, description FROM chefs WHERE IS_ACTIVE = 1 LIMIT 3";
    $result = $db->query($sql);
    $platters = [];
    $usedImages = [];
    foreach ($result as $row) {
        $platters[] = [
            'image' => getRandomImage('../assets/foodimg/', $usedImages),
            'platters' => $row['platters'],
            'description' => $row['description']
        ];
    }
    echo json_encode($platters);
    exit;
}
?>