# Frontend Deployment Guide

This guide covers deploying your Vue.js portfolio frontend to GitHub Pages.

## 🚀 Quick Deployment

### Prerequisites
- ✅ Firebase backend deployed and running
- ✅ GitHub repository created
- ✅ Node.js 18+ installed

### 1. Setup Firebase Environment Variables

In your GitHub repository, go to **Settings → Secrets and variables → Actions** and add these repository secrets:

```
VITE_FIREBASE_API_KEY=your_api_key_here
VITE_FIREBASE_AUTH_DOMAIN=your_project.firebaseapp.com
VITE_FIREBASE_PROJECT_ID=your_project_id
VITE_FIREBASE_STORAGE_BUCKET=your_project.appspot.com
VITE_FIREBASE_MESSAGING_SENDER_ID=your_sender_id
VITE_FIREBASE_APP_ID=your_app_id
```

### 2. Enable GitHub Pages

1. Go to your repository **Settings → Pages**
2. Under **Source**, select **Deploy from a branch**
3. Select **gh-pages** branch (will be created after first deployment)
4. Click **Save**

### 3. Deploy

Push to the main branch:

```bash
git add .
git commit -m "Deploy frontend to GitHub Pages"
git push origin main
```

The GitHub Action will automatically:
- ✅ Install dependencies
- ✅ Build the Vue.js app
- ✅ Deploy to GitHub Pages
- ✅ Your site will be live at: `https://yourusername.github.io/reda-yahyani-portfolio/`

## 🛠️ Manual Deployment

If you prefer to deploy manually:

```bash
cd frontend

# Install dependencies
npm install

# Build for production
npm run build

# Deploy to GitHub Pages (if you have gh-pages installed)
npx gh-pages -d dist
```

## 🔧 Configuration

### Update Repository Name

In `vite.config.js`, make sure the base path matches your repository name:

```javascript
export default defineConfig({
  base: '/reda-yahyani-portfolio/', // Change this to your repo name
  // ... rest of config
})
```

### Environment Variables

Create a `.env` file in the frontend directory:

```env
VITE_FIREBASE_API_KEY=your_api_key
VITE_FIREBASE_AUTH_DOMAIN=your_project.firebaseapp.com
VITE_FIREBASE_PROJECT_ID=your_project_id
VITE_FIREBASE_STORAGE_BUCKET=your_project.appspot.com
VITE_FIREBASE_MESSAGING_SENDER_ID=your_sender_id
VITE_FIREBASE_APP_ID=your_app_id
```

## 📝 Available Scripts

```bash
# Development server
npm run dev

# Build for production
npm run build

# Preview production build
npm run preview

# Deploy to GitHub Pages
npm run deploy
```

## 🎯 Architecture

```
Frontend (GitHub Pages)
├── Vue.js SPA
├── Firebase Client SDK
├── Static Assets
└── PWA Features

Backend (Firebase/Your Server)
├── Laravel API
├── Firestore Database
├── Firebase Functions
└── File Storage
```

## 🔍 Troubleshooting

### Build Fails
- Check all environment variables are set
- Ensure Firebase config is correct
- Verify all dependencies are installed

### 404 Errors
- Check the base path in `vite.config.js`
- Ensure repository name matches base path
- Verify GitHub Pages is enabled

### Firebase Connection Issues
- Verify environment variables in GitHub Secrets
- Check Firebase project settings
- Ensure Firebase rules allow read access

### Routing Issues
- Vue Router is configured for hash mode for GitHub Pages
- All routes should work without server configuration

## 🚀 Custom Domain (Optional)

To use a custom domain:

1. Add a `CNAME` file to the `public` directory:
   ```
   yourdomain.com
   ```

2. Update your domain's DNS settings to point to GitHub Pages

3. Enable "Enforce HTTPS" in repository settings

## 📊 Performance Tips

1. **Optimize Images**: Use WebP format when possible
2. **Lazy Loading**: Components are already set up for lazy loading
3. **CDN**: GitHub Pages automatically provides CDN
4. **Caching**: Built-in browser caching for static assets

## 🔐 Security

- All sensitive data is stored in environment variables
- Firebase security rules protect your data
- HTTPS is enforced by GitHub Pages
- No server-side secrets exposed in frontend

## 🎉 Success!

Your portfolio should now be live at:
**https://yourusername.github.io/reda-yahyani-portfolio/**

The site will automatically update whenever you push changes to the main branch.

## 📞 Need Help?

Common issues and solutions:
- **White screen**: Check browser console for errors
- **API errors**: Verify Firebase configuration
- **Deployment fails**: Check GitHub Actions logs
- **Styles missing**: Clear browser cache

Your frontend is now deployed and connected to your Firebase backend! 🎊 