import { ref, reactive } from 'vue'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:5001/reda-yahyani-portfolio/us-central1/api'

export function useApi() {
  const loading = ref(false)
  const error = ref(null)

  const makeRequest = async (endpoint, options = {}) => {
    loading.value = true
    error.value = null

    try {
      const url = `${API_BASE_URL}${endpoint}`
      const response = await fetch(url, {
        headers: {
          'Content-Type': 'application/json',
          ...options.headers,
        },
        ...options,
      })

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`)
      }

      const data = await response.json()
      return data
    } catch (err) {
      error.value = err.message
      console.error('API Error:', err)
      throw err
    } finally {
      loading.value = false
    }
  }

  // API Methods
  const getProjects = () => makeRequest('/projects')
  const getFeaturedProjects = () => makeRequest('/projects/featured')
  const getSkills = () => makeRequest('/skills')
  const getEducation = () => makeRequest('/education')
  const getExperience = () => makeRequest('/experience')
  const getProfile = () => makeRequest('/profile')

  const sendMessage = (messageData) => makeRequest('/contact', {
    method: 'POST',
    body: JSON.stringify(messageData),
  })

  const checkHealth = () => makeRequest('/health')

  return {
    loading,
    error,
    makeRequest,
    getProjects,
    getFeaturedProjects,
    getSkills,
    getEducation,
    getExperience,
    getProfile,
    sendMessage,
    checkHealth,
  }
}

// Portfolio Data Composable (fallback for offline or development)
export function usePortfolio() {
  const api = useApi()
  const portfolioData = reactive({
    profile: null,
    projects: [],
    featuredProjects: [],
    skills: [],
    education: [],
    experience: [],
  })

  const loadPortfolioData = async () => {
    try {
      // Load all data in parallel
      const [profile, projects, skills, education, experience] = await Promise.all([
        api.getProfile().catch(() => null),
        api.getProjects().catch(() => []),
        api.getSkills().catch(() => []),
        api.getEducation().catch(() => []),
        api.getExperience().catch(() => []),
      ])

      portfolioData.profile = profile
      portfolioData.projects = projects
      portfolioData.featuredProjects = projects.filter(p => p.featured)
      portfolioData.skills = skills
      portfolioData.education = education
      portfolioData.experience = experience

    } catch (error) {
      console.error('Error loading portfolio data:', error)
    }
  }

  const submitContactForm = async (formData) => {
    return await api.sendMessage(formData)
  }

  return {
    portfolioData,
    loading: api.loading,
    error: api.error,
    loadPortfolioData,
    submitContactForm,
  }
} 