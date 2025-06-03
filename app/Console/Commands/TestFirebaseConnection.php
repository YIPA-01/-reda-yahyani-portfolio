<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirebaseService;
use Exception;

class TestFirebaseConnection extends Command
{
    protected $signature = 'firebase:test';
    protected $description = 'Test Firebase connection and configuration';

    public function handle()
    {
        $this->info('🔥 Testing Firebase Connection...');
        $this->newLine();

        // Check credentials file
        $credentialsPath = storage_path('app/firebase-credentials.json');
        if (!file_exists($credentialsPath)) {
            $this->error('❌ Credentials file not found at: ' . $credentialsPath);
            $this->info('Please download your Firebase service account key and place it there.');
            return 1;
        }

        $this->info('✅ Credentials file found: ' . $credentialsPath);
        $this->info('   File size: ' . number_format(filesize($credentialsPath)) . ' bytes');

        // Check if file is valid JSON
        try {
            $credentialsContent = file_get_contents($credentialsPath);
            $credentials = json_decode($credentialsContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('❌ Invalid JSON in credentials file: ' . json_last_error_msg());
                return 1;
            }

            $this->info('✅ Valid JSON credentials file');
            $this->info('   Project ID: ' . ($credentials['project_id'] ?? 'Not found'));
            $this->info('   Client Email: ' . ($credentials['client_email'] ?? 'Not found'));
        } catch (Exception $e) {
            $this->error('❌ Error reading credentials file: ' . $e->getMessage());
            return 1;
        }

        // Check environment variables
        $envProjectId = env('FIREBASE_PROJECT_ID');
        $envCredentialsPath = env('FIREBASE_CREDENTIALS_PATH');
        
        $this->info('✅ Environment variables:');
        $this->info('   FIREBASE_PROJECT_ID: ' . ($envProjectId ?: 'Not set'));
        $this->info('   FIREBASE_CREDENTIALS_PATH: ' . ($envCredentialsPath ?: 'Not set'));

        // Check if project IDs match
        if (isset($credentials['project_id']) && $envProjectId && $credentials['project_id'] !== $envProjectId) {
            $this->warn('⚠️  Project ID mismatch!');
            $this->warn('   Credentials file: ' . $credentials['project_id']);
            $this->warn('   Environment: ' . $envProjectId);
        }

        // Test Firebase service initialization
        try {
            $this->info('🔄 Testing Firebase service initialization...');
            
            $firebaseService = app(FirebaseService::class);
            
            if (!$firebaseService->isInitialized()) {
                $this->error('❌ Firebase service is not initialized');
                $this->newLine();
                $this->info('Troubleshooting steps:');
                $this->info('1. Check that FIREBASE_PROJECT_ID in .env matches the project_id in credentials file');
                $this->info('2. Verify the service account key file is valid');
                $this->info('3. Ensure the Firebase project exists and Firestore is enabled');
                return 1;
            }

            $this->info('✅ Firebase service initialized successfully');

            // Test Firestore connection
            $this->info('🔄 Testing Firestore connection...');
            
            $testCollection = $firebaseService->collection('test');
            $this->info('✅ Successfully connected to Firestore');

            // Try to get a document (this will work even if collection doesn't exist)
            $testDoc = $firebaseService->document('test', 'test-doc');
            $this->info('✅ Successfully created document reference');

            $this->newLine();
            $this->info('🎉 All Firebase tests passed!');
            $this->info('Your Firebase configuration is working correctly.');
            $this->newLine();
            $this->info('Next steps:');
            $this->info('• Run migration with dry-run: php artisan migrate:firebase --dry-run');
            $this->info('• Run actual migration: php artisan migrate:firebase --table=all');

            return 0;

        } catch (Exception $e) {
            $this->error('❌ Firebase initialization failed: ' . $e->getMessage());
            $this->newLine();
            $this->info('Debug information:');
            $this->info('Error type: ' . get_class($e));
            if ($e->getCode()) {
                $this->info('Error code: ' . $e->getCode());
            }
            $this->newLine();
            $this->info('Troubleshooting steps:');
            $this->info('1. Verify your internet connection');
            $this->info('2. Check Firebase project permissions');
            $this->info('3. Ensure Firestore is enabled in Firebase Console');
            $this->info('4. Verify the service account has the correct roles');
            return 1;
        }
    }
} 