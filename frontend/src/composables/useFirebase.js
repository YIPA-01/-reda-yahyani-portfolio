import { ref, computed } from 'vue'
import { 
  initializeApp 
} from 'firebase/app'
import { 
  getFirestore, 
  collection, 
  getDocs, 
  addDoc, 
  query, 
  where, 
  orderBy, 
  limit 
} from 'firebase/firestore'

// Firebase configuration
const firebaseConfig = {
  apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
  authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
  projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
  storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
  messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
  appId: import.meta.env.VITE_FIREBASE_APP_ID
}

// Initialize Firebase
let app = null
let db = null

try {
  app = initializeApp(firebaseConfig)
  db = getFirestore(app)
} catch (error) {
  console.error('Firebase initialization error:', error)
}

// Reactive state
const isConnected = ref(false)
const loading = ref(false)
const error = ref(null)

// Test Firebase connection
const testConnection = async () => {
  if (!db) {
    error.value = 'Firebase not initialized'
    return false
  }
  
  try {
    loading.value = true
    // Try to read from a collection to test connection
    await getDocs(query(collection(db, 'projects'), limit(1)))
    isConnected.value = true
    error.value = null
    return true
  } catch (err) {
    console.error('Firebase connection test failed:', err)
    error.value = err.message
    isConnected.value = false
    return false
  } finally {
    loading.value = false
  }
}

// Get projects
const getProjects = async () => {
  if (!db) {
    console.warn('Firebase not initialized, returning empty array')
    return []
  }
  
  try {
    loading.value = true
    const q = query(
      collection(db, 'projects'),
      where('is_visible', '==', true),
      orderBy('created_at', 'desc')
    )
    
    const querySnapshot = await getDocs(q)
    const projects = []
    
    querySnapshot.forEach((doc) => {
      projects.push({
        id: doc.id,
        ...doc.data()
      })
    })
    
    return projects
  } catch (err) {
    console.error('Error fetching projects:', err)
    error.value = err.message
    return []
  } finally {
    loading.value = false
  }
}

// Get skills
const getSkills = async () => {
  if (!db) {
    console.warn('Firebase not initialized, returning empty array')
    return []
  }
  
  try {
    loading.value = true
    const q = query(
      collection(db, 'skills'),
      where('is_visible', '==', true),
      orderBy('proficiency_level', 'desc')
    )
    
    const querySnapshot = await getDocs(q)
    const skills = []
    
    querySnapshot.forEach((doc) => {
      skills.push({
        id: doc.id,
        ...doc.data()
      })
    })
    
    return skills
  } catch (err) {
    console.error('Error fetching skills:', err)
    error.value = err.message
    return []
  } finally {
    loading.value = false
  }
}

// Get education
const getEducation = async () => {
  if (!db) {
    console.warn('Firebase not initialized, returning empty array')
    return []
  }
  
  try {
    loading.value = true
    const q = query(
      collection(db, 'education'),
      where('is_visible', '==', true),
      orderBy('year', 'desc')
    )
    
    const querySnapshot = await getDocs(q)
    const education = []
    
    querySnapshot.forEach((doc) => {
      education.push({
        id: doc.id,
        ...doc.data()
      })
    })
    
    return education
  } catch (err) {
    console.error('Error fetching education:', err)
    error.value = err.message
    return []
  } finally {
    loading.value = false
  }
}

// Send message
const sendMessage = async (messageData) => {
  if (!db) {
    throw new Error('Firebase not initialized')
  }
  
  try {
    loading.value = true
    const docRef = await addDoc(collection(db, 'messages'), {
      ...messageData,
      is_read: false,
      created_at: new Date().toISOString()
    })
    
    console.log('Message sent with ID:', docRef.id)
    return docRef.id
  } catch (err) {
    console.error('Error sending message:', err)
    error.value = err.message
    throw err
  } finally {
    loading.value = false
  }
}

// Computed properties
const isInitialized = computed(() => !!db)
const hasError = computed(() => !!error.value)

// Firebase composable
export function useFirebase() {
  return {
    // State
    isConnected: computed(() => isConnected.value),
    loading: computed(() => loading.value),
    error: computed(() => error.value),
    isInitialized,
    hasError,
    
    // Methods
    testConnection,
    getProjects,
    getSkills,
    getEducation,
    sendMessage
  }
}

// Auto-initialize and test connection
if (db) {
  testConnection()
}

export default useFirebase 