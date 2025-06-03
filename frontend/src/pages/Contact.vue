<template>
  <div class="contact-page">
    <!-- Header -->
    <div class="page-header">
      <div class="container">
        <h1 class="page-title">Get In Touch</h1>
        <p class="page-subtitle">Let's discuss your next project or collaboration opportunity</p>
      </div>
    </div>

    <!-- Contact Section -->
    <section class="contact-section py-16">
      <div class="container">
        <div class="row">
          <!-- Contact Info -->
          <div class="col-lg-6">
            <div class="contact-info">
              <h2>Let's Connect</h2>
              <p class="lead">
                I'm always interested in hearing about new opportunities and exciting projects.
                Whether you need a full-stack developer, want to collaborate, or just say hello, 
                I'd love to hear from you.
              </p>

              <div class="contact-methods">
                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <div class="contact-details">
                    <h4>Email</h4>
                    <p>reda.yahyani@example.com</p>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div class="contact-details">
                    <h4>Phone</h4>
                    <p>+1 (555) 123-4567</p>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <div class="contact-details">
                    <h4>Location</h4>
                    <p>Available for remote work worldwide</p>
                  </div>
                </div>
              </div>

              <div class="social-links">
                <h4>Follow Me</h4>
                <div class="social-icons">
                  <a href="#" class="social-link" aria-label="LinkedIn">
                    <i class="fab fa-linkedin"></i>
                  </a>
                  <a href="#" class="social-link" aria-label="GitHub">
                    <i class="fab fa-github"></i>
                  </a>
                  <a href="#" class="social-link" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                  </a>
                  <a href="#" class="social-link" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="col-lg-6">
            <div class="contact-form-wrapper">
              <form @submit.prevent="submitForm" class="contact-form">
                <div class="form-group">
                  <label for="name">Full Name *</label>
                  <input
                    type="text"
                    id="name"
                    v-model="form.name"
                    :class="{ error: errors.name }"
                    required
                  />
                  <span v-if="errors.name" class="error-message">{{ errors.name }}</span>
                </div>

                <div class="form-group">
                  <label for="email">Email Address *</label>
                  <input
                    type="email"
                    id="email"
                    v-model="form.email"
                    :class="{ error: errors.email }"
                    required
                  />
                  <span v-if="errors.email" class="error-message">{{ errors.email }}</span>
                </div>

                <div class="form-group">
                  <label for="subject">Subject *</label>
                  <input
                    type="text"
                    id="subject"
                    v-model="form.subject"
                    :class="{ error: errors.subject }"
                    required
                  />
                  <span v-if="errors.subject" class="error-message">{{ errors.subject }}</span>
                </div>

                <div class="form-group">
                  <label for="message">Message *</label>
                  <textarea
                    id="message"
                    v-model="form.message"
                    :class="{ error: errors.message }"
                    rows="6"
                    required
                  ></textarea>
                  <span v-if="errors.message" class="error-message">{{ errors.message }}</span>
                </div>

                <button 
                  type="submit" 
                  class="btn-submit"
                  :disabled="isSubmitting"
                >
                  <span v-if="isSubmitting">
                    <i class="fas fa-spinner fa-spin"></i>
                    Sending...
                  </span>
                  <span v-else>
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                  </span>
                </button>
              </form>

              <!-- Success Message -->
              <div v-if="showSuccess" class="success-message">
                <i class="fas fa-check-circle"></i>
                <h3>Message Sent Successfully!</h3>
                <p>Thank you for reaching out. I'll get back to you as soon as possible.</p>
              </div>

              <!-- Error Message -->
              <div v-if="showError" class="error-alert">
                <i class="fas fa-exclamation-triangle"></i>
                <p>{{ errorMessage }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { useFirebase } from '../composables/useFirebase'

const { sendMessage } = useFirebase()

// Form data
const form = reactive({
  name: '',
  email: '',
  subject: '',
  message: ''
})

// Form state
const isSubmitting = ref(false)
const showSuccess = ref(false)
const showError = ref(false)
const errorMessage = ref('')
const errors = reactive({})

// Form validation
const validateForm = () => {
  const newErrors = {}

  if (!form.name.trim()) {
    newErrors.name = 'Name is required'
  }

  if (!form.email.trim()) {
    newErrors.email = 'Email is required'
  } else if (!/\S+@\S+\.\S+/.test(form.email)) {
    newErrors.email = 'Please enter a valid email address'
  }

  if (!form.subject.trim()) {
    newErrors.subject = 'Subject is required'
  }

  if (!form.message.trim()) {
    newErrors.message = 'Message is required'
  } else if (form.message.trim().length < 10) {
    newErrors.message = 'Message must be at least 10 characters'
  }

  // Clear previous errors
  Object.keys(errors).forEach(key => delete errors[key])
  // Set new errors
  Object.assign(errors, newErrors)

  return Object.keys(newErrors).length === 0
}

// Submit form
const submitForm = async () => {
  if (!validateForm()) {
    return
  }

  isSubmitting.value = true
  showSuccess.value = false
  showError.value = false

  try {
    await sendMessage({
      name: form.name.trim(),
      email: form.email.trim(),
      subject: form.subject.trim(),
      message: form.message.trim(),
      created_at: new Date().toISOString()
    })

    // Reset form
    Object.keys(form).forEach(key => form[key] = '')
    showSuccess.value = true

    // Hide success message after 5 seconds
    setTimeout(() => {
      showSuccess.value = false
    }, 5000)

  } catch (error) {
    console.error('Error sending message:', error)
    errorMessage.value = 'Failed to send message. Please try again later.'
    showError.value = true

    // Hide error message after 5 seconds
    setTimeout(() => {
      showError.value = false
    }, 5000)
  } finally {
    isSubmitting.value = false
  }
}

onMounted(() => {
  document.title = 'Contact - Reda Yahyani'
})
</script>

<style scoped>
.contact-page {
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

.contact-info h2 {
  color: #333;
  margin-bottom: 1rem;
}

.lead {
  font-size: 1.1rem;
  line-height: 1.7;
  color: #666;
  margin-bottom: 2rem;
}

.contact-methods {
  margin-bottom: 3rem;
}

.contact-item {
  display: flex;
  align-items: center;
  margin-bottom: 1.5rem;
}

.contact-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(45deg, #667eea, #764ba2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

.contact-icon i {
  color: white;
  font-size: 1.2rem;
}

.contact-details h4 {
  margin: 0 0 0.25rem 0;
  color: #333;
}

.contact-details p {
  margin: 0;
  color: #666;
}

.social-links h4 {
  margin-bottom: 1rem;
  color: #333;
}

.social-icons {
  display: flex;
  gap: 1rem;
}

.social-link {
  width: 45px;
  height: 45px;
  background: #f8f9fa;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #667eea;
  text-decoration: none;
  transition: all 0.3s ease;
}

.social-link:hover {
  background: #667eea;
  color: white;
  transform: translateY(-3px);
}

.contact-form-wrapper {
  background: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
  color: #333;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e0e0e0;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #667eea;
}

.form-group input.error,
.form-group textarea.error {
  border-color: #e74c3c;
}

.error-message {
  color: #e74c3c;
  font-size: 0.9rem;
  margin-top: 0.25rem;
  display: block;
}

.btn-submit {
  background: linear-gradient(45deg, #667eea, #764ba2);
  color: white;
  border: none;
  padding: 1rem 2rem;
  border-radius: 25px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  width: 100%;
  justify-content: center;
}

.btn-submit:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn-submit:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.success-message {
  background: #d4edda;
  color: #155724;
  padding: 2rem;
  border-radius: 8px;
  text-align: center;
  border: 1px solid #c3e6cb;
  margin-top: 1rem;
}

.success-message i {
  font-size: 2rem;
  margin-bottom: 1rem;
  display: block;
}

.success-message h3 {
  margin-bottom: 0.5rem;
}

.error-alert {
  background: #f8d7da;
  color: #721c24;
  padding: 1rem;
  border-radius: 8px;
  border: 1px solid #f5c6cb;
  margin-top: 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
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

.py-16 {
  padding: 4rem 0;
}

@media (max-width: 768px) {
  .col-lg-6 {
    flex: 0 0 100%;
  }
  
  .page-title {
    font-size: 2rem;
  }
  
  .contact-form-wrapper {
    padding: 1.5rem;
  }
  
  .social-icons {
    justify-content: center;
  }
}
</style> 