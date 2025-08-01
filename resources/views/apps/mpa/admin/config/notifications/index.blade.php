@extends('adminLayout::index')

@section('pageContent')
	<div class="mb-8">
		<x-page-title titleText=" {{ __('admin/config.notifications_settings') }}"></x-page-title>
		<x-page-desc>
			{{ __('admin/config.notifications_settings_desc') }}
		</x-page-desc>
	</div>

	<x-sided-content>
		<x-slot:sideContent>
			<x-config.readonly-notice></x-config.readonly-notice>
		</x-slot:sideContent>

		<div class="flex flex-col gap-6">
			<x-config.env
				name="NOTIFICATIONS_EMAIL_ENABLED"
				description="{{ __('admin/config.captions.notifications_email_enabled') }}"
			value="{{ config('notifications.email.enabled') }}"/>

			<x-config.env
				name="NOTIFICATIONS_BROADCAST_ENABLED"
				description="{{ __('admin/config.captions.notifications_broadcast_enabled') }}"
			value="{{ config('notifications.broadcast.enabled') }}"/>
		</div>
	</x-sided-content>
@endsection