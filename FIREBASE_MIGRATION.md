# Firebase Migration Guide

This guide will help you migrate your Laravel portfolio application from MySQL to Firebase Firestore.

## Prerequisites

1. **Firebase Project**: Create a new Firebase project at [Firebase Console](https://console.firebase.google.com/)
2. **Service Account Key**: Download the service account JSON file from Firebase Console
3. **PHP Dependencies**: The Firebase PHP SDK should be installed via Composer
4. **JavaScript Dependencies**: Firebase JavaScript SDK should be installed via npm

## Step 1: Firebase Project Setup

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Create a new project or select an existing one
3. Enable Firestore Database:
   - Go to "Firestore Database" → "Create database"
   - Choose "Start in test mode" (you can configure security rules later)
   - Select a location close to your users

4. Get your Firebase configuration:
   - Go to Project Settings (gear icon)
   - Scroll down to "Your apps" and click "Add app" → Web app
   - Copy the configuration object

5. Generate a service account key:
   - Go to Project Settings → Service Accounts
   - Click "Generate new private key"
   - Save the JSON file as `firebase-credentials.json` in your `storage/app/` directory

## Step 2: Install Dependencies

Run these commands in your project root:

```bash
# Install PHP Firebase SDK
composer require kreait/firebase-php

# Install JavaScript Firebase SDK
npm install firebase
```

## Step 3: Configure Environment Variables

Update your `.env` file with your Firebase configuration:

```env
# Firebase Configuration
FIREBASE_PROJECT_ID=your-actual-project-id
FIREBASE_CREDENTIALS_PATH=storage/app/firebase-credentials.json
FIREBASE_DATABASE_URL=https://your-project-id-default-rtdb.firebaseio.com
FIREBASE_STORAGE_BUCKET=your-project-id.appspot.com
FIREBASE_API_KEY=your-actual-api-key
FIREBASE_AUTH_DOMAIN=your-project-id.firebaseapp.com

# Vite Firebase Configuration (for frontend)
VITE_FIREBASE_API_KEY="${FIREBASE_API_KEY}"
VITE_FIREBASE_AUTH_DOMAIN="${FIREBASE_AUTH_DOMAIN}"
VITE_FIREBASE_PROJECT_ID="${FIREBASE_PROJECT_ID}"
VITE_FIREBASE_STORAGE_BUCKET="${FIREBASE_STORAGE_BUCKET}"
VITE_FIREBASE_MESSAGING_SENDER_ID=your-messaging-sender-id
VITE_FIREBASE_APP_ID=your-app-id
```

## Step 4: Place Service Account Key

1. Download your Firebase service account JSON file
2. Place it in `storage/app/firebase-credentials.json`
3. Make sure this file is in your `.gitignore` (it already should be in the `storage/` folder)

## Step 5: Data Migration

### 5.1 Test Migration (Dry Run)

First, test the migration without actually transferring data:

```bash
php artisan migrate:firebase --dry-run
```

This will show you what data would be migrated without actually doing it.

### 5.2 Migrate Specific Tables

You can migrate individual tables:

```bash
# Migrate only projects
php artisan migrate:firebase --table=projects

# Migrate only skills
php artisan migrate:firebase --table=skills

# Migrate only education
php artisan migrate:firebase --table=education

# Migrate only messages
php artisan migrate:firebase --table=messages

# Migrate only users
php artisan migrate:firebase --table=users
```

### 5.3 Migrate All Data

To migrate all data at once:

```bash
php artisan migrate:firebase --table=all
```

## Step 6: Update Your Controllers

Replace your Eloquent model usage with Firebase repositories. Here's an example:

### Before (MySQL/Eloquent):
```php
// In your controller
use App\Models\Project;

public function index()
{
    $projects = Project::where('is_visible', true)->get();
    return response()->json($projects);
}
```

### After (Firebase):
```php
// In your controller
use App\Repositories\FirebaseProjectRepository;

public function __construct(private FirebaseProjectRepository $projectRepo) {}

public function index()
{
    $projects = $this->projectRepo->getAllVisible();
    return response()->json($projects);
}
```

## Step 7: Update Frontend Components

Use the Firebase composable in your Vue components:

```vue
<script setup>
import { ref, onMounted } from 'vue';
import { useFirebase } from '@/composables/useFirebase';

const { getProjects, loading, error } = useFirebase();
const projects = ref([]);

onMounted(async () => {
    projects.value = await getProjects();
});
</script>

<template>
    <div v-if="loading">Loading...</div>
    <div v-else-if="error">Error: {{ error }}</div>
    <div v-else>
        <div v-for="project in projects" :key="project.id">
            <h3>{{ project.title }}</h3>
            <p>{{ project.description }}</p>
        </div>
    </div>
</template>
```

## Step 8: Firebase Security Rules

Set up Firestore security rules to protect your data:

```javascript
// Firestore Security Rules
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    // Projects, skills, education - read only for public
    match /{collection}/{document} {
      allow read: if collection in ['projects', 'skills', 'education'] 
                  && resource.data.is_visible == true;
      allow write: if request.auth != null; // Only authenticated users can write
    }
    
    // Messages - anyone can create, only admins can read
    match /messages/{messageId} {
      allow create: if true; // Anyone can send messages
      allow read, update, delete: if request.auth != null; // Only authenticated users
    }
    
    // Users - only authenticated users can access their own data
    match /users/{userId} {
      allow read, write: if request.auth != null && request.auth.uid == userId;
    }
  }
}
```

## Step 9: File Storage Migration

If you have file uploads, consider migrating to Firebase Storage:

```php
// Example: Upload to Firebase Storage
use Kreait\Firebase\Factory;

$factory = (new Factory)->withServiceAccount(config('firebase.credentials'));
$storage = $factory->createStorage();

$bucket = $storage->getBucket();
$bucket->upload(
    fopen('/path/to/local/file.jpg', 'r'),
    ['name' => 'projects/image.jpg']
);
```

## Step 10: Testing

1. Test all CRUD operations
2. Verify data integrity
3. Test real-time features (if implemented)
4. Performance testing

## Step 11: Production Deployment

1. Update production environment variables
2. Place service account key on production server
3. Run migration on production data
4. Update deployment scripts

## Available Firebase Repository Methods

### FirebaseProjectRepository
- `getAllVisible()` - Get all visible projects
- `getAll()` - Get all projects (including hidden)
- `find($id)` - Get project by ID
- `create($data)` - Create new project
- `update($id, $data)` - Update project
- `delete($id)` - Delete project
- `searchByTechnology($tech)` - Search by technology
- `addImage($projectId, $imageUrl)` - Add image to project
- `removeImage($projectId, $imageUrl)` - Remove image from project

### FirebaseSkillRepository
- `getAllVisible()` - Get all visible skills
- `getAll()` - Get all skills
- `getByLevel($level)` - Get skills by level
- `find($id)` - Get skill by ID
- `create($data)` - Create new skill
- `update($id, $data)` - Update skill
- `delete($id)` - Delete skill

### FirebaseEducationRepository
- `getAllVisible()` - Get all visible education records
- `getAll()` - Get all education records
- `find($id)` - Get education by ID
- `create($data)` - Create new education record
- `update($id, $data)` - Update education record
- `delete($id)` - Delete education record
- `getCurrent()` - Get current education (ongoing)

## Frontend Firebase Methods

### useFirebase Composable
- `getProjects()` - Get all visible projects
- `getSkills()` - Get all visible skills
- `getEducation()` - Get all visible education
- `sendMessage(data)` - Send a contact message
- `getCollection(name, filters, ordering)` - Generic collection getter
- `addDocument(collection, data)` - Add new document
- `updateDocument(collection, id, data)` - Update document
- `deleteDocument(collection, id)` - Delete document

## Troubleshooting

### Common Issues:

1. **Service Account Key Error**: Make sure the JSON file path is correct and the file is readable
2. **Permission Denied**: Check Firestore security rules
3. **Network Error**: Verify Firebase project ID and credentials
4. **Data Type Issues**: Ensure data types match between MySQL and Firestore

### Debug Mode:
Enable debug logging in your `.env`:
```env
LOG_LEVEL=debug
```

## Rollback Plan

If you need to rollback to MySQL:
1. Keep your MySQL database intact during testing
2. Comment out Firebase repository injections
3. Revert to Eloquent models
4. Update environment variables

## Performance Considerations

1. **Indexing**: Create Firestore indexes for frequently queried fields
2. **Caching**: Implement caching for frequently accessed data
3. **Pagination**: Use Firestore pagination for large datasets
4. **Real-time**: Consider using real-time listeners for dynamic content

## Security Best Practices

1. Never expose service account keys in frontend code
2. Use environment variables for all sensitive data
3. Implement proper Firestore security rules
4. Regularly rotate API keys
5. Monitor Firebase usage and costs

---

For more information, refer to:
- [Firebase Documentation](https://firebase.google.com/docs)
- [Firestore PHP SDK](https://firebase-php.readthedocs.io/)
- [Firebase JavaScript SDK](https://firebase.google.com/docs/web/setup) 