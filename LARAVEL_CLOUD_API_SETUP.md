# Laravel Cloud Email Setup via API

Since the UI doesn't allow editing environment variables, you can use the Laravel Cloud API.

## Step 1: Get Your API Token

### Try These Direct Links:

1. **Account Settings (Most Common Location):**
   - Direct link: `https://cloud.laravel.com/account` or `https://app.laravel.cloud/account`
   - Look for "API Tokens" or "API Access" section

2. **Profile Dropdown:**
   - Click your profile icon/name (top-right corner)
   - Select "Account Settings" or "Settings"
   - Look for "API Tokens" tab or section

3. **Alternative Locations to Check:**
   - `https://cloud.laravel.com/account/api-tokens`
   - `https://app.laravel.cloud/account/api-tokens`
   - `https://cloud.laravel.com/settings/api`
   - `https://app.laravel.cloud/settings/api`

### If You Still Can't Find It:

**Option A: Contact Laravel Cloud Support**
- Email: support@laravel.com
- Or use the support chat in the dashboard
- Ask: "How do I create an API token to set environment variables?"

**Option B: Check Your Account Permissions**
- Your account might need admin/owner permissions
- Contact your team admin if you're not the account owner

**Option C: Use Alternative Method (See Below)**
- If API tokens aren't available, we can try using the Commands tab or contact support

## Step 2: Find Your Environment ID

1. In Laravel Cloud, go to your project
2. Click on the "Environment" tab
3. Look at the URL - it should contain your environment ID
4. Or check the API documentation for how to list environments

## Step 3: Set Email Variables via API

Use this command (replace the placeholders):

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
      "value": "smtp"
    },
    {
      "key": "MAIL_HOST",
      "value": "smtp.gmail.com"
    },
    {
      "key": "MAIL_PORT",
      "value": "587"
    },
    {
      "key": "MAIL_USERNAME",
      "value": "your_email@gmail.com"
    },
    {
      "key": "MAIL_PASSWORD",
      "value": "ihis banf ovnc bvbb"
    },
    {
      "key": "MAIL_ENCRYPTION",
      "value": "tls"
    },
    {
      "key": "MAIL_FROM_ADDRESS",
      "value": "your_email@gmail.com"
    },
    {
      "key": "MAIL_FROM_NAME",
      "value": "USPF Research Archive"
    }
  ]
}'
```

**Important:** Replace:
- `{ENVIRONMENT_ID}` with your actual environment ID
- `YOUR_API_TOKEN` with your API token
- `your_email@gmail.com` with your actual Gmail address

## Step 4: Redeploy

After setting the variables, you must redeploy your application for changes to take effect.

