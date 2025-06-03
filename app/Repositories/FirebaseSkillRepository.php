<?php

namespace App\Repositories;

use App\Services\FirebaseService;
use Carbon\Carbon;

class FirebaseSkillRepository
{
    private FirebaseService $firebase;
    private string $collection = 'skills';

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Get all visible skills
     */
    public function getAllVisible(): array
    {
        return $this->firebase->getAllOrdered($this->collection, 'name', 'asc', [
            ['is_visible', '==', true]
        ]);
    }

    /**
     * Get all skills (including hidden)
     */
    public function getAll(): array
    {
        return $this->firebase->getAllOrdered($this->collection, 'name', 'asc');
    }

    /**
     * Get skills by level
     */
    public function getByLevel(string $level): array
    {
        return $this->firebase->getAll($this->collection, [
            ['level', '==', $level],
            ['is_visible', '==', true]
        ]);
    }

    /**
     * Get a skill by ID
     */
    public function find(string $id): ?array
    {
        return $this->firebase->get($this->collection, $id);
    }

    /**
     * Create a new skill
     */
    public function create(array $data): string
    {
        $skillData = [
            'name' => $data['name'],
            'level' => $data['level'],
            'is_visible' => $data['is_visible'] ?? true,
            'created_at' => Carbon::now()->toISOString(),
            'updated_at' => Carbon::now()->toISOString(),
        ];

        $docRef = $this->firebase->add($this->collection, $skillData);
        return $docRef->id();
    }

    /**
     * Update a skill
     */
    public function update(string $id, array $data): void
    {
        $updateData = array_filter([
            'name' => $data['name'] ?? null,
            'level' => $data['level'] ?? null,
            'is_visible' => $data['is_visible'] ?? null,
            'updated_at' => Carbon::now()->toISOString(),
        ], fn($value) => $value !== null);

        $this->firebase->update($this->collection, $id, $updateData);
    }

    /**
     * Delete a skill
     */
    public function delete(string $id): void
    {
        $this->firebase->delete($this->collection, $id);
    }

    /**
     * Search skills by name
     */
    public function searchByName(string $name): array
    {
        // Note: Firestore doesn't support text search, so this is a simple equality check
        // For more advanced search, you might want to use Algolia or similar
        return $this->firebase->search($this->collection, 'name', $name);
    }
} 