<?php

return [
	'name' => env('ADS_NAME', 'ColibriAds'),
	'document_links' => [
		'advertising_guide' => 'documents/advertising-guide.pdf',
		'advertising_rules' => 'documents/advertising-rules.pdf'
	],
	'ad' => [
		'validation' => [
			'title' => [
				'min' => 12,
				'max' => 120
			],
			'content' => [
				'min' => 62,
				'max' => 220
			],
			'cta_text' => [
				'min' => 4,
				'max' => 32
			],
			'total_budget' => [
				'min' => env('ADS_MIN_BUDGET', 5),
				'max' => env('ADS_MAX_BUDGET', 10000)
			],
			'target_url' => [
				'max' => 320,
			],
			'creative' => [
				'mimes' => join(',', [
					'jpeg',
					'png',
					'jpg',
					'webp',
					'gif'
				]),
				'mimetypes' => join(',', [
					'image/jpeg',
					'image/webp',
					'image/png',
					'image/jpg',
					'image/gif'
				]),
				'max' => '2048' // 2MB
			]
		],
		'default_preview' => 'assets/ads/default-preview.png',
		'image_width' => 800,
		'image_height' => 500
	],
	'default_approval' => env('ADS_DEFAULT_APPROVAL', true),
	'price_per_view' => env('ADS_PRICE_PER_VIEW', 0.01),

	// Add refresh interval in minutes.
	'refresh_interval' => env('ADS_AD_REFRESH_INTERVAL', 30),

	// Add charge interval in minutes.
	'charge_interval' => env('ADS_CHARGE_INTERVAL', 10)
];