<?php if (!defined('APPLICATION')) exit();

// Cache
saveToConfig('Cache.Enabled', true); # Toggle this to true/false to enable/disable caching.
saveToConfig('Cache.Method', 'memcached');
saveToConfig('Cache.Memcached.Store', ['memcached:11211']);

if (c('Cache.Enabled')) {
    if (class_exists('Memcached')) {
        saveToConfig('Cache.Memcached.Option.' . Memcached::OPT_COMPRESSION, true, false);
        saveToConfig('Cache.Memcached.Option.' . Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT, false);
        saveToConfig('Cache.Memcached.Option.' . Memcached::OPT_LIBKETAMA_COMPATIBLE, true, false);
        saveToConfig('Cache.Memcached.Option.' . Memcached::OPT_NO_BLOCK, true, false);
        saveToConfig('Cache.Memcached.Option.' . Memcached::OPT_TCP_NODELAY, true, false);
        saveToConfig('Cache.Memcached.Option.' . Memcached::OPT_CONNECT_TIMEOUT, 1000, false);
        saveToConfig('Cache.Memcached.Option.' . Memcached::OPT_SERVER_FAILURE_LIMIT, 2, false);
    } else {
        die('PHP is missing the Memcached extension.');
    }
}

// if (c('Garden.Installed')) { // I tried commenting this out
    saveToConfig('Debug', getenv('DEBUG'), false);
    saveToConfig('HotReload.Enabled', getenv('HOTRELOAD'), false);
    saveToConfig('Garden.UpdateToken', getenv('UPDATE_TOKEN'), false);

    saveToConfig('Database.Host', getenv('DB_HOSTNAME'), false);
    saveToConfig('Database.Name', getenv('DB_DATABASE'), false);
    saveToConfig('Database.User', getenv('DB_USERNAME'), false);
    saveToConfig('Database.Password', getenv('DB_PASSWORD'), false);

    saveToConfig('Garden.Cookie.Salt', getenv('COOKIE_SALT'), false); // I tried using a string instead of getenv here
    saveToConfig('Garden.Cookie.Domain', getenv('COOKIE_DOMAIN'), false);

    saveToConfig('Garden.Title', 'NEX Forum');
    // // saveToConfig('Garden.Themes.Visible', 'theme-foundation');
    //! theme Not work
    // saveToConfig('Garden.Theme', 'theme-nexfoundation');
    saveToConfig('Garden.EnabledLocales.vf_zh_TW', 'zh_TW');
    saveToConfig('Garden.Locale', 'zh_TW');

    saveToConfig('Garden.Email.SupportName', 'NEX Forum');
    saveToConfig('Garden.Email.SupportAddress', getenv('EMAIL_ADDRESS'), false);
    saveToConfig('Garden.Email.SmtpHost', getenv('SMTP_HOST'), false);
    saveToConfig('Garden.Email.SmtpUser', getenv('SMTP_USER'), false);
    saveToConfig('Garden.Email.SmtpPassword', getenv('PASSWORD_TOKEN'), false); # Get this in Gmail etc.
    saveToConfig('Garden.Email.Format', 'html');
    saveToConfig('Garden.Email.SmtpPort', '465');
    saveToConfig('Garden.Email.SmtpSecurity', 'ssl');
    saveToConfig('Garden.Email.OmitToName', 'false');
    // TODO: Replace these with getenv
    // saveToConfig('Garden.Email.SmtpPort', '465', false);
    // saveToConfig('Garden.Email.SmtpSecurity', 'ssl', false);

    // saveToConfig('Garden.Registration.CaptchaPrivateKey', 'YOUR KEY', false);
    // saveToConfig('Garden.Registration.CaptchaPublicKey', 'YOUR KEY', false);

    // }
