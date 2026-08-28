# Cloudflare deploy

1. Install cloudflared.
2. Login: cloudflared tunnel login
3. Create tunnel: cloudflared tunnel create dont-forget
4. Put credentials file path into cloudflared/config.yml
5. Point hostname to tunnel: cloudflared tunnel route dns dont-forget your-domain.com
6. Run app locally: php artisan serve --host=127.0.0.1 --port=8000
7. Run tunnel: cloudflared tunnel run dont-forget

Production notes:
- set APP_ENV=production
- set APP_DEBUG=false
- set APP_URL to https://your-domain.com
- keep DB_CONNECTION=sqlite only for small single-server setup
- use database/queue/cache drivers if server already supports them
