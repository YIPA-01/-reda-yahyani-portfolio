# 🚀 Deployment Guide

## Reda Yahyani Portfolio - Full Stack Deployment

This guide covers the complete deployment process for the Reda Yahyani Portfolio, which consists of:
- **Frontend**: Vue.js application deployed to GitHub Pages
- **Backend**: Node.js/Express API deployed to Firebase Functions
- **Database**: Cloud Firestore for data storage

## 📋 Prerequisites

### Required Tools
- **Node.js 18+** - [Download here](https://nodejs.org/)
- **npm** - Comes with Node.js
- **Git** - [Download here](https://git-scm.com/)
- **Firebase CLI** - Install with `npm install -g firebase-tools`

### Required Accounts
- **GitHub Account** - For frontend hosting
- **Firebase/Google Cloud Account** - For backend and database

## 🔧 Initial Setup

### 1. Firebase Project Setup

1. Go to [Firebase Console](https://console.firebase.google.com/)
2. Create a new project or select existing one
3. Enable the following services:
   - **Firestore Database**
   - **Cloud Functions**
   - **Authentication** (optional)
   - **Storage** (optional)

### 2. Get Firebase Configuration

1. In Firebase Console, go to **Project Settings** > **General**
2. Scroll down to **Your apps** section
3. Click **Add app** > **Web app** (</>) if not already created
4. Copy the Firebase configuration object

### 3. GitHub Repository Setup

1. Fork or create a repository on GitHub
2. Enable GitHub Pages in repository settings:
   - Go to **Settings** > **Pages**
   - Select **GitHub Actions** as source

## 🔑 Environment Configuration

### Frontend Environment Variables (.env in frontend/)
Create `frontend/.env` file:

```env
VITE_FIREBASE_API_KEY=your_api_key_here
VITE_FIREBASE_AUTH_DOMAIN=your_project_id.firebaseapp.com
VITE_FIREBASE_PROJECT_ID=your_project_id
VITE_FIREBASE_STORAGE_BUCKET=your_project_id.appspot.com
VITE_FIREBASE_MESSAGING_SENDER_ID=your_sender_id
VITE_FIREBASE_APP_ID=your_app_id
```

### GitHub Secrets Configuration

Add these secrets in GitHub repository settings (**Settings** > **Secrets and variables** > **Actions**):

```
VITE_FIREBASE_API_KEY
VITE_FIREBASE_AUTH_DOMAIN
VITE_FIREBASE_PROJECT_ID
VITE_FIREBASE_STORAGE_BUCKET
VITE_FIREBASE_MESSAGING_SENDER_ID
VITE_FIREBASE_APP_ID
FIREBASE_SERVICE_ACCOUNT_KEY (JSON format)
FIREBASE_TOKEN (from firebase login:ci)
```

## 🚢 Deployment Methods

### Method 1: Automated Deployment (Recommended)

**GitHub Actions** automatically deploy when you push to the main branch:

1. **Frontend**: Triggered by changes in `frontend/` directory
2. **Backend**: Triggered by changes in `functions/`, `firebase.json`, or `firestore.*`

### Method 2: Manual Deployment

Use the provided deployment script:

```bash
# Deploy everything
./deploy.sh

# Deploy only frontend
./deploy.sh frontend

# Deploy only backend
./deploy.sh backend

# Show help
./deploy.sh help
```

### Method 3: Individual Component Deployment

#### Frontend Only
```bash
cd frontend
npm install
npm run build
npm run deploy
```

#### Backend Only
```bash
firebase login
firebase deploy --only functions,firestore:rules
```

## 📊 Firebase Functions Setup

### 1. Install Dependencies
```bash
cd functions
npm install
```

### 2. Configure Firebase Project
```bash
firebase login
firebase use your_project_id
```

### 3. Deploy Functions
```bash
firebase deploy --only functions
```

## 🔐 Firestore Security Rules

The project includes comprehensive security rules in `firestore.rules`:

- **Public read access** to portfolio data (projects, skills, education) where `is_visible = true`
- **Authenticated write access** for admin users
- **Public message creation** through contact form
- **Admin-only access** to messages collection

## 🌐 Frontend GitHub Pages Setup

### 1. Build Configuration
The frontend is configured for GitHub Pages deployment with:
- Base path: `/reda-yahyani-portfolio/`
- Output directory: `dist/`
- Asset optimization for production

### 2. Custom Domain (Optional)
To use a custom domain:
1. Add `CNAME` file to `frontend/public/` with your domain
2. Configure DNS records for your domain
3. Enable HTTPS in GitHub Pages settings

## 🔍 Monitoring and Troubleshooting

### Logs and Monitoring
- **Frontend**: GitHub Pages build logs in Actions tab
- **Backend**: Firebase Functions logs in Firebase Console
- **Database**: Firestore usage monitoring in Firebase Console

### Common Issues

#### Frontend Build Failures
```bash
# Check Node.js version
node --version  # Should be 18+

# Clear cache and reinstall
cd frontend
rm -rf node_modules package-lock.json
npm install
```

#### Backend Deploy Failures
```bash
# Check Firebase CLI login
firebase projects:list

# Redeploy specific function
firebase deploy --only functions:api
```

#### CORS Issues
Ensure your production domain is added to the CORS whitelist in `functions/index.js`.

## 📈 Performance Optimization

### Frontend Optimizations
- **Vite build optimization** with code splitting
- **Asset optimization** with proper caching headers
- **PWA support** (can be added)

### Backend Optimizations
- **Cold start reduction** using Firebase Functions warm-up
- **Caching strategies** for frequent queries
- **Firestore query optimization**

## 🔄 Continuous Integration

The project includes two GitHub Actions workflows:

1. **Frontend CI/CD** (`.github/workflows/deploy-frontend.yml`)
2. **Backend CI/CD** (`.github/workflows/deploy-backend.yml`)

Both workflows include:
- Dependency installation
- Build process
- Automated testing (can be extended)
- Deployment to respective platforms

## 📞 Support

For deployment issues:

1. Check the [troubleshooting section](#-monitoring-and-troubleshooting)
2. Review GitHub Actions logs
3. Check Firebase Functions logs
4. Verify environment variables and secrets

## 🎯 Live URLs

After successful deployment:

- **Frontend**: `https://YOUR_USERNAME.github.io/reda-yahyani-portfolio/`
- **Backend API**: `https://us-central1-YOUR_PROJECT_ID.cloudfunctions.net/api`
- **Health Check**: `https://us-central1-YOUR_PROJECT_ID.cloudfunctions.net/api/health`

---

*Last updated: 2024* 