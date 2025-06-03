// Firebase configuration for frontend
export const firebaseConfig = {
  apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
  authDomain: import.meta.env.VITE_FIREBASE_AUTH_DOMAIN,
  projectId: import.meta.env.VITE_FIREBASE_PROJECT_ID,
  storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
  messagingSenderId: import.meta.env.VITE_FIREBASE_MESSAGING_SENDER_ID,
  appId: import.meta.env.VITE_FIREBASE_APP_ID
}

// API base URL - use Firebase Functions URL in production
export const API_BASE_URL = import.meta.env.PROD 
  ? 'https://reda-yahyani-portfolio-default-rtdb.firebaseio.com/api' // Replace with your Firebase Functions URL
  : 'http://localhost:5001/reda-yahyani-portfolio/us-central1/api' // Local development URL 