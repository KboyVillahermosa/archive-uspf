# Alternative: Using Resend Email Service

If setting SMTP via API is too complex, you can use **Resend** - a modern email service that's easier to configure.

## Why Resend?
- Only needs ONE API key (simpler than SMTP)
- Free tier: 3,000 emails/month
- Better deliverability than Gmail SMTP
- Works great with Laravel

## Setup Steps

### 1. Sign up for Resend
- Go to https://resend.com
- Sign up for a free account
- Verify your email

### 2. Get Your API Key
- In Resend dashboard, go to "API Keys"
- Create a new API key
- Copy it (starts with `re_`)

### 3. Add Domain (Optional but Recommended)
- In Resend, go to "Domains"
- Add your domain (e.g., `uspf.edu.ph` or use Resend's domain for testing)
- Verify DNS records

### 4. Set Environment Variables via Laravel Cloud API

```bash
curl --request POST \
  --url https://app.laravel.cloud/api/environments/{ENVIRONMENT_ID}/variables \
  --header 'Authorization: Bearer YOUR_API_TOKEN' \
  --header 'Content-Type: application/json' \
  --data '{
  "method": "append",
  "variables": [
    {
      "key": "MAIL_MAILER",
      "value": "resend"
    },
    {
      "key": "RESEND_KEY",
      "value": "re_your_api_key_here"
    },
    {
      "key": "MAIL_FROM_ADDRESS",
      "value": "noreply@yourdomain.com"
    },
    {
      "key": "MAIL_FROM_NAME",
      "value": "USPF Research Archive"
    }
  ]
}'
```

### 5. Redeploy Your Application

After setting variables, redeploy for changes to take effect.

## Benefits
- ✅ Simpler setup (only 1 API key vs 6 SMTP settings)
- ✅ Better deliverability
- ✅ Free tier is generous
- ✅ No need for Gmail App Passwords

