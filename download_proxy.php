<?php
session_start();

// 1. تحقق من المصدر (للتأكد من أن المستخدم قد أتى من صفحتك الوسيطة)
//    يجب تعيين $_SESSION['can_download'] = true; في download_page.php
//    مثال: أضف هذا السطر في بداية ملف download_page.php (قبل أي مخرجات HTML):
//    <?php session_start(); $_SESSION['can_download'] = true; ? >
if (!isset($_SESSION['can_download']) || $_SESSION['can_download'] !== true) {
    header("Location: download_page.html"); // إعادة توجيه للصفحة الوسيطة
    exit();
}

// 2. تحديد ID الملف من Google Drive بشكل ثابت أو ديناميكي
//    بما أنك أرسلت لي رابطًا محددًا، سنستخدم ID الملف الخاص به مباشرةً.
//    معرف الملف هو جزء "id=" من الرابط: 1076PABoP6L7QUZiAvi2kkJs20hieP5Z2
$google_drive_file_id = "1076PABoP6L7QUZiAvi2kkJs20hieP5Z2"; // هذا هو ID الملف الذي أرسلته

// 3. بناء رابط التحميل المباشر لـ Google Drive
$google_drive_url = "https://drive.google.com/uc?export=download&id=" . $google_drive_file_id;

// 4. استخدام cURL لجلب الملف من Google Drive
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $google_drive_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_ENCODING, "");
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36");

// قم بتعطيل عرض الأخطاء إلى المتصفح لتجنب كشف المسارات أو معلومات حساسة
ini_set('display_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);

// 5. تهيئة الرؤوس لتقديم الملف للمستخدم
//    يمكنك تغيير هذا الاسم ليعكس اسم ملفك الحقيقي.
$file_name = "your_document_name.zip"; // **هنا ضع الاسم الذي تريده أن يظهر للمستخدم**

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

// 6. بث الملف مباشرة إلى المتصفح
curl_exec($ch);

// التحقق من الأخطاء (اختياري، يفضل تسجيلها بدلاً من عرضها للمستخدم)
if (curl_errno($ch)) {
    error_log("cURL Error: " . curl_error($ch));
    http_response_code(500);
    echo "حدث خطأ أثناء التحميل. يرجى المحاولة مرة أخرى لاحقاً.";
}

curl_close($ch);

// 7. إزالة إذن التحميل بعد الانتهاء
unset($_SESSION['can_download']);

exit();
?>
	