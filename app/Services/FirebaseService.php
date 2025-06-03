<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Google\Auth\Credentials\ServiceAccountCredentials;

class FirebaseService
{
    protected $projectId;
    protected $accessToken;
    protected $baseUrl;
    protected $initialized = false;

    public function __construct()
    {
        // Get credentials path from config
        $credentialsPath = config('firebase.credentials');
        
        // If it's a relative path, make it absolute
        if (!str_starts_with($credentialsPath, '/')) {
            $credentialsPath = base_path($credentialsPath);
        }
        
        if (!file_exists($credentialsPath)) {
            \Log::warning('Firebase credentials file not found at: ' . $credentialsPath);
            return;
        }

        try {
            // Read credentials file
            $credentials = json_decode(file_get_contents($credentialsPath), true);
            $this->projectId = $credentials['project_id'];
            
            // Initialize the service account credentials
            $serviceAccount = new ServiceAccountCredentials(
                'https://www.googleapis.com/auth/datastore',
                $credentials
            );
            
            // Get access token
            $authToken = $serviceAccount->fetchAuthToken();
            $this->accessToken = $authToken['access_token'];
            
            $this->baseUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents";
            $this->initialized = true;
            
            \Log::info('Firebase Firestore initialized successfully with REST API');
        } catch (\Exception $e) {
            \Log::error('Firebase Firestore initialization failed: ' . $e->getMessage());
            \Log::error('Error details: ' . $e->getTraceAsString());
        }
    }

    public function collection(string $name)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        return new FirestoreCollection($name, $this);
    }

    public function document(string $collection, string $id = null)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        
        if ($id) {
            return new FirestoreDocument($collection, $id, $this);
        }
        return new FirestoreDocument($collection, null, $this);
    }

    public function get(string $collection, string $id)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        
        $url = "{$this->baseUrl}/{$collection}/{$id}";
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->get($url);
        
        if ($response->successful()) {
            return $this->parseFirestoreDocument($response->json());
        }
        
        return null;
    }

    public function set(string $collection, string $id, array $data)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        
        $url = "{$this->baseUrl}/{$collection}/{$id}";
        $firestoreData = $this->convertToFirestoreFormat($data);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->patch($url, ['fields' => $firestoreData]);
        
        return $response->successful();
    }

    public function add(string $collection, array $data)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        
        $url = "{$this->baseUrl}/{$collection}";
        $firestoreData = $this->convertToFirestoreFormat($data);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post($url, ['fields' => $firestoreData]);
        
        if ($response->successful()) {
            $result = $response->json();
            return $result['name'] ?? null;
        }
        
        return false;
    }

    public function update(string $collection, string $id, array $data)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        
        $url = "{$this->baseUrl}/{$collection}/{$id}";
        $firestoreData = $this->convertToFirestoreFormat($data);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->patch($url, ['fields' => $firestoreData]);
        
        return $response->successful();
    }

    public function delete(string $collection, string $id)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        
        $url = "{$this->baseUrl}/{$collection}/{$id}";
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
        ])->delete($url);
        
        return $response->successful();
    }

    public function where(string $collection, string $field, string $operator, $value)
    {
        if (!$this->initialized) {
            throw new \Exception('Firebase not initialized. Please check your credentials and configuration.');
        }
        
        // This is a simplified version - full query support would require more complex implementation
        $url = "{$this->baseUrl}:runQuery";
        $query = [
            'structuredQuery' => [
                'from' => [['collectionId' => $collection]],
                'where' => [
                    'fieldFilter' => [
                        'field' => ['fieldPath' => $field],
                        'op' => $this->convertOperator($operator),
                        'value' => $this->convertValueToFirestore($value)
                    ]
                ]
            ]
        ];
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->accessToken,
            'Content-Type' => 'application/json',
        ])->post($url, $query);
        
        if ($response->successful()) {
            $results = $response->json();
            $documents = [];
            
            foreach ($results as $result) {
                if (isset($result['document'])) {
                    $documents[] = $this->parseFirestoreDocument($result['document']);
                }
            }
            
            return $documents;
        }
        
        return [];
    }

    public function getFirestore()
    {
        return $this;
    }

    public function isInitialized()
    {
        return $this->initialized;
    }

    // Helper methods for Firestore format conversion
    private function convertToFirestoreFormat(array $data)
    {
        $converted = [];
        foreach ($data as $key => $value) {
            $converted[$key] = $this->convertValueToFirestore($value);
        }
        return $converted;
    }

    private function convertValueToFirestore($value)
    {
        if (is_string($value)) {
            return ['stringValue' => $value];
        } elseif (is_int($value)) {
            return ['integerValue' => (string)$value];
        } elseif (is_float($value)) {
            return ['doubleValue' => $value];
        } elseif (is_bool($value)) {
            return ['booleanValue' => $value];
        } elseif (is_array($value)) {
            return ['arrayValue' => ['values' => array_map([$this, 'convertValueToFirestore'], $value)]];
        } elseif ($value instanceof \DateTime) {
            return ['timestampValue' => $value->format('c')];
        } elseif (is_null($value)) {
            return ['nullValue' => null];
        }
        
        return ['stringValue' => (string)$value];
    }

    private function parseFirestoreDocument(array $document)
    {
        $data = [];
        if (isset($document['fields'])) {
            foreach ($document['fields'] as $key => $field) {
                $data[$key] = $this->parseFirestoreValue($field);
            }
        }
        return $data;
    }

    private function parseFirestoreValue(array $value)
    {
        if (isset($value['stringValue'])) {
            return $value['stringValue'];
        } elseif (isset($value['integerValue'])) {
            return (int)$value['integerValue'];
        } elseif (isset($value['doubleValue'])) {
            return (float)$value['doubleValue'];
        } elseif (isset($value['booleanValue'])) {
            return $value['booleanValue'];
        } elseif (isset($value['timestampValue'])) {
            return new \DateTime($value['timestampValue']);
        } elseif (isset($value['arrayValue'])) {
            return array_map([$this, 'parseFirestoreValue'], $value['arrayValue']['values'] ?? []);
        } elseif (isset($value['nullValue'])) {
            return null;
        }
        
        return null;
    }

    private function convertOperator(string $operator)
    {
        $operatorMap = [
            '=' => 'EQUAL',
            '!=' => 'NOT_EQUAL',
            '<' => 'LESS_THAN',
            '<=' => 'LESS_THAN_OR_EQUAL',
            '>' => 'GREATER_THAN',
            '>=' => 'GREATER_THAN_OR_EQUAL',
            'array-contains' => 'ARRAY_CONTAINS',
            'in' => 'IN',
            'array-contains-any' => 'ARRAY_CONTAINS_ANY',
            'not-in' => 'NOT_IN',
        ];
        
        return $operatorMap[$operator] ?? 'EQUAL';
    }
}

// Helper classes for fluent interface
class FirestoreCollection
{
    private $name;
    private $firebaseService;

    public function __construct(string $name, FirebaseService $firebaseService)
    {
        $this->name = $name;
        $this->firebaseService = $firebaseService;
    }

    public function document(string $id = null)
    {
        return $this->firebaseService->document($this->name, $id);
    }

    public function add(array $data)
    {
        return $this->firebaseService->add($this->name, $data);
    }

    public function where(string $field, string $operator, $value)
    {
        return $this->firebaseService->where($this->name, $field, $operator, $value);
    }
}

class FirestoreDocument
{
    private $collection;
    private $id;
    private $firebaseService;

    public function __construct(string $collection, ?string $id, FirebaseService $firebaseService)
    {
        $this->collection = $collection;
        $this->id = $id ?: uniqid();
        $this->firebaseService = $firebaseService;
    }

    public function set(array $data)
    {
        return $this->firebaseService->set($this->collection, $this->id, $data);
    }

    public function update(array $data)
    {
        return $this->firebaseService->update($this->collection, $this->id, $data);
    }

    public function delete()
    {
        return $this->firebaseService->delete($this->collection, $this->id);
    }

    public function get()
    {
        return $this->firebaseService->get($this->collection, $this->id);
    }
} 