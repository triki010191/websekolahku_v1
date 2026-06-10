<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

/**
 * URL untuk file di disk public, atau URL absolut (http/https) untuk data lama / eksternal.
 */
if (! function_exists('public_storage_url')) {
    function public_storage_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }
        if (preg_match('#^https?://#i', $path) === 1) {
            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
    }
}

if (! function_exists('storage_file_exists')) {
    function storage_file_exists(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        return is_file(storage_path('app/public/'.ltrim($path, '/')));
    }
}

if (! function_exists('public_asset_url')) {
    /** URL file statis di folder public/ jika ada di server. */
    function public_asset_url(string $path): ?string
    {
        $path = ltrim($path, '/');
        if (! is_file(public_path($path))) {
            return null;
        }

        return asset($path);
    }
}

if (! function_exists('youtube_channel_url')) {
    function youtube_channel_url(): string
    {
        $url = trim((string) setting('youtube_channel_url', ''));
        if ($url !== '') {
            return $url;
        }

        $handle = ltrim((string) setting('social_youtube', '@SMKN8PANDEGLANG'), '@');

        return 'https://www.youtube.com/@'.$handle;
    }
}

if (! function_exists('youtube_channel_id')) {
    function youtube_channel_id(): ?string
    {
        $configured = trim((string) setting('youtube_channel_id', ''));
        if (preg_match('/^UC[\w-]{22}$/', $configured) === 1) {
            return $configured;
        }

        return \Illuminate\Support\Facades\Cache::remember('youtube.channel_id', 86400, function () {
            $url = youtube_channel_url();
            $path = (string) parse_url($url, PHP_URL_PATH);
            $handle = ltrim($path, '/@');
            if ($handle === '') {
                return null;
            }

            $html = @file_get_contents('https://www.youtube.com/@'.rawurlencode($handle));
            if (! is_string($html)) {
                return null;
            }

            if (preg_match('/"channelId":"(UC[^"]+)"/', $html, $matches)) {
                return $matches[1];
            }

            return null;
        });
    }
}

if (! function_exists('youtube_featured_video_id')) {
    function youtube_featured_video_id(): ?string
    {
        $raw = trim((string) setting('youtube_featured_video', ''));
        if ($raw === '') {
            return null;
        }

        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $raw) === 1) {
            return $raw;
        }

        if (preg_match('/(?:v=|\/embed\/|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $raw, $matches)) {
            return $matches[1];
        }

        return null;
    }
}

if (! function_exists('youtube_featured_watch_url')) {
    function youtube_featured_watch_url(): ?string
    {
        $videoId = youtube_featured_video_id();

        return $videoId ? 'https://www.youtube.com/watch?v='.$videoId : null;
    }
}

if (! function_exists('youtube_latest_video_id')) {
    function youtube_latest_video_id(): ?string
    {
        $channelId = youtube_channel_id();
        if (! $channelId) {
            return null;
        }

        return \Illuminate\Support\Facades\Cache::remember('youtube.latest_video.'.$channelId, 3600, function () use ($channelId) {
            $xml = @simplexml_load_file('https://www.youtube.com/feeds/videos.xml?channel_id='.$channelId);
            if ($xml === false || ! isset($xml->entry[0])) {
                return null;
            }

            $yt = $xml->entry[0]->children('http://www.youtube.com/xml/schemas/2015');
            $id = (string) ($yt->videoId ?? '');

            return $id !== '' ? $id : null;
        });
    }
}

if (! function_exists('youtube_embed_url')) {
    function youtube_embed_url(): ?string
    {
        $videoId = youtube_featured_video_id() ?? youtube_latest_video_id();
        if ($videoId) {
            return 'https://www.youtube-nocookie.com/embed/'.$videoId.'?rel=0&modestbranding=1';
        }

        $channelId = youtube_channel_id();
        if ($channelId) {
            $uploadsList = 'UU'.substr($channelId, 2);

            return 'https://www.youtube-nocookie.com/embed/videoseries?list='.$uploadsList.'&rel=0&modestbranding=1';
        }

        return null;
    }
}

if (! function_exists('instagram_profile_url')) {
    function instagram_profile_url(): string
    {
        $url = trim((string) setting('instagram_profile_url', ''));
        if ($url !== '') {
            return rtrim($url, '/');
        }

        $handle = ltrim((string) setting('social_instagram', 'smkn8pandeglang_official'), '@');

        return 'https://www.instagram.com/'.$handle;
    }
}

if (! function_exists('instagram_username')) {
    function instagram_username(): string
    {
        $path = (string) parse_url(instagram_profile_url(), PHP_URL_PATH);

        return ltrim($path, '/@') ?: 'smkn8pandeglang_official';
    }
}

if (! function_exists('instagram_profile_embed_url')) {
    function instagram_profile_embed_url(): string
    {
        return instagram_profile_url().'/embed';
    }
}

if (! function_exists('instagram_normalize_post_url')) {
    function instagram_normalize_post_url(string $url): string
    {
        if (preg_match('#^https?://(www\.)?instagram\.com/(p|reel|reels|tv)/([A-Za-z0-9_-]+)#i', trim($url), $matches) === 1) {
            return 'https://www.instagram.com/'.$matches[2].'/'.$matches[3].'/';
        }

        return rtrim(strtok(trim($url), '?'), '/').'/';
    }
}

if (! function_exists('instagram_post_urls')) {
    /** @return list<string> */
    function instagram_post_urls(int $limit = 9): array
    {
        $raw = trim((string) setting('instagram_post_urls', ''));
        if ($raw === '') {
            return [];
        }

        $urls = [];
        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            if (preg_match('#^https?://(www\.)?instagram\.com/(p|reel|reels|tv)/[A-Za-z0-9_-]+#i', $line) === 1) {
                $urls[] = instagram_normalize_post_url($line);
            }
        }

        return array_slice(array_values(array_unique($urls)), 0, $limit);
    }
}

if (! function_exists('instagram_post_embed_url')) {
    function instagram_post_embed_url(string $postUrl): string
    {
        return rtrim(instagram_normalize_post_url($postUrl), '/').'/embed';
    }
}

if (! function_exists('instagram_post_thumbnail_url')) {
    function instagram_post_thumbnail_url(string $postUrl): ?string
    {
        $postUrl = instagram_normalize_post_url($postUrl);

        return \Illuminate\Support\Facades\Cache::remember('instagram.thumb.'.md5($postUrl), 43200, function () use ($postUrl) {
            $context = stream_context_create([
                'http' => [
                    'header' => "User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)\r\nAccept-Language: en\r\n",
                    'timeout' => 12,
                    'follow_location' => 1,
                ],
            ]);

            $html = @file_get_contents($postUrl, false, $context);
            if (is_string($html) && preg_match('/property="og:image" content="([^"]+)"/', $html, $matches)) {
                return html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5);
            }

            $endpoint = 'https://api.instagram.com/oembed?url='.urlencode($postUrl).'&omitscript=1&maxwidth=640';
            $json = @file_get_contents($endpoint, false, $context);
            if (is_string($json) && $json !== '') {
                $data = json_decode($json, true);
                if (! empty($data['thumbnail_url'])) {
                    return html_entity_decode((string) $data['thumbnail_url'], ENT_QUOTES | ENT_HTML5);
                }
            }

            return null;
        });
    }
}

if (! function_exists('instagram_oembed')) {
    /** @return array{thumbnail_url?: string, title?: string, author_name?: string}|null */
    function instagram_oembed(string $postUrl): ?array
    {
        $postUrl = instagram_normalize_post_url($postUrl);
        $thumbnail = instagram_post_thumbnail_url($postUrl);

        return $thumbnail ? ['thumbnail_url' => $thumbnail] : null;
    }
}

if (! function_exists('google_maps_url')) {
    function google_maps_url(): string
    {
        $url = trim((string) setting('google_maps_url', ''));
        if ($url !== '') {
            return $url;
        }

        $lat = setting('contact_latitude', '-6.3127483');
        $lng = setting('contact_longitude', '106.0009228');

        return 'https://www.google.com/maps?q='.$lat.','.$lng;
    }
}

if (! function_exists('google_maps_embed_url')) {
    function google_maps_embed_url(): string
    {
        $custom = trim((string) setting('google_maps_embed_url', ''));
        if ($custom !== '') {
            return $custom;
        }

        $lat = setting('contact_latitude', '-6.3127483');
        $lng = setting('contact_longitude', '106.0009228');
        $query = urlencode('SMKN 8 Pandeglang');

        return 'https://maps.google.com/maps?q='.$query.'@'.$lat.','.$lng.'&hl=id&z=17&output=embed';
    }
}

if (! function_exists('major_card_class')) {
    function major_card_class(string $code): string
    {
        return match (strtoupper($code)) {
            'RPL'  => 'major-card--rpl',
            'DKV'  => 'major-card--dkv',
            'TBSM' => 'major-card--tsm',
            'TITL' => 'major-card--titl',
            'AKL'  => 'major-card--ak',
            default => 'major-card--default',
        };
    }
}

if (! function_exists('spmb_route')) {
    /** URL rute SPMB dengan fallback path jika rute belum terdaftar (mis. cache route lama). */
    function spmb_route(string $name, string $fallbackPath, string $fragment = ''): string
    {
        $base = \Illuminate\Support\Facades\Route::has($name)
            ? route($name)
            : url($fallbackPath);

        return $fragment !== '' ? $base.$fragment : $base;
    }
}
