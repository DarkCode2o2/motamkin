<?php
/**
 * SEO Helper Functions
 * Advanced SEO utilities for Motamkin Premium Phone Numbers Store
 */

// Include the main SEO configuration
if (!defined('SITE_URL')) {
    include_once __DIR__ . '/seo-config.php';
}

/**
 * Generate complete SEO meta tags for any page
 */
function generate_seo_meta($page = 'index', $additionalData = []) {
    $seo = get_seo_data($page);
    $output = '';
    
    // Title tag
    $output .= "    <title>" . htmlspecialchars($seo['title']) . "</title>\n";
    
    // Meta description
    $output .= "    <meta name=\"description\" content=\"" . htmlspecialchars($seo['description']) . "\">\n";
    
    // Meta keywords (concatenated with base keywords)
    $keywords = generate_meta_keywords($page);
    $output .= "    <meta name=\"keywords\" content=\"" . htmlspecialchars($keywords) . "\">\n";
    
    // Canonical URL
    $canonical = isset($additionalData['canonical']) ? $additionalData['canonical'] : $seo['canonical'];
    $output .= "    <link rel=\"canonical\" href=\"" . $canonical . "\">\n";
    
    // Open Graph tags
    $output .= "    <meta property=\"og:title\" content=\"" . htmlspecialchars($seo['og_title']) . "\">\n";
    $output .= "    <meta property=\"og:description\" content=\"" . htmlspecialchars($seo['og_description']) . "\">\n";
    $output .= "    <meta property=\"og:image\" content=\"" . htmlspecialchars($seo['og_image'] ?? SITE_URL . '/images/icon.png') . "\">\n";
    $output .= "    <meta property=\"og:url\" content=\"" . $canonical . "\">\n";
    $output .= "    <meta property=\"og:type\" content=\"website\">\n";
    $output .= "    <meta property=\"og:site_name\" content=\"" . SITE_NAME . "\">\n";
    $output .= "    <meta property=\"og:locale\" content=\"ar_SA\">\n";
    
    // Twitter Card
    $output .= "    <meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    $output .= "    <meta name=\"twitter:title\" content=\"" . htmlspecialchars($seo['title']) . "\">\n";
    $output .= "    <meta name=\"twitter:description\" content=\"" . htmlspecialchars($seo['description']) . "\">\n";
    $output .= "    <meta name=\"twitter:image\" content=\"" . htmlspecialchars($seo['og_image'] ?? SITE_URL . '/images/icon.png') . "\">\n";
    
    // Additional meta tags
    $output .= "    <meta name=\"robots\" content=\"index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1\">\n";
    $output .= "    <meta name=\"author\" content=\"" . SITE_NAME . "\">\n";
    $output .= "    <meta name=\"language\" content=\"Arabic\">\n";
    $output .= "    <meta name=\"revisit-after\" content=\"7 days\">\n";
    
    return $output;
}

/**
 * Generate Organization Schema (JSON-LD)
 */
function generate_organization_schema() {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => SITE_URL . '#organization',
        'name' => SITE_NAME,
        'alternateName' => SITE_NAME_EN,
        'url' => SITE_URL,
        'logo' => [
            '@type' => 'ImageObject',
            'url' => SITE_URL . '/images/icon.png',
            'width' => 512,
            'height' => 512
        ],
        'description' => SITE_DESCRIPTION,
        'areaServed' => [
            '@type' => 'Country',
            'name' => 'Saudi Arabia'
        ],
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => '+966-50-055-0950',
            'contactType' => 'sales',
            'availableLanguage' => ['Arabic', 'English'],
            'areaServed' => 'SA'
        ],
        'sameAs' => [
            'https://wa.link/jm23mv',
            'https://www.snapchat.com/add/almotamkin',
            'https://chat.whatsapp.com/KfspL8lpPLcACmy4Cz0ibD'
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Generate Website Schema (JSON-LD)
 */
function generate_website_schema() {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => SITE_URL . '#website',
        'url' => SITE_URL,
        'name' => SITE_NAME,
        'alternateName' => SITE_NAME_EN,
        'description' => SITE_DESCRIPTION,
        'publisher' => [
            '@id' => SITE_URL . '#organization'
        ],
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => [
                '@type' => 'EntryPoint',
                'urlTemplate' => SITE_URL . '/?search={search_term_string}'
            ],
            'query-input' => 'required name=search_term_string'
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Generate BreadcrumbList Schema
 */
function generate_breadcrumb_schema($items = []) {
    if (empty($items)) {
        return '';
    }
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => []
    ];
    
    foreach ($items as $index => $item) {
        $schema['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['name'],
            'item' => $item['url']
        ];
    }
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Generate Product Schema for a phone number
 */
function generate_product_schema($number, $category) {
    $price_clean = (int)str_replace([',', ' '], '', $number['price']);
    
    // Determine price range based on category
    $price_range = '';
    switch ($category) {
        case 'economic':
            $price_range = '0-499';
            break;
        case 'special':
            $price_range = '500-1499';
            break;
        case 'elite':
            $price_range = '1500-4999';
            break;
        case 'vip':
            $price_range = '5000+';
            break;
        case 'bundle':
            $price_range = 'Variable';
            break;
    }
    
    $availability = !empty($number['number']) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => 'رقم مميز: ' . $number['number'],
        'description' => generate_product_description($number, $category),
        'image' => SITE_URL . '/images/icon.png',
        'brand' => [
            '@type' => 'Brand',
            'name' => 'المتمكن للأرقام المميزة'
        ],
        'sku' => 'MOTAMKIN-' . $number['id'],
        'mpn' => $number['number'],
        'offers' => [
            '@type' => 'Offer',
            'url' => SITE_URL . '/' . $category . '.php',
            'priceCurrency' => 'SAR',
            'price' => $price_clean,
            'priceValidUntil' => date('Y-m-d', strtotime('+30 days')),
            'availability' => $availability,
            'seller' => [
                '@type' => 'Organization',
                'name' => SITE_NAME
            ],
            'shippingDetails' => [
                '@type' => 'OfferShippingDetails',
                'shippingRate' => [
                    '@type' => 'MonetaryAmount',
                    'value' => 0,
                    'currency' => 'SAR'
                ],
                'deliveryTime' => [
                    '@type' => 'ShippingDeliveryTime',
                    'handlingTime' => [
                        '@type' => 'QuantitativeValue',
                        'minValue' => 0,
                        'maxValue' => 1,
                        'unitCode' => 'DAY'
                    ]
                ]
            ]
        ],
        'category' => get_category_display_name($category),
        'additionalProperty' => [
            [
                '@type' => 'PropertyValue',
                'name' => 'النطاق السعري',
                'value' => $price_range
            ],
            [
                '@type' => 'PropertyValue',
                'name' => 'التصنيف',
                'value' => get_category_display_name($category)
            ]
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Generate FAQ Schema
 */
function generate_faq_schema() {
    $faqs = [
        [
            'question' => 'كيف يمكنني شراء رقم مميز من المتكن؟',
            'answer' => 'يمكنك شراء رقم مميز بسهولة من خلال التواصل معنا عبر واتساب أو زيارة صفحاتنا. نوفر خيارات متعددة من الأرقام الاقتصادية والراقية، مع ضمان نقل الملكية بشكل سريع وآمن.'
        ],
        [
            'question' => 'هل عملية نقل ملكية الأرقام آمنة؟',
            'answer' => 'نعم، نضمن لك نقل ملكية سريع وآمن. نحن مؤسسة تجارية رسمية مسجلة بسجل تجاري معتمد وموثقة لدى منصة أعمال وزارة التجارة.'
        ],
        [
            'question' => 'ما هي طرق الدفع المتاحة؟',
            'answer' => 'نوفر تحويل بنكي على حساب المؤسسة الرسمي. كما نوفر إمكانية التقسيط على أربع دفعات لبعض الأرقام.'
        ],
        [
            'question' => 'هل توفرون أرقام لجميع شركات الاتصالات؟',
            'answer' => 'نعم، نوفر أرقام مميزة لجميع شركات الاتصالات السعودية بما فيها STC وزين وموبايلي.'
        ],
        [
            'question' => 'كم تستغرق عملية نقل الملكية؟',
            'answer' => 'تتم عملية نقل الملكية بسرعة عبر تطبيق My STC أو من خلال فروع شركة الاتصالات مباشرة.'
        ],
        [
            'question' => 'هل يمكنني التقسيط على أرقام VIP؟',
            'answer' => 'نعم، نوفر نظام تقسيط على أربع دفعات لبعض الأرقام المميزة والفاخرة. تواصل معنا لمعرفة التفاصيل.'
        ],
        [
            'question' => 'ما هي مميزات الأرقام الاقتصادية؟',
            'answer' => 'الأرقام الاقتصادية تبدأ من 0 إلى 499 ريال، وهي مثالية لمن يبحث عن رقم مميز بتكلفة مناسبة. أرقام تبدأ بـ 055 و 056.'
        ],
        [
            'question' => 'هل توفرون أرقام نادرة ومميزة؟',
            'answer' => 'نعم، لدينا مجموعة من الأرقام النادرة والVIP التي تناسب مختلف الأذواق والميزانيات. من 5000 ريال فما فوق.'
        ],
        [
            'question' => 'هل يمكنني رؤية الأرقام قبل الشراء؟',
            'answer' => 'نعم، يمكنك مشاهدة جميع الأرقام المتوفرة على موقعنا. تواصل معنا عبر واتساب لطلب قائمة الأسعار والتفاصيل.'
        ],
        [
            'question' => 'ما هي مناطق التغطية؟',
            'answer' => 'نخدمكم في جميع مناطق المملكة العربية السعودية بما فيها الرياض، جدة، مكة، المدينة، الدمام، والخبر.'
        ]
    ];
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => []
    ];
    
    foreach ($faqs as $faq) {
        $schema['mainEntity'][] = [
            '@type' => 'Question',
            'name' => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq['answer']
            ]
        ];
    }
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Generate LocalBusiness Schema
 */
function generate_localbusiness_schema() {
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => SITE_NAME,
        'description' => SITE_DESCRIPTION,
        'url' => SITE_URL,
        'telephone' => '+966-50-055-0950',
        'priceRange' => '$$',
        'image' => SITE_URL . '/images/icon.png',
        'address' => [
            '@type' => 'PostalAddress',
            'addressCountry' => 'SA',
            'addressRegion' => 'Saudi Arabia'
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'addressCountry' => 'SA'
        ],
        'openingHoursSpecification' => [
            '@type' => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            'opens' => '09:00',
            'closes' => '21:00'
        ],
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'أرقام مميزة',
            'itemListElement' => [
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'أرقام اقتصادية'
                    ]
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'أرقام VIP'
                    ]
                ],
                [
                    '@type' => 'Offer',
                    'itemOffered' => [
                        '@type' => 'Service',
                        'name' => 'أرقام نخبة'
                    ]
                ]
            ]
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Helper function to get category display name in Arabic
 */
function get_category_display_name($category) {
    $names = [
        'economic' => 'أرقام اقتصادية',
        'special' => 'أرقام مميزة',
        'elite' => 'أرقام النخبة',
        'vip' => 'أرقام VIP',
        'bundle' => 'أرقام الطقم'
    ];
    
    return $names[$category] ?? $category;
}

/**
 * Generate product description based on number pattern
 */
function generate_product_description($number, $category) {
    $phone = $number['number'];
    $description = '';
    
    // Check for special patterns
    if (preg_match('/^(\d)\1{6,}$/', str_replace(' ', '', $phone))) {
        $description = 'رقم مميز جداً ب تكرار متسلسل - ' . $phone;
    } elseif (preg_match('/(\d)\1{4,}/', str_replace(' ', '', $phone))) {
        $description = 'رقم مميز بنمط متكرر - ' . $phone;
    } elseif (preg_match('/^05[56]\d{8}$/', str_replace(' ', '', $phone))) {
        $description = 'رقم مميز ' . substr($phone, 0, 3) . ' يبدأ بـ ' . substr($phone, 0, 4) . ' - ' . $phone;
    } else {
        $category_desc = [
            'economic' => 'رقم اقتصادي مميز',
            'special' => 'رقم مميز',
            'elite' => 'رقم نخبوي فاخر',
            'vip' => 'رقم VIP حصري',
            'bundle' => 'طقم أرقام مميزة'
        ];
        $description = ($category_desc[$category] ?? 'رقم مميز') . ' - ' . $phone;
    }
    
    $description .= '. متوفر للبيع الآن مع نقل ملكية سريع ومجاني.';
    
    return $description;
}

/**
 * Generate breadcrumb HTML
 */
function generate_breadcrumb_html($items = []) {
    if (empty($items)) {
        return '';
    }
    
    $html = '<nav aria-label="breadcrumb" class="breadcrumb-nav"><ol class="breadcrumb">';
    
    foreach ($items as $index => $item) {
        $is_last = ($index === count($items) - 1);
        
        if ($is_last) {
            $html .= '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($item['name']) . '</li>';
        } else {
            $html .= '<li class="breadcrumb-item"><a href="' . htmlspecialchars($item['url']) . '">' . htmlspecialchars($item['name']) . '</a></li>';
        }
    }
    
    $html .= '</ol></nav>';
    
    return $html;
}

/**
 * Generate all structured data for a page
 */
function generate_all_structured_data($page = 'index', $data = []) {
    $schemas = [];
    
    // Always include Organization and Website schemas
    $schemas[] = generate_organization_schema();
    $schemas[] = generate_website_schema();
    
    // Add FAQ schema to homepage
    if ($page === 'index') {
        $schemas[] = generate_faq_schema();
    }
    
    // Add LocalBusiness schema
    $schemas[] = generate_localbusiness_schema();
    
    return implode("\n", $schemas);
}

/**
 * Check if URL has query parameters and add canonical
 */
function get_canonical_with_params($baseUrl, $allowedParams = []) {
    $canonical = $baseUrl;
    
    if (!empty($_GET)) {
        $params = [];
        foreach ($_GET as $key => $value) {
            if (empty($allowedParams) || in_array($key, $allowedParams)) {
                $params[$key] = $value;
            }
        }
        
        if (!empty($params)) {
            $canonical = $baseUrl . '?' . http_build_query($params);
        }
    }
    
    return $canonical;
}

/**
 * Generate language alternates
 */
function generate_hreflang_tags($pageUrl) {
    $tags = '';
    
    // Arabic (primary)
    $tags .= "    <link rel=\"alternate\" hreflang=\"ar\" href=\"" . $pageUrl . "\">\n";
    
    // English (if needed)
    $tags .= "    <link rel=\"alternate\" hreflang=\"en\" href=\"" . $pageUrl . "/en\">\n";
    
    // Default
    $tags .= "    <link rel=\"alternate\" hreflang=\"x-default\" href=\"" . $pageUrl . "\">\n";
    
    return $tags;
}

/**
 * Generate Customer Review and Rating Schema
 */
function generate_review_schema($category = 'index') {
    // Based on Haraj ratings mentioned in the site (500+ ratings)
    $review_count = 523; // Example based on site content
    $rating_value = 4.8;
    
    $review_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'AggregateRating',
        'ratingValue' => $rating_value,
        'reviewCount' => $review_count,
        'bestRating' => 5,
        'worstRating' => 1
    ];
    
    return '<script type="application/ld+json">' . json_encode($review_schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Generate HowTo Schema for buying process
 */
function generate_howto_schema() {
    $howto = [
        '@context' => 'https://schema.org',
        '@type' => 'HowTo',
        'name' => 'كيفية شراء رقم مميز من المتكن',
        'description' => 'دليل خطوة بخطوة لشراء رقم مميز مع نقل الملكية',
        'totalTime' => 'PT30M',
        'estimatedCost' => [
            '@type' => 'MonetaryAmount',
            'currency' => 'SAR',
            'minValue' => 0,
            'maxValue' => 10000
        ],
        'step' => [
            [
                '@type' => 'HowToStep',
                'name' => 'اختر الرقم المميز',
                'text' => 'تصفح أقسامنا واختر الرقم الذي يعجبك - اقتصادية، مميزة، نخبة، أو VIP',
                'image' => SITE_URL . '/images/icon.png'
            ],
            [
                '@type' => 'HowToStep',
                'name' => 'تواصل معنا عبر واتساب',
                'text' => 'أرسل لنا رسالة على واتساب بالرقم الذي تريده',
                'url' => 'https://wa.link/jm23mv'
            ],
            [
                '@type' => 'HowToStep',
                'name' => 'تأكيد السعر والدفع',
                'text' => 'ناقش السعر معانا وأتمام عملية الدفع عبر تحويل بنكي',
                'image' => SITE_URL . '/images/about.png'
            ],
            [
                '@type' => 'HowToStep',
                'name' => 'نقل الملكية',
                'text' => 'نقوم بنقل الملكية فوراً عبر تطبيق My STC أو من خلال أقرب فرع',
                'image' => SITE_URL . '/images/icon.png'
            ]
        ]
    ];
    
    return '<script type="application/ld+json">' . json_encode($howto, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Generate ItemList schema for phone numbers
 */
function generate_itemlist_schema($numbers, $category) {
    if (empty($numbers)) {
        return '';
    }
    
    $itemListElement = [];
    foreach ($numbers as $index => $number) {
        $itemListElement[] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'item' => [
                '@type' => 'Product',
                'name' => 'رقم مميز: ' . $number['number'],
                'description' => generate_product_description($number, $category),
                'offers' => [
                    '@type' => 'Offer',
                    'price' => (int)str_replace([',', ' '], '', $number['price']),
                    'priceCurrency' => 'SAR',
                    'availability' => !empty($number['number']) ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock'
                ]
            ]
        ];
    }
    
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'numberOfItems' => count($numbers),
        'itemListElement' => $itemListElement
    ];
    
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}
