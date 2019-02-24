{{-- Check if the notification has been subscribed for the current provider --}}
@if ($row::isSubscribed($provider))
  <button type="button" data-driver="{{ $provider }}" data-notification="{{ $row }}" data-title="{{ $row::getTitle() }}" data-toggle="modal" data-target="#notifications-driver-channels" class="btn btn-app">
    <span class="badge bg-green">
      <i class="fa fa-check"></i>
    </span>
    <i class="fa {{ $row::getDriver($provider)::getButtonIconClass() }}"></i> {{ $row::getDriver($provider)::getButtonLabel() }}
  </button>
{{-- Check if the current provider has been set --}}
@elseif ($row::getDriver($provider)::isSetup())
  <button type="button" data-driver="{{ $provider }}" data-notification="{{ $row }}" data-title="{{ $row::getTitle() }}" data-toggle="modal" data-target="#notifications-driver-channels" class="btn btn-app">
    <i class="fa {{ $row::getDriver($provider)::getButtonIconClass() }}"></i> {{ $row::getDriver($provider)::getButtonLabel() }}
  </button>
{{-- Render a disabled button since none of the previous conditions has been met --}}
@else
  <button type="button" class="btn btn-app disabled">
    <i class="fa {{ $row::getDriver($provider)::getButtonIconClass() }}"></i> {{ $row::getDriver($provider)::getButtonLabel() }}
  </button>
@endif