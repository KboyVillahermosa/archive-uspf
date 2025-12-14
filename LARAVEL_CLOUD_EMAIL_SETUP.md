# Laravel Cloud Email Configuration Guide

## Problem
Email verification works locally but not on Laravel Cloud production server.

## Solution

Laravel Cloud requires you to configure email settings through environment variables. The `.env` file on your local machine won't be used on Laravel Cloud.

**⚠️ IMPORTANT:** If the UI doesn't allow editing environment variables, you must use the **Laravel Cloud API** (see Option 1A below).

## Step-by-Step Configuration

### Option 1A: Using Laravel Cloud API (If UI is Disabled)

If you cannot edit environment variables in the UI, use the API:

1. **Get Your API Token**
   - Go to Laravel Cloud dashboard → Your profile → "API Tokens"
   - Create a new token and copy it

2. **Find Your Environment ID**
   - Check the URL when viewing your environment, or use the API to list environments

3. **Set Variables via API** (see `LARAVEL_CLOUD_API_SETUP.md` for detailed instructions)

### Option 1B: Using SMTP via UI (If Available)

1. **Go to Laravel Cloud Dashboard**
   - Log into your Laravel Cloud account
   - Navigate to your application
   - Go to "Environment Variables" or "Settings" → "Environment"

2. **Add the following environment variables:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="USPF Research Archive"
```

**Important Notes:**
- If using Gmail, you MUST use an App Password (not your regular password)
- If your password contains spaces, wrap it in quotes: `MAIL_PASSWORD="your app password"`
- Replace `your_email@gmail.com` with your actual email address

### Option 2: Using Laravel Cloud's Built-in Mail Service

Laravel Cloud may have a built-in mail service. Check their documentation for:
- Mailgun integration
- Postmark integration
- SES integration

If available, you might only need:
```env
MAIL_MAILER=mailgun  # or postmark, ses, etc.
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="USPF Research Archive"
```

### Option 3: Using Resend (Modern Alternative)

If Laravel Cloud supports Resend:

1. Sign up at https://resend.com
2. Get your API key
3. Add to Laravel Cloud environment:
```env
MAIL_MAILER=resend
RESEND_KEY=re_your_api_key_here
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="USPF Research Archive"
```

## Verification Steps

After setting environment variables in Laravel Cloud:

1. **Clear config cache** (if Laravel Cloud allows SSH access):
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Test email sending** by registering a new user

3. **Check Laravel Cloud logs** for any email sending errors

## Common Issues

### Issue 1: Emails not sending
- **Check:** MAIL_MAILER is set (not 'log' or 'array')
- **Check:** All SMTP credentials are correct
- **Check:** App password is used (for Gmail)

### Issue 2: "Connection timeout" errors
- **Check:** MAIL_HOST is correct
- **Check:** MAIL_PORT matches encryption (587 for TLS, 465 for SSL)
- **Check:** Firewall allows outbound SMTP connections

### Issue 3: "Authentication failed" errors
- **Check:** MAIL_USERNAME is correct
- **Check:** MAIL_PASSWORD is correct (use App Password for Gmail)
- **Check:** 2FA is enabled on Gmail (required for App Passwords)

## Gmail App Password Setup

1. Go to https://myaccount.google.com/
2. Click "Security" → "2-Step Verification" (enable if not already)
3. Click "App passwords"
4. Select "Mail" and "Other (Custom name)"
5. Enter "Laravel Cloud" as the name
6. Copy the 16-character password
7. Use this password as `MAIL_PASSWORD` in Laravel Cloud

## Testing Locally vs Production

- **Local:** Uses `.env` file in your project
- **Laravel Cloud:** Uses environment variables set in their dashboard
- **Important:** These are separate configurations - changes to local `.env` don't affect production

## Quick Checklist

- [ ] Environment variables set in Laravel Cloud dashboard
- [ ] MAIL_MAILER is not 'log' or 'array'
- [ ] MAIL_FROM_ADDRESS matches your sending domain
- [ ] SMTP credentials are correct (if using SMTP)
- [ ] App Password used for Gmail (if using Gmail)
- [ ] Config cache cleared after changes
- [ ] Tested with a real registration

