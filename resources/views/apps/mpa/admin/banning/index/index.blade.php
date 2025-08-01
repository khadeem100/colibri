@extends('adminLayout::index')

@section('pageContent')
	<div class="mb-8">
        <x-page-title titleText=" {{ __('admin/ban.index_title') }}"></x-page-title>
        <x-page-desc>
            {{ __('admin/ban.index_desc') }}
        </x-page-desc>
    </div>

	<x-table.table>
		<x-table.thead>
			<x-table.th>{{ __('table.labels.admin') }}</x-table.th>
			<x-table.th>{{ __('table.labels.type') }}</x-table.th>
			<x-table.th>{{ __('table.labels.content') }}</x-table.th>
			<x-table.th>{{ __('table.labels.added_at') }}</x-table.th>
			<x-table.th>{{ __('table.labels.expires_at') }}</x-table.th>
			<x-table.th>#ID</x-table.th>
			<x-table.th>{{ __('labels.table.actions') }}</x-table.th>
		</x-table.thead>
		<x-table.tbody>
			@if($blacklistedContent->isNotEmpty())
				@foreach ($blacklistedContent as $blacklistedContentData)
					@include('admin::banning.index.parts.blacklisted-content-item', [
						'blacklistedContentData' => $blacklistedContentData
					])
				@endforeach
			@else
				<x-table.empty colspan="8"></x-table.empty>
			@endif
		</x-table.tbody>
	</x-table.table>

	@unless($blacklistedContent->isEmpty())
		<div class="mt-4">
			{{ $blacklistedContent->onEachSide(1)->withQueryString()->links('pagination.index') }}
		</div>
	@endunless

	<div class="mt-4">
		<x-info.cache-notice></x-info.cache-notice>
	</div>
@endsection