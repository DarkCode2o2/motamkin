<?php
/**
 * SEO Configuration File
 * Centralized SEO meta tags and configurations for Motamkin Premium Phone Numbers
 */

// Base URL
define('SITE_URL', 'https://motamkin.madebyomar.dev');
define('SITE_NAME', 'المتمكن للأرقام المميزة');
define('SITE_NAME_EN', 'Motamkin Premium Numbers');
define('SITE_DESCRIPTION', 'متجر متخصص في بيع الأرقام المميزة نضمن لك نقل ملكية سريع وآمن، وأرقام تليق بمقامك وتبيّض الوجه.');

// Primary Keywords (Arabic Market)
define('PRIMARY_KEYWORDS', [
    'أرقام مميزة',
    'أرقام سوا',
    'أرقام اتصالات',
    'ارقام موبايل',
    'ارقام جوال',
    'ارقام مميزة السعودية',
    'ارقام VIP',
    'ارقام اقتصادية',
    'ارقام نادرة',
    'شراء ارقام',
    'بيع ارقام جوالات',
    'ارقام سوا مميزة',
    'ارقام موبايل للبيع',
    'ارقام telephone',
    'ارقام stc',
    'ارقام زين',
    'ارقام موبايلي'
]);

// SEO Data for each page
$seo_data = [
    'index' => [
        'title' => 'المتمكن للأرقام المميزة | أفضل أرقام الجوالات في السعودية',
        'title_en' => 'Motamkin Premium Numbers | Best Mobile Numbers in Saudi Arabia',
        'description' => 'متجر المتمكن للأرقام المميزة - اكتشف أفضل أرقام الجوالات المميزة في السعودية. أرقام VIP، اقتصادية، ونخبة. نضمن لك نقل ملكية سريع وآمن. تسوق الآن!',
        'keywords' => 'ارقام مميزة، ارقام جوالات، ارقام سوا، ارقام VIP، ارقام اقتصادية، السعودية، شراء ارقام',
        'canonical' => SITE_URL,
        'og_title' => 'المتمكن للأرقام المميزة | أرقام جوالات مميزة',
        'og_description' => 'متجر متخصص في بيع الأرقام المميزة. أرقام VIP، اقتصادية، ونخبة. نقل ملكية سريع وآمن.',
    ],
    'vip' => [
        'title' => 'أرقام VIP المميزة | أرقام جوالات فاخرة للبيع | المتمكن',
        'title_en' => 'VIP Premium Mobile Numbers | Luxury Phone Numbers For Sale | Motamkin',
        'description' => 'تسوق أرقام VIP المميزة والراقية من المتمكن. أرقام فاخرة من 5000 ريال فما فوق. نقل ملكية فوري ومضمون. أفضل أرقام VIP في السعودية.',
        'keywords' => 'ارقام VIP، ارقام فاخرة، ارقام راقية، ارقام موبايل VIP، ارقام جوالات فاخرة، ارقام نادرة VIP',
        'canonical' => SITE_URL . '/vip.php',
        'og_title' => 'أرقام VIP المميزة | المتمكن',
        'og_description' => 'أرقام VIP فاخرة من 5000 ريال. أرقام تليق بمقامك وتبيّض الوجه.',
    ],
    'elite' => [
        'title' => 'أرقام النخبة المميزة | أرقام اقتصادية راقية | المتمكن',
        'title_en' => 'Elite Premium Numbers | Premium Affordable Mobile Numbers | Motamkin',
        'description' => 'اكتشف أرقام النخبة المميزة بأسعار تنافسية من 1500 إلى 4999 ريال. أرقام فريدة ومميزة. نقل ملكية سريع ومجاني. تسوق الآن!',
        'keywords' => 'ارقام نخبة، ارقام مميزة، ارقام اقتصادية راقية، ارقام جوالات نخبة، ارقام فريدة',
        'canonical' => SITE_URL . '/elite.php',
        'og_title' => 'أرقام النخبة المميزة | المتمكن',
        'og_description' => 'أرقام النخبة من 1500 إلى 4999 ريال. أرقام فريدة ومميزة.',
    ],
    'special' => [
        'title' => 'أرقام مميزة | أفضل أرقام الجوالات | المتمكن',
        'title_en' => 'Special Premium Numbers | Best Mobile Numbers | Motamkin',
        'description' => 'تصفح أرقاتنا المميزة من 500 إلى 1499 ريال. أفضل أرقام الجوالات المميزة في السوق السعودي. أرقام سهلة الحفظ ومميزة. احجز الآن!',
        'keywords' => 'ارقام مميزة، ارقام سوا مميزة، ارقام جوالات مميزة، ارقام سهلة الحفظ، ارقام موبايل مميزة',
        'canonical' => SITE_URL . '/special.php',
        'og_title' => 'أرقام مميزة | المتمكن',
        'og_description' => 'أرقام مميزة من 500 إلى 1499 ريال. أرقام تليق بمقامك.',
    ],
    'economic' => [
        'title' => 'أرقام اقتصادية | أرقام جوالات بأسعار مناسبة | المتمكن',
        'title_en' => 'Economic Premium Numbers | Affordable Mobile Numbers | Motamkin',
        'description' => 'احصل على أرقام اقتصادية مميزة من 0 إلى 499 ريال. أفضل العروض على أرقام الجوالات الاقتصادية. أرقام تبدأ بـ 055 و 056. تسوق الآن!',
        'keywords' => 'ارقام اقتصادية، ارقام رخيصة، ارقام جوالات اقتصادية، ارقام سوا اقتصادية، ارقام بأسعار مناسبة، ارقام 055، ارقام 056',
        'canonical' => SITE_URL . '/economic.php',
        'og_title' => 'أرقام اقتصادية بأسعار مناسبة | المتمكن',
        'og_description' => 'أرقام اقتصادية من 0 إلى 499 ريال. أرقام تليق بمقامك.',
    ],
    'bundle' => [
        'title' => 'أرقام الطقم المميزة | أرقام مزدوجة للبيع | المتمكن',
        'title_en' => 'Bundle Premium Numbers | Double Mobile Numbers For Sale | Motamkin',
        'description' => 'احصل على أرقام طقم مميزة - أرقام مزدوجة متكاملة. مثالية للأسر والشركات. أرقام متناسقة ومميزة. اطلب الآن!',
        'keywords' => 'ارقام طقم، ارقام مزدوجة، ارقام متكاملة، ارقام مزدوجة للبيع، ارقام جوال طقم',
        'canonical' => SITE_URL . '/bundle.php',
        'og_title' => 'أرقام الطقم المميزة | المتمكن',
        'og_description' => 'أرقام طقم مميزة - أرقام مزدوجة متكاملة.',
    ],
];

/**
 * Get SEO data for a specific page
 */
function get_seo_data($page = 'index') {
    global $seo_data;
    return $seo_data[$page] ?? $seo_data['index'];
}

/**
 * Generate meta keywords from array
 */
function generate_meta_keywords($page = 'index') {
    $base_keywords = PRIMARY_KEYWORDS;
    $page_data = get_seo_data($page);
    
    // Add page-specific keywords
    $page_keywords = array_map('trim', explode(',', $page_data['keywords']));
    $all_keywords = array_merge($base_keywords, $page_keywords);
    
    // Remove duplicates and limit to 15-20 keywords
    $all_keywords = array_unique($all_keywords);
    $all_keywords = array_slice($all_keywords, 0, 18);
    
    return implode('، ', $all_keywords);
}
