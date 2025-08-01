<script>
	window.BackendEmbeds = {
		assets: {
			images: {
				upload_avatar: '{{ asset('assets/avatars/upload-avatar.png') }}',
				bio_avatar: '{{ asset('assets/avatars/bio-avatar.png') }}'
			},
			logos: {
				url: '{{ $logotypeUrl }}'
			}
		},
		translation_service: {
			name: '{{ config('services.translation.name') }}',
			url: '{{ config('services.translation.url') }}',
			logo_url: '{{ config('services.translation.logo') }}'
		},
		routes: {
			ads_home_index: "{{ route('business.dashboard.index') }}",
			user_auth_index: "{{ route('user.auth.index') }}",
			terms_of_use: "{{ route('document.terms.index') }}",
			privacy_policy: "{{ route('document.privacy.index') }}",
			cookies_policy: "{{ route('document.cookies.index') }}",
			api_developers: "{{ route('document.developers.index') }}",
			help_center: "{{ route('document.help.index') }}",
			user_linker_index: "{{ route('user.linker.index') }}",
			verification_rules: "{{ route('document.verification.index') }}"
		},
		sharing: {
			stories: @json(config('content.sharing.stories'))
		},
		links: {
			assets_url: "{{ asset('/') }}",
			base_url: "{{ url('/') }}/",
			assets: {
				emoji: "{{ asset('assets/emoji/img-apple-64') }}/"
			},
			guide_links: {
				publication_rules: "{{ asset('documents/publication-rules.pdf') }}",
			}
		},
		locale: '{{ app()->getLocale() }}',
		locale_name: '{{ $localeName }}',
		available_locales: @json(available_locales()),
		theme: '{{ theme_name() }}',
		config: {
			features: @json(config('features')),
			app: {
				name: '{{ config('app.name') }}',
				currency: @json(default_currency())
			},
			verification: {
				service_url: '{{ config('verification.service_url') }}'
			},
			validation: {
				user: {
					bio: @json(config('user.validation.bio'))
				}
			},
			user: {
				default_avatar: '{{ asset(config('user.avatar')) }}'
			},
			wallet: {
				name: '{{ config('wallet.name') }}',
				about_link: '{{ config('wallet.about_link') }}',
				deposit: {
					max_amount: {{ config('wallet.deposit.max_amount') }},
					min_amount: {{ config('wallet.deposit.min_amount') }},
					commission: {{ config('wallet.commission.deposit') }}
				},
				transfer: {
					max_amount: {{ config('wallet.transfer.max_amount') }},
					min_amount: {{ config('wallet.transfer.min_amount') }},
					commission: {{ config('wallet.commission.transfer') }}
				},
				withdraw: {
					max_amount: {{ config('wallet.withdraw.max_amount') }},
					min_amount: {{ config('wallet.withdraw.min_amount') }},
					commission: {{ config('wallet.commission.withdraw') }}
				}
			},
			sounds: {
				chat: {
					active_chat_message_received: '{{ asset(config('chat.sounds.active_chat_message_received')) }}',
					chat_message_sent: '{{ asset(config('chat.sounds.chat_message_sent')) }}',
					background_chat_message_received: '{{ asset(config('chat.sounds.background_chat_message_received')) }}'
				},
				notification: {
					received: '{{ asset(config('notifications.sounds.notification_received')) }}'
				}
			}
		},
		contacts: {
			support_email: '{{ config('contacts.support_email') }}',
			support_phone: '{{ config('contacts.support_phone') }}',
			address: '{{ config('contacts.address') }}'
		}
	};
</script>