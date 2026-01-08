<?php

namespace App\Livewire\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

trait HandleFileUpload
{
    /**
     * Upload and process animal image
     *
     * @param mixed $uploadedFile The uploaded file
     * @param string $animalId The animal ID
     * @return array|null Array with filename key or null on failure
     */
    public function uploadAnimalImage($uploadedFile, $animalId): ?array
    {
        if (! $uploadedFile) return null;

        try {
            $config = config('image.animals');
            $disk = $config['disk'];

            // Generate a unique file name
            $filename = $this->generateImageFilename($animalId);

            // Read the uploaded image (InterventionImage)
            $image = Image::read($uploadedFile->getRealPath());

            // Store original image
            $originalPath = $config['original']['path'] . '/' . $filename . '.' . $config['original']['format'];
            Storage::disk($disk)->put(
                $originalPath,
                $image->toWebp($config['original']['quality'])
            );

            // Create and store variants
            foreach ($config['variants'] as $variantConfig) {
                $resized = clone $image;

                $resized->scale(
                    width: $variantConfig['width'],
                    height: $variantConfig['height']
                );

                $variantPath = $variantConfig['path'] . '/' . $filename . '.' . $variantConfig['format'];
                Storage::disk($disk)->put(
                    $variantPath,
                    $resized->toWebp($variantConfig['quality'])
                );
            }
            return ['filename' => $filename];
        } catch (\Exception $exception) {
            \Log::error("Image Upload Error: " . $exception->getMessage());
            return null;
        }
    }

    /**
     * Delete a specific image from an animal
     *
     * @param string|null $filename The file name
     * @return bool
     */
    public function deleteAnimalImage(?string $filename): bool
    {
        if (! $filename) {
            return true;
        }

        $config = config('image.animals');
        $disk = $config['disk'];

        // Delete the original picture
        Storage::disk($disk)->delete($config['original']['path'] . '/' . $filename . '.' . $config['original']['format']);

        // Delete the variants
        foreach ($config['variants'] as $variantConfig) {
            Storage::disk($disk)->delete($variantConfig['path'] . '/' . $filename . '.' . $variantConfig['format']);
        }

        return true;
    }

    /**
     * Delete all images of an animal
     *
     * @param array|null $pictures Array of pictures
     * @return bool
     */
    public function deleteAllAnimalImages(?array $pictures): bool
    {
        if (! $pictures || empty($pictures)) {
            return true;
        }

        foreach ($pictures as $picture) {
            $this->deleteAnimalImage($picture['filename'] ?? null);
        }

        return true;
    }

    /**
     * Generate a random file name
     *
     * @param string $animalId The animal ID
     * @return string
     */
    private function generateImageFilename($animalId): string
    {
        return $animalId . '_' . time() . '_' . uniqid();
    }
}
