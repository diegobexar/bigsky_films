# Big Sky Pictures - Development Workflow Quick Reference

## 🎯 Problem Solved!
✅ **CSS 404 Error**: Fixed by deploying theme via Git  
✅ **Deployment Method**: Git-based workflow established  
✅ **SSH Issues**: Bypassed by using HTTPS Git clone  

## 🚀 Daily Development Workflow

### 1. Local Development
```bash
# Work on your theme in Local by Flywheel
# Make changes to files, test locally
```

### 2. Commit Changes
```bash
cd /Users/bexar/Local\ Sites/big-sky-pictures/app/public/wp-content/themes/big-sky-pictures/

# Use the workflow script
./dev-workflow.sh

# Or manually:
git add .
git commit -m "Your commit message"
git push origin main
```

### 3. Deploy to Staging
```bash
# Use the workflow script (option 2)
./dev-workflow.sh

# Or manually via SSH:
ssh bigsky_dev@staging-bigsky.montanux.com
cd /home/bigsky_dev/staging-bigsky.montanux.com/wp-content/themes/big-sky-pictures
git pull origin main
```

### 4. Verify Deployment
- **Staging Site**: https://staging-bigsky.montanux.com
- **Admin**: https://staging-bigsky.montanux.com/wp-admin/

## 🔧 Key File Locations

### Local Development:
```
/Users/bexar/Local Sites/big-sky-pictures/app/public/wp-content/themes/big-sky-pictures/
```

### Staging Server:
```
/home/bigsky_dev/staging-bigsky.montanux.com/wp-content/themes/big-sky-pictures/
```

### GitHub Repository:
```
https://github.com/diegobexar/bigsky_films.git
```

## 🎬 Workflow Scripts

- **`./dev-workflow.sh`** - Interactive development workflow
- **`git-deploy-server.sh`** - Server-side deployment script
- **`MANUAL-DEPLOYMENT.md`** - Backup manual deployment instructions

## 🆘 Troubleshooting

### If Git deployment fails:
1. Check SSH connection: `ssh bigsky_dev@staging-bigsky.montanux.com`
2. Verify Git repo: `cd theme-directory && git status`
3. Manual pull: `git pull origin main`

### If CSS still shows 404:
1. Verify theme activation in WordPress admin
2. Check file permissions on server
3. Test direct file access: `curl -I https://staging-bigsky.montanux.com/wp-content/themes/big-sky-pictures/style.css`

### Alternative deployment methods:
- WordPress admin theme upload
- FTP/SFTP deployment
- Manual file copy via SSH

## 🎉 Success Indicators

✅ `curl -I ...style.css` returns `HTTP/2 200`  
✅ Staging site loads with proper styling  
✅ Git pull on server works without errors  
✅ WordPress recognizes "Big Sky Pictures" theme  

---

**Next Steps:**
1. Test the complete workflow with a small change
2. Set up client review process with staging URL
3. Plan production deployment strategy
