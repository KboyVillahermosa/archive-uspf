# How to Find API Token in Laravel Cloud

## Direct Links to Try:

1. **Account Settings:**
   ```
   https://cloud.laravel.com/account
   https://app.laravel.cloud/account
   ```

2. **API Tokens (Direct):**
   ```
   https://cloud.laravel.com/account/api-tokens
   https://app.laravel.cloud/account/api-tokens
   ```

3. **Settings:**
   ```
   https://cloud.laravel.com/settings
   https://app.laravel.cloud/settings
   ```

## Step-by-Step Visual Guide:

1. **Log into Laravel Cloud:**
   - Go to: https://cloud.laravel.com or https://app.laravel.cloud

2. **Look for Your Profile:**
   - Top-right corner of the page
   - Click on your profile picture/icon or your name

3. **Check the Dropdown Menu:**
   - Look for: "Account Settings", "Settings", "Profile", or "API"
   - Click on it

4. **Find API Section:**
   - Look for tabs or sections named:
     - "API Tokens"
     - "API Access"
     - "API Keys"
     - "Developer" or "Developer Tools"

## If You Still Can't Find It:

### Option 1: Contact Laravel Cloud Support
- **Email:** support@laravel.com
- **Support Chat:** Look for a "Help" or "Support" button in the dashboard
- **Message:** "I need to create an API token to set environment variables for email configuration. Where can I find the API token section?"

### Option 2: Check Your Account Type
- API tokens might only be available for:
  - Account owners
  - Users with admin permissions
  - Paid plans (not free tier)
- If you're on a team, ask your team admin

### Option 3: Use Laravel Cloud Commands Tab
1. Go to your project in Laravel Cloud
2. Click on the **"Commands"** tab
3. Try running: `php artisan tinker`
4. Then check: `config('mail')` to see current mail settings
5. **Note:** This won't let you set environment variables, but you can verify what's configured

### Option 4: Check Laravel Cloud Documentation
- Visit: https://cloud.laravel.com/docs
- Search for: "API tokens" or "environment variables"

## What to Do Once You Have the Token:

1. Create a new token
2. Give it a name like "Email Configuration"
3. Copy the token immediately (you won't see it again!)
4. Use it in the API command (see `LARAVEL_CLOUD_API_SETUP.md`)

## Still Stuck?

If none of these work, the best option is to **contact Laravel Cloud support directly**. They can:
- Guide you to the exact location
- Create the token for you
- Help you set environment variables through their system
- Explain if your account type doesn't support API tokens

