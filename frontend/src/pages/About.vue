<template>
  <div class="about-page">
    <!-- Header -->
    <div class="page-header">
      <div class="container">
        <h1 class="page-title">About Me</h1>
        <p class="page-subtitle">Get to know more about my journey and expertise</p>
      </div>
    </div>

    <!-- Biography Section -->
    <section class="biography-section py-16">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h2>My Story</h2>
            <p class="lead">
              Passionate full-stack developer with expertise in modern web technologies.
              I create scalable, user-friendly applications that solve real-world problems.
            </p>
            <p>
              With years of experience in both frontend and backend development, 
              I specialize in creating seamless digital experiences. My journey in 
              technology has been driven by curiosity and a constant desire to learn 
              and adapt to new challenges.
            </p>
          </div>
          <div class="col-lg-6">
            <div class="about-stats">
              <div class="stat-item">
                <h3>{{ projects.length }}+</h3>
                <p>Projects Completed</p>
              </div>
              <div class="stat-item">
                <h3>{{ skills.length }}+</h3>
                <p>Technologies Mastered</p>
              </div>
              <div class="stat-item">
                <h3>{{ education.length }}+</h3>
                <p>Educational Achievements</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Professional Experience -->
    <section class="experience-section py-16 bg-light">
      <div class="container">
        <h2 class="section-title">Professional Experience</h2>
        <div class="timeline">
          <div v-for="exp in experience" :key="exp.id" class="timeline-item">
            <div class="timeline-content">
              <h3>{{ exp.position }}</h3>
              <h4>{{ exp.company }}</h4>
              <span class="date">{{ exp.start_date }} - {{ exp.end_date || 'Present' }}</span>
              <p>{{ exp.description }}</p>
              <div class="technologies">
                <span v-for="tech in exp.technologies" :key="tech" class="tech-tag">
                  {{ tech }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Education -->
    <section class="education-section py-16">
      <div class="container">
        <h2 class="section-title">Education</h2>
        <div class="education-grid">
          <div v-for="edu in education" :key="edu.id" class="education-card">
            <h3>{{ edu.degree }}</h3>
            <h4>{{ edu.institution }}</h4>
            <span class="date">{{ edu.year }}</span>
            <p v-if="edu.field_of_study">{{ edu.field_of_study }}</p>
            <p v-if="edu.description">{{ edu.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Skills -->
    <section class="skills-section py-16 bg-light">
      <div class="container">
        <h2 class="section-title">Technical Skills</h2>
        <div class="skills-grid">
          <div v-for="skill in skills" :key="skill.id" class="skill-card">
            <div class="skill-icon">
              <i :class="skill.icon || 'fas fa-code'" class="skill-icon-img"></i>
            </div>
            <h3>{{ skill.name }}</h3>
            <span class="skill-category">{{ skill.category }}</span>
            <div class="skill-level">
              <div class="skill-bar">
                <div 
                  class="skill-progress" 
                  :style="{ width: skill.proficiency_level + '%' }"
                ></div>
              </div>
              <span class="level-text">{{ skill.proficiency_level }}%</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useFirebase } from '../composables/useFirebase'

const { getEducation, getSkills, getProjects } = useFirebase()

// Reactive data
const education = ref([])
const skills = ref([])
const projects = ref([])
const experience = ref([
  {
    id: 1,
    position: "Full Stack Developer",
    company: "Freelance",
    start_date: "2022",
    end_date: null,
    description: "Developing modern web applications using Laravel, Vue.js, and various other technologies. Working with clients to deliver custom solutions that meet their business needs.",
    technologies: ["Laravel", "Vue.js", "PHP", "JavaScript", "MySQL", "Firebase"]
  }
])

onMounted(async () => {
  document.title = 'About - Reda Yahyani'
  
  try {
    // Load data from Firebase
    education.value = await getEducation()
    skills.value = await getSkills()
    projects.value = await getProjects()
  } catch (error) {
    console.error('Error loading data:', error)
  }
})
</script>

<style scoped>
.about-page {
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

.section-title {
  text-align: center;
  margin-bottom: 3rem;
  font-size: 2.5rem;
  font-weight: 700;
}

.about-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 2rem;
}

.stat-item {
  text-align: center;
}

.stat-item h3 {
  font-size: 2.5rem;
  font-weight: 700;
  color: #667eea;
}

.timeline {
  position: relative;
  max-width: 800px;
  margin: 0 auto;
}

.timeline-item {
  margin-bottom: 2rem;
  padding: 2rem;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.timeline-content h3 {
  color: #667eea;
  margin-bottom: 0.5rem;
}

.timeline-content h4 {
  color: #666;
  margin-bottom: 0.5rem;
}

.date {
  color: #999;
  font-size: 0.9rem;
}

.technologies {
  margin-top: 1rem;
}

.tech-tag {
  display: inline-block;
  background: #667eea;
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 15px;
  font-size: 0.8rem;
  margin: 0.25rem;
}

.education-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.education-card {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.education-card h3 {
  color: #667eea;
  margin-bottom: 0.5rem;
}

.skills-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
}

.skill-card {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.skill-icon {
  margin-bottom: 1rem;
}

.skill-icon-img {
  font-size: 2.5rem;
  color: #667eea;
}

.skill-category {
  color: #666;
  font-size: 0.9rem;
}

.skill-level {
  margin-top: 1rem;
}

.skill-bar {
  background: #e0e0e0;
  height: 8px;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 0.5rem;
}

.skill-progress {
  background: linear-gradient(45deg, #667eea, #764ba2);
  height: 100%;
  transition: width 0.3s ease;
}

.level-text {
  font-size: 0.9rem;
  color: #666;
}

.bg-light {
  background-color: #f8f9fa;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.row {
  display: flex;
  flex-wrap: wrap;
  margin: -1rem;
}

.col-lg-6 {
  flex: 0 0 50%;
  padding: 1rem;
}

@media (max-width: 768px) {
  .col-lg-6 {
    flex: 0 0 100%;
  }
  
  .page-title {
    font-size: 2rem;
  }
  
  .about-stats {
    grid-template-columns: 1fr;
  }
}
</style> 