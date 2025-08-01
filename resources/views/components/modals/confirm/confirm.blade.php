<div x-data="{isSubmitting: false}" x-cloak>
	<div x-show="$store.confirmModal.isOpen">
		<x-modals.modal>
			<form x-bind:action="$store.confirmModal.formAction" x-on:submit="isSubmitting = true" method="POST">
				@csrf
				@method('POST')

				<div class="px-8 text-center py-7">
					<h4 x-text="$store.confirmModal.content.title" class="text-par-l text-lab-pr2 font-semibold tracking-tight mb-1"></h4>
					<p x-text="$store.confirmModal.content.desc" class="text-par-s text-lab-pr3 mb-4"></p>
				</div>
				<div class="border-t border-bord-pr">
					<div class="grid grid-cols-2">
						<div class="flex py-4 justify-center border-r border-bord-pr hover:bg-fill-fv">
							<button x-bind:disabled="isSubmitting" x-on:click="$store.confirmModal.close()" type="button" class="text-par-s text-brand-900 outline-hidden leading-none disabled:opacity-80 cursor-pointer" x-text="$store.confirmModal.content.cancelButtonText || '{{ __('labels.cancel_button') }}'"></button>
						</div>
						<div class="flex py-4 justify-center hover:bg-fill-fv">
							<button x-bind:disabled="isSubmitting" type="submit" class="text-par-s cursor-pointer text-red-900 outline-hidden leading-none disabled:opacity-80" x-text="$store.confirmModal.content.confirmButtonText || '{{ __('labels.delete_button') }}'"></button>
						</div>
					</div>
				</div>
			</form>
		</x-modals.modal>
	</div>
</div>