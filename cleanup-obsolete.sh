#!/bin/bash
# Cleanup script - Remove obsolete deployment files

echo "🧹 Cleaning up obsolete deployment files..."
echo "These files are no longer needed with Git-based workflow:"
echo ""

# Files to remove
FILES_TO_REMOVE=(
    "deploy-staging.sh"
    "deploy-staging-fixed.sh" 
    "deploy-staging-password.sh"
    "deploy-scp.sh"
    "check-remote.sh"
    "ssh-debug.sh"
    "manual-deploy-instructions.sh"
    "ftp-deployment-setup.sh"
    "git-deploy-server.sh"
    "test.txt"
    "MANUAL-DEPLOYMENT.md"
    "deployment-alternatives.md"
)

# Directory to remove
DIRS_TO_REMOVE=(
    "deploy-files"
)

echo "Files to be removed:"
for file in "${FILES_TO_REMOVE[@]}"; do
    if [ -f "$file" ]; then
        echo "  ❌ $file"
    fi
done

echo ""
echo "Directories to be removed:"
for dir in "${DIRS_TO_REMOVE[@]}"; do
    if [ -d "$dir" ]; then
        echo "  📁❌ $dir/ (contains backup copies of theme files)"
    fi
done

echo ""
echo "🔧 Files to keep (still useful):"
echo "  ✅ dev-workflow.sh (your main development script)"
echo "  ✅ WORKFLOW-REFERENCE.md (documentation)"
echo ""

read -p "Remove these obsolete files? (y/N): " confirm

if [[ $confirm =~ ^[Yy]$ ]]; then
    echo ""
    echo "🗑️ Removing obsolete files..."
    
    for file in "${FILES_TO_REMOVE[@]}"; do
        if [ -f "$file" ]; then
            rm "$file"
            echo "  ✅ Removed $file"
        fi
    done
    
    for dir in "${DIRS_TO_REMOVE[@]}"; do
        if [ -d "$dir" ]; then
            rm -rf "$dir"
            echo "  ✅ Removed $dir/"
        fi
    done
    
    echo ""
    echo "🎉 Cleanup complete!"
    echo "💡 Your theme directory is now cleaner and ready for Git workflow."
    echo ""
    echo "📋 Next steps:"
    echo "1. Commit these changes: git add . && git commit -m 'Clean up obsolete deployment files'"
    echo "2. Push to GitHub: git push origin main"
    echo "3. Deploy to staging: ./dev-workflow.sh (option 2)"
    
else
    echo "❌ Cleanup cancelled. Files remain unchanged."
fi
