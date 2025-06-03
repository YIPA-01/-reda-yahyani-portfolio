<template>
  <div class="projects-page">
    <!-- Header -->
    <div class="page-header">
      <div class="container">
        <h1 class="page-title">My Projects</h1>
        <p class="page-subtitle">Explore my portfolio of web applications and development work</p>
      </div>
    </div>

    <!-- Filters -->
    <section class="filters-section py-8">
      <div class="container">
        <div class="filters">
          <button 
            @click="activeFilter = 'all'"
            :class="{ active: activeFilter === 'all' }"
            class="filter-btn"
          >
            All Projects
          </button>
          <button 
            v-for="category in categories"
            :key="category"
            @click="activeFilter = category"
            :class="{ active: activeFilter === category }"
            class="filter-btn"
          >
            {{ category }}
          </button>
        </div>
      </div>
    </section>

    <!-- Projects Grid -->
    <section class="projects-section py-16">
      <div class="container">
        <div class="projects-grid">
          <div 
            v-for="project in filteredProjects" 
            :key="project.id" 
            class="project-card"
          >
            <div class="project-image">
              <img 
                :src="project.image_url || '/api/placeholder/400/250'" 
                :alt="project.title"
                @error="$event.target.src = '/api/placeholder/400/250'"
              />
              <div class="project-overlay">
                <div class="project-actions">
                  <a 
                    v-if="project.demo_url" 
                    :href="project.demo_url" 
                    target="_blank"
                    class="btn-overlay"
                  >
                    <i class="fas fa-external-link-alt"></i>
                    Live Demo
                  </a>
                  <a 
                    v-if="project.github_url" 
                    :href="project.github_url" 
                    target="_blank"
                    class="btn-overlay"
                  >
                    <i class="fab fa-github"></i>
                    Code
                  </a>
                </div>
              </div>
            </div>
            
            <div class="project-content">
              <div class="project-meta">
                <span class="project-category">{{ project.category }}</span>
                <span class="project-date">{{ formatDate(project.created_at) }}</span>
              </div>
              
              <h3 class="project-title">{{ project.title }}</h3>
              <p class="project-description">{{ project.description }}</p>
              
              <div class="project-technologies">
                <span 
                  v-for="tech in project.technologies" 
                  :key="tech" 
                  class="tech-tag"
                >
                  {{ tech }}
                </span>
              </div>
              
              <div class="project-links">
                <a 
                  v-if="project.demo_url" 
                  :href="project.demo_url" 
                  target="_blank"
                  class="project-link"
                >
                  <i class="fas fa-external-link-alt"></i>
                  Live Demo
                </a>
                <a 
                  v-if="project.github_url" 
                  :href="project.github_url" 
                  target="_blank"
                  class="project-link"
                >
                  <i class="fab fa-github"></i>
                  View Code
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="filteredProjects.length === 0" class="empty-state">
          <i class="fas fa-search fa-3x"></i>
          <h3>No projects found</h3>
          <p>Try selecting a different category or check back later for new projects.</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useFirebase } from '../composables/useFirebase'

const { getProjects } = useFirebase()

// Reactive data
const projects = ref([])
const activeFilter = ref('all')

// Computed properties
const categories = computed(() => {
  const cats = [...new Set(projects.value.map(p => p.category).filter(Boolean))]
  return cats.sort()
})

const filteredProjects = computed(() => {
  if (activeFilter.value === 'all') {
    return projects.value
  }
  return projects.value.filter(p => p.category === activeFilter.value)
})

// Methods
const formatDate = (dateString) => {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    year: 'numeric', 
    month: 'short' 
  })
}

onMounted(async () => {
  document.title = 'Projects - Reda Yahyani'
  
  try {
    projects.value = await getProjects()
  } catch (error) {
    console.error('Error loading projects:', error)
  }
})
</script>

<style scoped>
.projects-page {
  min-height: 100vh;
}

.page-header {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 100px 0 60px;
  text-align: center;
}

.page-title {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.page-subtitle {
  font-size: 1.2rem;
  opacity: 0.9;
}

.filters-section {
  background: #f8f9fa;
}

.filters {
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.filter-btn {
  background: white;
  border: 2px solid #e0e0e0;
  padding: 0.75rem 1.5rem;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 500;
}

.filter-btn:hover,
.filter-btn.active {
  background: #667eea;
  color: white;
  border-color: #667eea;
}

.projects-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 2rem;
}

.project-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.project-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.project-image {
  position: relative;
  height: 250px;
  overflow: hidden;
}

.project-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.project-card:hover .project-image img {
  transform: scale(1.05);
}

.project-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(102, 126, 234, 0.9);
  opacity: 0;
  transition: opacity 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.project-card:hover .project-overlay {
  opacity: 1;
}

.project-actions {
  display: flex;
  gap: 1rem;
}

.btn-overlay {
  background: white;
  color: #667eea;
  padding: 0.5rem 1rem;
  border-radius: 25px;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-overlay:hover {
  background: #f8f9fa;
  transform: scale(1.05);
}

.project-content {
  padding: 1.5rem;
}

.project-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.project-category {
  background: #667eea;
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 500;
}

.project-date {
  color: #666;
  font-size: 0.9rem;
}

.project-title {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 0.75rem;
  color: #333;
}

.project-description {
  color: #666;
  line-height: 1.6;
  margin-bottom: 1rem;
}

.project-technologies {
  margin-bottom: 1.5rem;
}

.tech-tag {
  display: inline-block;
  background: #f8f9fa;
  color: #667eea;
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-size: 0.8rem;
  margin: 0.25rem 0.25rem 0.25rem 0;
  border: 1px solid #e0e0e0;
}

.project-links {
  display: flex;
  gap: 1rem;
}

.project-link {
  color: #667eea;
  text-decoration: none;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: color 0.3s ease;
}

.project-link:hover {
  color: #5a6fd8;
}

.empty-state {
  text-align: center;
  padding: 4rem 2rem;
  color: #666;
}

.empty-state i {
  color: #ccc;
  margin-bottom: 1rem;
}

.empty-state h3 {
  margin-bottom: 0.5rem;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.py-8 {
  padding: 2rem 0;
}

.py-16 {
  padding: 4rem 0;
}

@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }
  
  .projects-grid {
    grid-template-columns: 1fr;
  }
  
  .filters {
    justify-content: center;
  }
  
  .filter-btn {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
  }
}
</style> 