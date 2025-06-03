<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Http;

class VerifyFirebaseData extends Command
{
    protected $signature = 'firebase:verify';
    protected $description = 'Verify migrated data in Firebase Firestore';

    public function handle()
    {
        $this->info('🔍 Verifying Firebase data...');
        $this->newLine();

        $firebase = app(FirebaseService::class);

        if (!$firebase->isInitialized()) {
            $this->error('❌ Firebase not initialized');
            return 1;
        }

        $collections = ['projects', 'skills', 'education', 'messages', 'users'];

        foreach ($collections as $collection) {
            $this->info("📋 Checking {$collection} collection...");
            
            try {
                // Try to list all documents in the collection
                $url = "https://firestore.googleapis.com/v1/projects/reda-yahyani-portfolio/databases/(default)/documents/{$collection}";
                
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->getAccessToken($firebase),
                    'Content-Type' => 'application/json',
                ])->get($url);

                if ($response->successful()) {
                    $data = $response->json();
                    $documents = $data['documents'] ?? [];
                    
                    $this->info("✅ Found " . count($documents) . " documents in {$collection}");
                    
                    if (count($documents) > 0) {
                        // Show first document details
                        $firstDoc = $documents[0];
                        $docId = basename($firstDoc['name']);
                        $this->info("   First document ID: {$docId}");
                        
                        // Show some fields
                        if (isset($firstDoc['fields'])) {
                            $fields = array_keys($firstDoc['fields']);
                            $this->info("   Fields: " . implode(', ', array_slice($fields, 0, 5)));
                        }
                    }
                } else {
                    $this->warn("⚠️  Could not fetch {$collection}: " . $response->body());
                }
                
            } catch (\Exception $e) {
                $this->error("❌ Error checking {$collection}: " . $e->getMessage());
            }
            
            $this->newLine();
        }
        
        return 0;
    }
    
    private function getAccessToken($firebase)
    {
        // Access the protected accessToken property via reflection
        $reflection = new \ReflectionClass($firebase);
        $property = $reflection->getProperty('accessToken');
        $property->setAccessible(true);
        return $property->getValue($firebase);
    }
} 