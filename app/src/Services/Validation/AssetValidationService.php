<?php

namespace Services\Validation;

class AssetValidationService
{
    /**
     * @return array{ 0: array<string, string>, 1: array{
     * name: string, 
     * info: string,
     * description: string,
     * price: int,
     * engine_version: string,
     * category_id: int,
     * } }
     * @param array<int,mixed> $images
     */
    public function validate(
        string $name,
        string $info,
        string $description,
        string $price,
        string $engine_version,
        string $category_id,
        array $images
    ): array {
        $vname = htmlspecialchars(trim($name));
        $vinfo = htmlspecialchars(trim($info));
        $vdescription = htmlspecialchars(trim($description));
        $vprice = intval($price);
        $vengine_version = htmlspecialchars(trim($engine_version));
        $vcategory_id = intval($category_id);

        $errors = [];

        if (empty($vname)) {
            $errors['name'] = 'Name is required';
        }
        if (empty($vinfo)) {
            $errors['info'] = 'Info is required';
        }
        if (empty($vdescription)) {
            $errors['description'] = 'Description is required';
        }

        if (empty($images)) {
            $errors['images'] = 'Images are required';
        } else {
            $imagesErrors = $this->checkImages($images);
            if ($imagesErrors) {
                $errors['images'] = $imagesErrors;
            }
        }

        return [$errors, [
        'name' => $vname,
        'info' => $vinfo,
        'description' => $vdescription,
        'price' => $vprice,
        'engine_version' => $vengine_version,
        'category_id' => $vcategory_id
        ]
        ];
    }

    /**
     * @return array{ 0: array<string, string>, 1: array{
     * name: string, 
     * info: string,
     * description: string,
     * price: int,
     * engine_version: string,
     * category_id: int,
     * } }
     */
    public function validateUpdate(
        string $name,
        string $info,
        string $description,
        string $price,
        string $engine_version,
        string $category_id,
    ): array {
        $vname = htmlspecialchars(trim($name));
        $vinfo = htmlspecialchars(trim($info));
        $vdescription = htmlspecialchars(trim($description));
        $vprice = intval($price);
        $vengine_version = htmlspecialchars(trim($engine_version));
        $vcategory_id = intval($category_id);

        $errors = [];

        if (empty($vname)) {
            $errors['name'] = 'Name is required';
        }
        if (empty($vinfo)) {
            $errors['info'] = 'Info is required';
        }
        if (empty($vdescription)) {
            $errors['description'] = 'Description is required';
        }

        return [$errors, [
        'name' => $vname,
        'info' => $vinfo,
        'description' => $vdescription,
        'price' => $vprice,
        'engine_version' => $vengine_version,
        'category_id' => $vcategory_id
        ]
        ];
    }


    /**
     * @return array<string, string>
     * @param array<int,mixed> $images
     */
    public function validateImages(array $images): array
    {
        $errors = [];
        if (empty($images)) {
            $errors['images'] = 'Images are required';
        } else {
            $imagesErrors = $this->checkImages($images);
            if ($imagesErrors) {
                $errors['images'] = $imagesErrors;
            }
        }
        return $errors;
    }

    /**
     * @return array{ 0: array<string, string>, 1: array{ image_id: int } }
     */
    public function validatePreviewImage(int $image_id): array
    {
        $vimage_id = intval($image_id);

        $errors = [];
        if ($vimage_id === 0) {
            $errors['image_id'] = 'Image id is required';
        }

        return [$errors, ['image_id' => $vimage_id]];
    }

    /**
     * @return array{ 0: array<string, string>, 1: array{
     * image_id: int,
     * image_order: int,
     * image_name: string,
     * tmp_name: string,
     * old_image_path: string,
     * } }
     */
    public function validateUpdateImage(
        int $image_id,
        int $image_order,
        string $image_name,
        string $tmp_name,
        string $old_image_path,
    ): array {
        $vimage_id = intval($image_id);
        $vimage_order = intval($image_order);
        $vimage_name = htmlspecialchars(trim($image_name));
        $vtmp_name = htmlspecialchars(trim($tmp_name));
        $vold_image_path = htmlspecialchars(trim($old_image_path));


        $errors = [];

        if ($vimage_id === 0) {
            $errors['image_id'] = 'Image id is required';
        }
        
        if ($vimage_order === 0) {
            $errors['image_order'] = 'Image order is required';
        }

        if (empty($vold_image_path)) {
            $errors['old_image_path'] = 'Old image path is required';
        }

        if (empty($vimage_name) || empty($vtmp_name)) {
            $errors['image'] = 'Image is required for updating';
        } else {
            $imagesErrors = $this->checkImages(['name'=>[$vimage_name]]);
            if ($imagesErrors) {
                $errors['image'] = $imagesErrors;
            }
        }

        return [$errors, [
        'image_id' => $vimage_id,
        'image_order' => $vimage_order,
        'image_name' => $vimage_name,
        'tmp_name' => $vtmp_name,
        'old_image_path' => $vold_image_path
        ]
        ];

    }
    /**
     * @return array{ 0: array<string, string>, 1: array{
     * name: string, 
     * version: string,
     * description: string,
     * file_name: string,
     * path: string,
     * } }
     */
    public function validateFile(string $name, string $version, string $description, string $file_name, string $path): array
    {
        $vname = htmlspecialchars(trim($name));
        $vversion = htmlspecialchars(trim($version));
        $vdescription = htmlspecialchars(trim($description));
        $vfile_name = htmlspecialchars(trim($file_name));
        $vpath = htmlspecialchars(trim($path));

        $errors = [];

        if (empty($vname)) {
            $errors['name'] = 'Name is required';
        }
        if (empty($vversion)) {
            $errors['version'] = 'Version is required';
        }
        if (empty($vdescription)) {
            $errors['description'] = 'Description is required';
        }

        if (empty($vfile_name)) {
            $errors['file'] = 'File is required';
        } else {
            $fileErrors = $this->checkFile($vfile_name);
            if ($fileErrors) {
                $errors['file'] = $fileErrors;
            }
        }
        if (empty($vpath)) {
            $errors['path'] = 'Path is required';
        }
        return [$errors, [
        'name' => $vname,
        'version' => $vversion,
        'description' => $vdescription,
        'file_name' => $vfile_name,
        'path' => $vpath
        ]
        ];
    }
    /**
     * @return array{ 0: array<string, string>, 1: array{
     * name: string, 
     * version: string,
     * description: string,
     * file_name: string,
     * path: string,
     * old_path: string,
     * } }
     */
    public function validateUpdateFile(
        string $name,
        string $version,
        string $description,
        string $file_name,
        string $path,
        string $old_path,
    ): array {
        $vname = htmlspecialchars(trim($name));
        $vversion = htmlspecialchars(trim($version));
        $vdescription = htmlspecialchars(trim($description));
        $vfile_name = htmlspecialchars(trim($file_name));
        $vpath = htmlspecialchars(trim($path));
        $vold_path = htmlspecialchars(trim($old_path));


        $errors = [];

        
        if (empty($vname)) {
            $errors['name'] = 'Name is required';
        }
        if (empty($vversion)) {
            $errors['version'] = 'Version is required';
        }
        if (empty($vdescription)) {
            $errors['description'] = 'Description is required';
        }

        if (empty($vfile_name)) {
            $errors['file'] = 'File is required';
        } else {
            $fileErrors = $this->checkFile($vfile_name);
            if ($fileErrors) {
                $errors['file'] = $fileErrors;
            }
        }
        
        if (empty($vpath)) {
            $errors['path'] = 'Path is required';
        }
        if (empty($vold_path)) {
            $errors['old_path'] = 'Old path is required';
        }


        return [$errors, [
        'name' => $vname,
        'version' => $vversion,
        'description' => $vdescription,
        'file_name' => $vfile_name,
        'path' => $vpath,
        'old_path' => $vold_path
        ]
        ];
    }

    private function checkFile(string $file_name): ?string
    {
        $allowed = [
        '.zip',
        '.rar',
        '.7z',
        '.tar',
        '.gz',
        '.bz2',
        '.xz',
        '.txt',
        '.doc',
        '.docx',
        '.xls',
        '.xlsx',
        '.ppt',
        '.pptx',
        '.pdf',
        ];
        preg_match('/(\.\w*)$/', $file_name, $matches);
        $ext = $matches[0] ?? '';
        if (empty($ext) || !in_array($ext, $allowed)) {
            return "Error loading file: " . $file_name . " - invalid file type";
        }
        return null;
    }
    /**
     * @param array{ name: string[] } $images
     */
    private function checkImages(array $images): ?string
    {
        $allowed = ['.jpg', '.jpeg', '.png', '.gif'];
        $imagesErrors = [];
        foreach ($images['name'] as $name) {
            preg_match('/(\.\w*)$/', $name, $matches);
            $ext = $matches[0] ?? '';
            if (empty($ext) || !in_array($ext, $allowed)) {
                $imagesErrors[] = "Error loading image: " . $name;
            }
        }
        if ($imagesErrors) {
              $result =  implode(', ', $imagesErrors);
              $result .= PHP_EOL .'Only ' . implode(', ', $allowed) . ' files are allowed';
              return $result;
        }
        return null;
    }
}
