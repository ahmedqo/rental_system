<div slot="footer" id="footer-content">
    @if (Core::company())
        <div>
            <span>{{ __('ICE number') }}:</span>
            <span>{{ Core::company('ice_number') }}</span>
        </div>
        <div>
            <span>{{ __('Decision number') }}:</span>
            <span>{{ Core::company('license_number') }}</span>
        </div>
        <div>
            <span>{{ __('Phone') }}:</span>
            <span>{{ Core::company('phone') }}</span>
        </div>
        <div>
            <span>{{ __('Email') }}:</span>
            <span>{{ Core::company('email') }}</span>
        </div>
        <div>
            <span>{{ __('Address') }}:</span>
            <span>
                {{ ucfirst(Core::company('address')) . ' ' . ucfirst(__(Core::company('city'))) . ' ' . Core::company('zipcode') }}
            </span>
        </div>
    @endif
</div>
