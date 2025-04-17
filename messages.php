<?php
    $formconfig = require_once './src/config.php';
    require_once './src/DataLogger.php';

    // Get log file path from config
    $logFilePath = $formconfig['form']['log_file'];

    // Read messages from log file
    $messages = [];
    if (file_exists($logFilePath)) {
        $logContents = file_get_contents($logFilePath);
        $entries     = explode("\n", $logContents);

        foreach ($entries as $entry) {
            if (! empty(trim($entry))) {
                $messages[] = json_decode($entry, true);
            }
        }
    }

    // Reverse array to show newest messages first
    $messages = array_reverse($messages);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message History</title>
    <link rel="stylesheet" href="/os/php/public/assets/css/messages.css">
    <link rel="stylesheet" href="/os/php/public/assets/css/style.css">

</head>
<body>
    <header>
        <a href="index.php" class="back-link">Home</a>
        <a href="index.php?contact=1">Contact Form</a>
        <h1 class="title">Message History</h1>
    </header>

    <main class="message-list">
        <?php if (empty($messages)): ?>
            <div class="empty-message">No messages found.</div>
        <?php else: ?>
<?php foreach ($messages as $message): ?>
                <div class="message-item">
                    <div class="message-header">
                        <div class="sender-info">
                            <strong><?php echo htmlspecialchars($message['name'] ?? 'Unknown'); ?></strong>
                            &lt;<?php echo htmlspecialchars($message['email'] ?? 'No email'); ?>&gt;
                        </div>
                        <div class="timestamp">
                            <?php echo htmlspecialchars($message['timestamp'] ?? 'No date'); ?>
                        </div>
                    </div>
                    <div class="message-body">
                        <?php echo nl2br(htmlspecialchars($message['message'] ?? 'No message')); ?>
                    </div>
                </div>
            <?php endforeach; ?>
<?php endif; ?>
    </main>
</body>
</html>