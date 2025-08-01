<x-card>
	<div class="p-4 overflow-hidden">
		<div class="mb-4">
			<x-entity.format format="ban"></x-entity.format>
		</div>
		<h4 class="text-par-l font-semibold mb-1 text-lab-pr2">
			{!! __('admin/info.ban_notice.title') !!}
		</h4>
		<p class="text-lab-sc text-par-s mb-2">
			{!! __('admin/info.ban_notice.line_one') !!}
		</p>
		<p class="text-lab-sc text-par-s">
			{!! __('admin/info.ban_notice.line_two') !!}
		</p>
		<p class="text-lab-sc text-par-s">
			{!! __('admin/info.ban_notice.line_three') !!}
		</p>
	</div>
</x-card>