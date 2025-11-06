# Change: Setup Tailwind CSS

## Why
The project needs Tailwind CSS configured and working to enable utility-first styling in Blade templates. While Tailwind is already configured in `package.json` and `vite.config.js`, the packages need to be installed and verified with a test page.

## What Changes
- Install Tailwind CSS and related npm packages
- Verify Tailwind CSS compilation works with Vite
- Create a dummy Blade page demonstrating Tailwind classes
- Ensure Tailwind classes are properly processed and rendered

## Impact
- Affected specs: `frontend-styling` (new capability)
- Affected code: 
  - `package.json` (dependencies already present)
  - `vite.config.js` (already configured)
  - `resources/css/app.css` (already has Tailwind imports)
  - New: `resources/views/test-tailwind.blade.php` (test page)
  - New: Route in `routes/web.php` for test page

