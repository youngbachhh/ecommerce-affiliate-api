<?php
    if (! function_exists('uploadFile')) {
        function uploadFile($nameFolder, $file)
        {
            $fileName = time() . '' . $file->getClientOriginalName();
            return $file->storeAS($nameFolder, $fileName, 'public');
        }
    }
?>
