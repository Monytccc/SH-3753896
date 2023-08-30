<!DOCTYPE html>
<html>
<head>
    <title>Drakness</title>
</head>
<body>

<?php
$botToken = '6646722281:AAFqkRpaD2-BboyS3hCFuOd4bYZ92oLF4k0';
$groupChatId = '-1001695398687';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $files = $_FILES['file'];

    foreach ($files['tmp_name'] as $index => $tmpName) {
        $fileData = [
            'chat_id' => $groupChatId,
            'document' => new CURLFile($tmpName, $files['type'][$index], $files['name'][$index]),
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$botToken/sendDocument");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        curl_close($ch);
    }
}
?>


<style>
    body {
      color: white;
      background: black;
    }
        #dropArea {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
        }
    </style>
<div id="dropArea">
    <p>Drag and drop files here or click to select files.</p>
    <input type="file" name="file" id="file" multiple accept="*">
</div>

<!-- Add this script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('file');
    
    // Prevent default behavior when files are dragged over the drop area
    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.style.border = '2px dashed blue';
    });

    // Restore border when dragged files leave the drop area
    dropArea.addEventListener('dragleave', () => {
        dropArea.style.border = '2px dashed #ccc';
    });

    // Handle dropped files
    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.style.border = '2px dashed #ccc';

        const form = new FormData();

        for (const file of e.dataTransfer.files) {
            form.append('file[]', file);
        }

        uploadFiles(form);
    });

    // Handle file selection via input field
    fileInput.addEventListener('change', (e) => {
        const form = new FormData();

        for (const file of fileInput.files) {
            form.append('file[]', file);
        }

        uploadFiles(form);
    });

    function uploadFiles(form) {
        fetch('index.php', {
            method: 'POST',
            body: form
        })
        .then(response => response.text())
        .then(result => {
            if (result.includes("Success")) {
                alert("Successfully");
                location.reload();
            } else {
                alert("An error occurred. Please try again.");
            }
        })
        .catch(error => console.error('Error:', error));
    }
});
  </script>

</body>
</html>
