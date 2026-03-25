<?php
declare(strict_types=1);

class FileUpload
{
    public static function uploadImage(array $file, string &$error = null): ?string
    {
        return self::upload(
            $file,
            ['jpg', 'jpeg', 'png', 'webp'],
            ['image/jpeg', 'image/pjpeg', 'image/png', 'image/webp'],
            2 * 1024 * 1024,
            'images',
            $error
        );
    }

    public static function uploadPdf(array $file, string &$error = null): ?string
    {
        return self::upload(
            $file,
            ['pdf'],
            ['application/pdf', 'application/x-pdf'],
            5 * 1024 * 1024,
            'pdf',
            $error
        );
    }

    private static function upload(array $file, array $allowedExtensions, array $allowedMimes, int $maxBytes, string $subFolder, ?string &$error): ?string
    {
        if (!isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = 'File upload failed.';
            return null;
        }

        if (($file['size'] ?? 0) > $maxBytes) {
            $error = 'File is too large.';
            return null;
        }

        $originalName = $file['name'] ?? '';
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedExtensions, true)) {
            $error = 'Invalid file type.';
            return null;
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            $error = 'Unsafe upload detected.';
            return null;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo === false) {
            $error = 'Unable to inspect uploaded file.';
            return null;
        }
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if ($mimeType === false || !in_array(strtolower($mimeType), $allowedMimes, true)) {
            $error = 'Invalid file content.';
            return null;
        }

        $targetDir = rtrim(UPLOAD_ABS_PATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $subFolder . DIRECTORY_SEPARATOR;
        if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            $error = 'Cannot create upload directory.';
            return null;
        }

        $safeName = $subFolder . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
        $destination = $targetDir . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $error = 'Unable to save uploaded file.';
            return null;
        }

        return UPLOAD_DIR . $subFolder . '/' . $safeName;
    }
}
