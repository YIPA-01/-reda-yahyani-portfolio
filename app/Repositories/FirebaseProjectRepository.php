<?php

namespace App\Repositories;

use App\Services\FirebaseService;
use Carbon\Carbon;

class FirebaseProjectRepository
{
    private FirebaseService $firebase;
    private string $collection = 'projects';

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Get all visible projects
     */
    public function getAllVisible(): array
    {
        return $this->firebase->getAll($this->collection, [
            ['is_visible', '==', true]
        ]);
    }

    /**
     * Get all projects (including hidden)
     */
    public function getAll(): array
    {
        return $this->firebase->getAllOrdered($this->collection, 'created_at', 'desc');
    }

    /**
     * Get a project by ID
     */
    public function find(string $id): ?array
    {
        return $this->firebase->get($this->collection, $id);
    }

    /**
     * Create a new project
     */
    public function create(array $data): string
    {
        $projectData = [
            'title' => $data['title'],
            'description' => $data['description'],
            'technologies' => $data['technologies'] ?? [],
            'is_visible' => $data['is_visible'] ?? true,
            'images' => $data['images'] ?? [],
            'main_image_url' => $data['main_image_url'] ?? null,
            'created_at' => Carbon::now()->toISOString(),
            'updated_at' => Carbon::now()->toISOString(),
        ];

        $docRef = $this->firebase->add($this->collection, $projectData);
        return $docRef->id();
    }

    /**
     * Update a project
     */
    public function update(string $id, array $data): void
    {
        $updateData = array_filter([
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'technologies' => $data['technologies'] ?? null,
            'is_visible' => $data['is_visible'] ?? null,
            'images' => $data['images'] ?? null,
            'main_image_url' => $data['main_image_url'] ?? null,
            'updated_at' => Carbon::now()->toISOString(),
        ], fn($value) => $value !== null);

        $this->firebase->update($this->collection, $id, $updateData);
    }

    /**
     * Delete a project
     */
    public function delete(string $id): void
    {
        $this->firebase->delete($this->collection, $id);
    }

    /**
     * Search projects by technology
     */
    public function searchByTechnology(string $technology): array
    {
        return $this->firebase->getAll($this->collection, [
            ['technologies', 'array-contains', $technology],
            ['is_visible', '==', true]
        ]);
    }

    /**
     * Add image to project
     */
    public function addImage(string $projectId, string $imageUrl): void
    {
        $project = $this->find($projectId);
        if ($project) {
            $images = $project['images'] ?? [];
            $images[] = $imageUrl;
            
            $updateData = [
                'images' => $images,
                'updated_at' => Carbon::now()->toISOString()
            ];

            // Set as main image if it's the first image
            if (count($images) === 1 && empty($project['main_image_url'])) {
                $updateData['main_image_url'] = $imageUrl;
            }

            $this->firebase->update($this->collection, $projectId, $updateData);
        }
    }

    /**
     * Remove image from project
     */
    public function removeImage(string $projectId, string $imageUrl): void
    {
        $project = $this->find($projectId);
        if ($project) {
            $images = $project['images'] ?? [];
            $images = array_filter($images, fn($img) => $img !== $imageUrl);
            
            $updateData = [
                'images' => array_values($images),
                'updated_at' => Carbon::now()->toISOString()
            ];

            // Update main image if it was removed
            if ($project['main_image_url'] === $imageUrl) {
                $updateData['main_image_url'] = !empty($images) ? $images[0] : null;
            }

            $this->firebase->update($this->collection, $projectId, $updateData);
        }
    }

    /**
     * Set main image for project
     */
    public function setMainImage(string $projectId, string $imageUrl): void
    {
        $this->firebase->update($this->collection, $projectId, [
            'main_image_url' => $imageUrl,
            'updated_at' => Carbon::now()->toISOString()
        ]);
    }
} 