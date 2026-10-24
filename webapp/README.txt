EZZZ STARS — сайт / Telegram Mini App для GitHub Pages

1. Загрузите index.html, style.css, app.js и config.js В КОРЕНЬ репозитория GitHub Pages.
2. Settings -> Pages -> Deploy from branch -> main / (root).
3. Откройте https://lacven.github.io/ и обновите страницу Ctrl+F5.
4. Без Telegram сайт показывает красивую публичную страницу и кнопку открытия бота.
5. Для реальных данных Mini App необходим работающий API из серверного bot.py.
6. Если API находится на другом домене, укажите его HTTPS-адрес в config.js и настройте CORS на API-сервере. Не размещайте токен Telegram-бота или ключи API в GitHub.
7. На GitHub Pages SQLite/Python не работают. URL в кнопке WebApp бота должен вести на этот сайт. Telegram initData необходимо проверять на API-сервере.

Важно: это обновлённый фронтенд, а не автономный сервер с начислением звёзд. При API на другом домене endpoint /api/image/... также должен быть доступен.
