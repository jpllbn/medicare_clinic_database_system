<?php
/**
 * Reusable Head Component
 * Accepts title parameter for page-specific titles
 */
$pageTitle = $pageTitle ?? 'Medicare Clinic Database System';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES); ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php 
        // Calculate relative path to includes directory
        $currentDir = dirname($_SERVER['PHP_SELF']);
        if (strpos($currentDir, 'php/pages') !== false || strpos($currentDir, 'php/authentication') !== false) {
            echo '../../includes/style.css';
        } else {
            echo '../includes/style.css';
        }
    ?>" />
</head>
