<?php

namespace App\Repositories;

use App\Services\FirebaseService;
use Carbon\Carbon;

class FirebaseEducationRepository
{
    private FirebaseService $firebase;
    private string $collection = 'education';

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Get all visible education records
     */
    public function getAllVisible(): array
    {
        return $this->firebase->getAllOrdered($this->collection, 'start_date', 'desc', [
            ['is_visible', '==', true]
        ]);
    }

    /**
     * Get all education records (including hidden)
     */
    public function getAll(): array
    {
        return $this->firebase->getAllOrdered($this->collection, 'start_date', 'desc');
    }

    /**
     * Get an education record by ID
     */
    public function find(string $id): ?array
    {
        return $this->firebase->get($this->collection, $id);
    }

    /**
     * Create a new education record
     */
    public function create(array $data): string
    {
        $educationData = [
            'school' => $data['school'],
            'degree' => $data['degree'],
            'field' => $data['field'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'description' => $data['description'] ?? null,
            'is_visible' => $data['is_visible'] ?? true,
            'created_at' => Carbon::now()->toISOString(),
            'updated_at' => Carbon::now()->toISOString(),
        ];

        $docRef = $this->firebase->add($this->collection, $educationData);
        return $docRef->id();
    }

    /**
     * Update an education record
     */
    public function update(string $id, array $data): void
    {
        $updateData = array_filter([
            'school' => $data['school'] ?? null,
            'degree' => $data['degree'] ?? null,
            'field' => $data['field'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'description' => $data['description'] ?? null,
            'is_visible' => $data['is_visible'] ?? null,
            'updated_at' => Carbon::now()->toISOString(),
        ], fn($value) => $value !== null);

        $this->firebase->update($this->collection, $id, $updateData);
    }

    /**
     * Delete an education record
     */
    public function delete(string $id): void
    {
        $this->firebase->delete($this->collection, $id);
    }

    /**
     * Get education records by school
     */
    public function getBySchool(string $school): array
    {
        return $this->firebase->getAll($this->collection, [
            ['school', '==', $school],
            ['is_visible', '==', true]
        ]);
    }

    /**
     * Get education records by degree
     */
    public function getByDegree(string $degree): array
    {
        return $this->firebase->getAll($this->collection, [
            ['degree', '==', $degree],
            ['is_visible', '==', true]
        ]);
    }

    /**
     * Get current education (where end_date is null or in the future)
     */
    public function getCurrent(): array
    {
        $currentDate = Carbon::now()->toDateString();
        
        // Note: Firestore queries have limitations, so we'll get all and filter in PHP
        $allEducation = $this->getAllVisible();
        
        return array_filter($allEducation, function($education) use ($currentDate) {
            return empty($education['end_date']) || $education['end_date'] >= $currentDate;
        });
    }
} 