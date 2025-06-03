# ⚡ Quick Start Guide

## Get Your Portfolio Live in 15 Minutes

### 🏁 Prerequisites Check

```bash
# Check if you have the required tools
node --version    # Should be 18+
npm --version     # Should be 8+
git --version     # Any recent version
```

If any are missing, install them first.

### 1️⃣ Firebase Setup (5 minutes)

1. **Create Firebase Project**
   - Go to [Firebase Console](https://console.firebase.google.com/)
   - Click "Create a project" or use existing one
   - Enable Firestore Database (Native mode)
   - Enable Cloud Functions

2. **Get Firebase Config**
   - Go to Project Settings ⚙️
   - Scroll to "Your apps" → Add Web App
   - Copy the config object (you'll need this soon)

3. **Install Firebase CLI**
   ```bash
   npm install -g firebase-tools
   firebase login
   ```

### 2️⃣ GitHub Setup (2 minutes)

1. **Fork/Clone this repository**
2. **Enable GitHub Pages**
   - Go to repository Settings → Pages
   - Source: "GitHub Actions"

### 3️⃣ Environment Configuration (3 minutes)

1. **Create frontend environment file**
   ```bash
   cp frontend/.env.example frontend/.env
   ```

2. **Edit `frontend/.env`** with your Firebase config:
   ```env
   VITE_FIREBASE_API_KEY=your_actual_api_key
   VITE_FIREBASE_AUTH_DOMAIN=your_project_id.firebaseapp.com
   VITE_FIREBASE_PROJECT_ID=your_actual_project_id
   VITE_FIREBASE_STORAGE_BUCKET=your_project_id.appspot.com
   VITE_FIREBASE_MESSAGING_SENDER_ID=your_actual_sender_id
   VITE_FIREBASE_APP_ID=your_actual_app_id
   ```

3. **Configure Firebase project**
   ```bash
   firebase use your_project_id
   ```

### 4️⃣ Deploy Backend (2 minutes)

```bash
# Install dependencies and deploy
cd functions
npm install
cd ..
firebase deploy --only functions,firestore:rules
```

### 5️⃣ Deploy Frontend (3 minutes)

```bash
cd frontend
npm install
npm run build
npm run deploy
```

## 🎉 You're Live!

Your portfolio is now available at:
- **Frontend**: `https://YOUR_USERNAME.github.io/reda-yahyani-portfolio/`
- **API**: `https://us-central1-YOUR_PROJECT_ID.cloudfunctions.net/api/health`

## 🔧 Quick Test

Test your deployment:

```bash
# Test backend health
curl https://us-central1-YOUR_PROJECT_ID.cloudfunctions.net/api/health

# Should return: {"status":"ok","message":"Firebase Functions API is running"}
```

## 🚀 Automated Deployments

After initial setup, deployments are automatic:
- **Push to main** → Triggers deployment
- **Frontend changes** in `frontend/` → Redeploys frontend
- **Backend changes** in `functions/` → Redeploys backend

## 🛠️ One-Command Deployment

For future deployments, just run:

```bash
./deploy.sh
```

## ❌ Troubleshooting

### "Firebase project not found"
```bash
firebase projects:list
firebase use your_correct_project_id
```

### "Permission denied on GitHub Pages"
- Check repository Settings → Actions → General
- Ensure "Read and write permissions" are enabled

### "Frontend build fails"
```bash
cd frontend
rm -rf node_modules package-lock.json
npm install
```

### "Functions deployment fails"
```bash
firebase login --reauth
firebase deploy --only functions --debug
```

## 📝 Next Steps

1. **Customize content** in Firestore database
2. **Update GitHub secrets** for automated deployments
3. **Add custom domain** (optional)
4. **Set up monitoring** in Firebase Console

---

**Need help?** Check the full [DEPLOYMENT.md](./DEPLOYMENT.md) guide or open an issue.

**Estimated setup time**: 15 minutes for first deployment, 2 minutes for subsequent deployments. 