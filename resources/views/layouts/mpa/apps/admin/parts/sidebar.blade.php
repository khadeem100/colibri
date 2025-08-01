<x-sidebar.container>
    <x-sidebar.action-bar>
        <div class="flex justify-center mb-4">
            <a href="{{ route('business.settings.index') }}" class="size-10 rounded-full overflow-hidden">
                <img class="size-full" src="{{ me()->avatar_url }}" alt="Image">
            </a>
        </div>
        
        <x-ui.dropdown.dropdown :classes="['origin-bottom-right', 'top-0', 'left-14']">
            <x-slot:dropdownButton>
                <x-sidebar.action class="bg-fill-tr text-brand-900" tag="button" icon="plus" iconType="solid" />
            </x-slot:dropdownButton>

            <x-ui.dropdown.item tag="a" itemText="{{ __('admin/sidebar.add_user') }}" href="{{ route('admin.coming.index') }}">
                <x-slot:itemIcon>
                    <x-ui-icon type="line" name="user-02"></x-ui-icon>
                </x-slot:itemIcon>
            </x-ui.dropdown.item>
        </x-ui.dropdown.dropdown>

        <div class="mt-auto flex flex-col gap-1 text-lab-sc">
            <x-sidebar.action href="{{ route('document.help.index') }}" icon="help-circle" iconType="line" />
            <x-sidebar.action href="{{ route('user.desktop.index') }}" icon="log-out-04" iconType="line" />
        </div>
    </x-sidebar.action-bar>

    <x-sidebar.navbar>
        <div class="mb-6">
            <x-sidebar.user-card name="{{ me()->name }}" caption="{{ me()->caption }}" link="{{ url('wallet') }}">
                <x-slot:footer>
                    <div class="text-lab-sc text-par-s px-4 py-3">
                        {{ __('admin/info.you_are_admin') }}
                    </div>
                </x-slot:footer>
            </x-sidebar.user-card>
        </div>
        <x-sidebar.navlist>
            <x-sidebar.navlist-item
                href="{{ route('admin.dash.index') }}"
                iconName="grid-01"
                iconType="line"
                :current="route_is('admin.dash.*')"
            text="{{ __('admin/sidebar.dashboard') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.lab.index') }}"
                iconName="thermometer-cold"
                iconType="line"
                :current="route_is('admin.lab.*')"
            text="{{ __('admin/sidebar.lab_tools') }}"/>
                
            <x-sidebar.navlist-item
                href="{{ config('app.documentation_url') }}"
                iconName="book-open-01"
                iconType="line"
                target="_blank"
            text="{{ __('admin/sidebar.documentation') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.users.index') }}"
                iconName="user-02"
                iconType="line"
                :current="route_is('admin.users.*')"
            text="{{ __('admin/sidebar.users') }}"/>

            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ route('admin.posts.index') }}"
                iconName="layout-alt-02"
                iconType="line"
                :current="route_is('admin.posts.*')"
            text="{{ __('admin/sidebar.publications') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.ads.index') }}"
                iconName="announcement-03"
                iconType="line"
                :current="route_is('admin.ads.*')"
            text="{{ __('admin/sidebar.ads_manager') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.stories.index') }}"
                iconName="refresh-cw-04"
                iconType="line"
                :current="route_is('admin.stories.*')"
            text="{{ __('admin/sidebar.stories') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.market.index') }}"
                iconName="shopping-bag-03"
                iconType="line"
                :current="route_is('admin.market.*')"
            text="{{ __('admin/sidebar.marketplace') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.jobs.index') }}"
                iconName="briefcase-01"
                iconType="line"
                :current="route_is('admin.jobs.*')"
            text="{{ __('admin/sidebar.jobs') }}"/>

            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ route('admin.config.general') }}"
                iconName="settings-01"
                iconType="line"
                :current="route_is('admin.config.general')"
            text="{{ __('admin/sidebar.general_settings') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.config.email') }}"
                iconName="mail-01"
                iconType="line"
                :current="route_is('admin.config.email')"
            text="{{ __('admin/sidebar.email_settings') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.config.notifications') }}"
                iconName="bell-01"
                iconType="line"
                :current="route_is('admin.config.notifications')"
            text="{{ __('admin/sidebar.notifications') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.config.api') }}"
                iconName="code-02"
                iconType="line"
                :current="route_is('admin.config.api')"
            text="{{ __('admin/sidebar.api_settings') }}"/>

            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ route('admin.storage.index') }}"
                iconName="cloud-blank-01"
                iconType="line"
                :current="route_is('admin.storage.*')"
            text="{{ __('admin/sidebar.file_storage') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.coming.index') }}"
                iconName="database-01"
                iconType="line"
                :current="false"
            text="{{ __('admin/sidebar.db_backup') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.payments.index') }}"
                iconName="credit-card-02"
                iconType="line"
                :current="route_is('admin.payments.*')"
            text="{{ __('admin/sidebar.payments') }}"/>

            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ route('admin.reports.index') }}"
                iconName="flag-02"
                iconType="line"
                :current="route_is('admin.reports.*')"
            text="{{ __('admin/sidebar.reported_content') }}"/>
            
            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ route('admin.lang.index') }}"
                iconName="translate-01"
                iconType="line"
                :current="route_is('admin.lang.*')"
            text="{{ __('admin/sidebar.languages') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.currency.index') }}"
                iconName="currency-euro"
                iconType="line"
                :current="route_is('admin.currency.*')"
            text="{{ __('admin/sidebar.currency') }}"/>

            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ route('admin.config.verification') }}"
                iconName="check-verified-02"
                iconType="line"
                :current="route_is('admin.config.verification')"
            text="{{ __('admin/sidebar.verification') }}"/>

            <x-sidebar.navlist-item
                href="{{ route('admin.coming.index') }}"
                iconName="credit-card-up"
                iconType="line"
                :current="false"
            text="{{ __('admin/sidebar.withdrawals') }}"/>

            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ route('admin.banning.index') }}"
                iconName="slash-octagon"
                iconType="line"
                :current="route_is('admin.banning.*')"
            text="{{ __('admin/sidebar.banned') }}"/>

            <x-sidebar.navlist-div/>

            <x-sidebar.navlist-item
                href="{{ url(config('log-viewer.route_path')) }}"
                iconName="alert-triangle"
                iconType="line"
            text="{{ __('admin/sidebar.logging') }}"/>

        </x-sidebar.navlist>
		<div class="mt-auto py-6">
			<div class="flex flex-wrap gap-1">
                <x-sidebar.link href="{{ url('settings/theme') }}" target="_blank">
                    {{ __('labels.theme') }}
                </x-sidebar.link>
                <x-sidebar.link href="{{ route('document.help.index') }}" target="_blank">
                    {{ __('business/labels.help') }}
                </x-sidebar.link>
                <x-sidebar.link href="{{ route('document.developers.index') }}" target="_blank">
                    {{ __('business/labels.for_developers') }}
                </x-sidebar.link>
                <x-sidebar.link href="{{ route('document.privacy.index') }}" target="_blank">
                    {{ __('business/labels.privacy_policy') }}
                </x-sidebar.link>
                <x-sidebar.link href="{{ route('document.terms.index') }}" target="_blank">
                    {{ __('business/labels.terms_of_use') }}
                </x-sidebar.link>
                <x-sidebar.link href="{{ url('settings/language') }}" target="_blank">
                    {{ __('business/labels.language') }}
                </x-sidebar.link>
                
                <x-sidebar.link href="{{ url('/') }}" target="_blank">
                    {{ config('app.name') }} &copy; {{ now()->year }}  Version #{{ $appVersion }}
                </x-sidebar.link>

                @unless(config('app.hide_author_attribution'))
                    <x-sidebar.link href="https://www.terla.me" target="_blank">Created by Mansur Terla</x-sidebar.link>
                @endunless
			</div>
		</div>
    </x-sidebar.navbar>
</x-sidebar.container>
