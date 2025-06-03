import { ref, reactive } from 'vue';
import { 
    collection, 
    doc, 
    getDocs, 
    getDoc, 
    addDoc, 
    updateDoc, 
    deleteDoc, 
    query, 
    where, 
    orderBy, 
    limit,
    onSnapshot
} from 'firebase/firestore';
import { db } from '../firebase';

export function useFirebase() {
    const loading = ref(false);
    const error = ref(null);

    // Generic function to get all documents from a collection
    const getCollection = async (collectionName, filters = [], ordering = null, limitCount = null) => {
        loading.value = true;
        error.value = null;
        
        try {
            let q = collection(db, collectionName);
            
            // Apply filters
            filters.forEach(filter => {
                q = query(q, where(filter.field, filter.operator, filter.value));
            });
            
            // Apply ordering
            if (ordering) {
                q = query(q, orderBy(ordering.field, ordering.direction || 'asc'));
            }
            
            // Apply limit
            if (limitCount) {
                q = query(q, limit(limitCount));
            }
            
            const querySnapshot = await getDocs(q);
            const documents = [];
            
            querySnapshot.forEach((doc) => {
                documents.push({
                    id: doc.id,
                    ...doc.data()
                });
            });
            
            return documents;
        } catch (err) {
            error.value = err.message;
            console.error('Error getting documents:', err);
            return [];
        } finally {
            loading.value = false;
        }
    };

    // Get a single document
    const getDocument = async (collectionName, documentId) => {
        loading.value = true;
        error.value = null;
        
        try {
            const docRef = doc(db, collectionName, documentId);
            const docSnap = await getDoc(docRef);
            
            if (docSnap.exists()) {
                return {
                    id: docSnap.id,
                    ...docSnap.data()
                };
            } else {
                return null;
            }
        } catch (err) {
            error.value = err.message;
            console.error('Error getting document:', err);
            return null;
        } finally {
            loading.value = false;
        }
    };

    // Add a new document
    const addDocument = async (collectionName, data) => {
        loading.value = true;
        error.value = null;
        
        try {
            const docRef = await addDoc(collection(db, collectionName), {
                ...data,
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString()
            });
            
            return docRef.id;
        } catch (err) {
            error.value = err.message;
            console.error('Error adding document:', err);
            return null;
        } finally {
            loading.value = false;
        }
    };

    // Update a document
    const updateDocument = async (collectionName, documentId, data) => {
        loading.value = true;
        error.value = null;
        
        try {
            const docRef = doc(db, collectionName, documentId);
            await updateDoc(docRef, {
                ...data,
                updated_at: new Date().toISOString()
            });
            
            return true;
        } catch (err) {
            error.value = err.message;
            console.error('Error updating document:', err);
            return false;
        } finally {
            loading.value = false;
        }
    };

    // Delete a document
    const deleteDocument = async (collectionName, documentId) => {
        loading.value = true;
        error.value = null;
        
        try {
            await deleteDoc(doc(db, collectionName, documentId));
            return true;
        } catch (err) {
            error.value = err.message;
            console.error('Error deleting document:', err);
            return false;
        } finally {
            loading.value = false;
        }
    };

    // Real-time listener for a collection
    const listenToCollection = (collectionName, callback, filters = [], ordering = null) => {
        let q = collection(db, collectionName);
        
        // Apply filters
        filters.forEach(filter => {
            q = query(q, where(filter.field, filter.operator, filter.value));
        });
        
        // Apply ordering
        if (ordering) {
            q = query(q, orderBy(ordering.field, ordering.direction || 'asc'));
        }
        
        return onSnapshot(q, (querySnapshot) => {
            const documents = [];
            querySnapshot.forEach((doc) => {
                documents.push({
                    id: doc.id,
                    ...doc.data()
                });
            });
            callback(documents);
        }, (err) => {
            error.value = err.message;
            console.error('Error in real-time listener:', err);
        });
    };

    // Specific methods for your portfolio collections
    const getProjects = () => {
        return getCollection('projects', 
            [{ field: 'is_visible', operator: '==', value: true }],
            { field: 'created_at', direction: 'desc' }
        );
    };

    const getSkills = () => {
        return getCollection('skills',
            [{ field: 'is_visible', operator: '==', value: true }],
            { field: 'name', direction: 'asc' }
        );
    };

    const getEducation = () => {
        return getCollection('education',
            [{ field: 'is_visible', operator: '==', value: true }],
            { field: 'start_date', direction: 'desc' }
        );
    };

    const getMessages = () => {
        return getCollection('messages', [], { field: 'created_at', direction: 'desc' });
    };

    const sendMessage = (messageData) => {
        return addDocument('messages', messageData);
    };

    return {
        loading,
        error,
        getCollection,
        getDocument,
        addDocument,
        updateDocument,
        deleteDocument,
        listenToCollection,
        // Portfolio-specific methods
        getProjects,
        getSkills,
        getEducation,
        getMessages,
        sendMessage
    };
} 