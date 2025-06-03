#!/bin/bash

# Reda Yahyani Portfolio - Deployment Script
# This script builds and deploys both frontend and backend

set -e

echo "🚀 Starting deployment process..."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if required tools are installed
check_dependencies() {
    print_status "Checking dependencies..."
    
    if ! command -v node &> /dev/null; then
        print_error "Node.js is not installed. Please install Node.js 18 or higher."
        exit 1
    fi
    
    if ! command -v npm &> /dev/null; then
        print_error "npm is not installed. Please install npm."
        exit 1
    fi
    
    if ! command -v firebase &> /dev/null; then
        print_warning "Firebase CLI is not installed. Installing..."
        npm install -g firebase-tools
    fi
    
    print_success "All dependencies are available."
}

# Deploy frontend to GitHub Pages
deploy_frontend() {
    print_status "Building and deploying frontend..."
    
    cd frontend
    
    # Install dependencies if node_modules doesn't exist
    if [ ! -d "node_modules" ]; then
        print_status "Installing frontend dependencies..."
        npm install
    fi
    
    # Build the project
    print_status "Building frontend..."
    npm run build
    
    # Deploy to GitHub Pages
    print_status "Deploying to GitHub Pages..."
    npm run deploy
    
    cd ..
    print_success "Frontend deployed to GitHub Pages!"
}

# Deploy backend to Firebase Functions
deploy_backend() {
    print_status "Deploying backend to Firebase Functions..."
    
    # Check if user is logged in to Firebase
    if ! firebase projects:list &> /dev/null; then
        print_warning "Please login to Firebase CLI first:"
        firebase login
    fi
    
    # Install function dependencies
    cd functions
    if [ ! -d "node_modules" ]; then
        print_status "Installing function dependencies..."
        npm install
    fi
    cd ..
    
    # Deploy functions and Firestore rules
    print_status "Deploying Firebase Functions and Firestore rules..."
    firebase deploy --only functions,firestore:rules
    
    print_success "Backend deployed to Firebase Functions!"
}

# Main deployment process
main() {
    print_status "🎯 Reda Yahyani Portfolio Deployment"
    print_status "======================================"
    
    check_dependencies
    
    # Parse command line arguments
    case "${1:-all}" in
        "frontend")
            deploy_frontend
            ;;
        "backend")
            deploy_backend
            ;;
        "all")
            deploy_backend
            deploy_frontend
            ;;
        "help")
            echo "Usage: $0 [frontend|backend|all|help]"
            echo "  frontend  - Deploy only the frontend to GitHub Pages"
            echo "  backend   - Deploy only the backend to Firebase Functions"
            echo "  all       - Deploy both frontend and backend (default)"
            echo "  help      - Show this help message"
            exit 0
            ;;
        *)
            print_error "Unknown argument: $1"
            echo "Use '$0 help' for usage information."
            exit 1
            ;;
    esac
    
    print_success "🎉 Deployment completed successfully!"
    print_status "Frontend: https://redayahyani.github.io/reda-yahyani-portfolio/"
    print_status "Backend: https://us-central1-YOUR_PROJECT_ID.cloudfunctions.net/api"
}

# Run main function with all arguments
main "$@" 