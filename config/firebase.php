<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Project Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Firebase project credentials and settings.
    | You should add your Firebase service account key file to your project
    | and reference it here.
    |
    */

    'project_id' => env('FIREBASE_PROJECT_ID'),

    'credentials' => env('FIREBASE_CREDENTIALS_PATH', 'storage/app/firebase-credentials.json'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Database URL
    |--------------------------------------------------------------------------
    |
    | This is your Firebase Realtime Database URL. Only needed if you're
    | using the Realtime Database instead of Firestore.
    |
    */

    'database_url' => env('FIREBASE_DATABASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Storage Bucket
    |--------------------------------------------------------------------------
    |
    | This is your Firebase Storage bucket name for file uploads.
    |
    */

    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Auth Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Firebase Authentication if you plan to use it.
    |
    */

    'auth' => [
        'api_key' => env('FIREBASE_API_KEY'),
        'auth_domain' => env('FIREBASE_AUTH_DOMAIN'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure caching for Firebase operations to improve performance.
    |
    */

    'cache' => [
        'enabled' => env('FIREBASE_CACHE_ENABLED', true),
        'ttl' => env('FIREBASE_CACHE_TTL', 3600), // 1 hour
    ],

    // Force REST transport to avoid gRPC requirements
    'transport' => 'rest',

    // Firestore settings
    'firestore' => [
        'use_grpc' => false, // Force disable gRPC
    ],
]; 