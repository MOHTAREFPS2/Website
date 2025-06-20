<?php
// هذا السطر يبدأ الجلسة ويسمح بتعيين متغيرات الجلسة.
// يجب أن يكون هذا السطر هو الأول في الملف، بدون أي مسافات أو أسطر قبله.
session_start();

// تعيين متغير الجلسة الذي يشير إلى أن المستخدم مسموح له بالتحميل.
// يتم تعيين هذا المتغير فقط عندما يصل المستخدم إلى هذه الصفحة (بعد تجاوز Shrink.io).
$_SESSION['can_download'] = true;
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة التحميل</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            margin-top: 80px;
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }
        h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 30px;
        }
        .download-btn {
            background-color: #28a745; /* لون أخضر جذاب */
            border: none;
            color: white;
            padding: 18px 38px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 1.2em;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .download-btn:hover {
            background-color: #218838; /* لون أخضر أغمق عند التمرير */
            transform: translateY(-2px);
        }
        .download-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            box-shadow: none;
        }
    </style>
</head>
<body>
    <h1>شكراً لك!</h1>
    <p>لقد اجتزت الخطوات بنجاح. ملفك جاهز للتحميل الآن.</p>
    <button id="startDownload" class="download-btn">بدء التحميل</button>

    <script>
        document.getElementById('startDownload').addEventListener('click', function() {
            // هذا هو الجزء الأهم: يتم توجيه المستخدم إلى سكريبت الـ proxy
            // الذي سيقوم بجلب الملف من Google Drive.
            // معرف الملف الخاص بك من Google Drive: 1076PABoP6L7QUZiAvi2kkJs20hieP5Z2
            window.location.href = 'download_proxy.php?file_id=1076PABoP6L7QUZiAvi2kkJs20hieP5Z2';

            // تعطيل الزر بعد النقر لمنع التحميل المتعدد وتوضيح أن العملية بدأت
            this.disabled = true;
            this.textContent = 'التحميل جاري... يرجى الانتظار';
        });
    </script>
</body>
</html>
