#!/bin/bash
# Big Sky Pictures - Git-based Development Workflow

echo "🎬 Big Sky Pictures Development Workflow"
echo "========================================="
echo ""

# Check if we're in the right directory
if [ ! -f "style.css" ]; then
    echo "❌ Please run this script from the theme directory"
    echo "   Expected: /Users/bexar/Local Sites/big-sky-pictures/app/public/wp-content/themes/big-sky-pictures/"
    exit 1
fi

echo "📂 Current directory: $(pwd)"
echo "📋 Git status:"
git status --short

echo ""
echo "🔄 Development Actions:"
echo "1. 📝 Commit and push changes to GitHub"
echo "2. 🚀 Deploy latest changes to staging"
echo "3. 📊 Check Git status and recent commits"
echo "4. 🌐 Open staging site"
echo "5. 🔗 Open local site"
echo "6. 🏠 Exit"

read -p "Choose an action (1-6): " choice

case $choice in
    1)
        echo ""
        echo "📝 Preparing to commit changes..."
        git status
        echo ""
        read -p "Enter commit message: " message
        
        if [ -z "$message" ]; then
            echo "❌ Commit message cannot be empty"
            exit 1
        fi
        
        git add .
        git commit -m "$message"
        git push origin main
        echo "✅ Changes committed and pushed to GitHub!"
        echo "📌 Next step: Run option 2 to deploy to staging"
        ;;
    2)
        echo ""
        echo "🚀 Deploying latest changes to staging server..."
        echo "   This will run 'git pull' on the staging server"
        echo ""
        
        ssh bigsky_dev@staging-bigsky.montanux.com "cd /home/bigsky_dev/staging-bigsky.montanux.com/wp-content/themes/big-sky-pictures && git pull origin main && echo '✅ Staging deployment complete!'"
        
        echo ""
        echo "🔍 Verifying deployment..."
        sleep 2
        curl -I "https://staging-bigsky.montanux.com/wp-content/themes/big-sky-pictures/style.css" 2>/dev/null | head -1
        echo "🌐 Staging site: https://staging-bigsky.montanux.com"
        ;;
    3)
        echo ""
        echo "📊 Git Repository Status:"
        echo "========================"
        echo "🌿 Current branch:"
        git branch --show-current
        echo ""
        echo "📋 Status:"
        git status
        echo ""
        echo "📝 Recent commits:"
        git log --oneline -5
        echo ""
        echo "🔗 Remote repository:"
        git remote -v
        ;;
    4)
        echo "🌐 Opening staging site..."
        open https://staging-bigsky.montanux.com
        ;;
    5)
        echo "🏠 Opening local development site..."
        # Try to find Local by Flywheel live link or use localhost
        if [ -f ".localwp-live-link" ]; then
            open $(cat .localwp-live-link)
        else
            echo "🔍 Local site URL not found. Check Local by Flywheel for live link."
        fi
        ;;
    6)
        echo "👋 Happy coding!"
        exit 0
        ;;
    *)
        echo "❌ Invalid choice. Please select 1-6."
        ;;
esac
