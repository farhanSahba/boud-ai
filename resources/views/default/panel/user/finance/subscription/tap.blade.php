@extends('panel.layout.app')
@section('title', __('Subscription Payment'))
@section('titlebar_actions', '')

@section('additional_css')
    <style>
        #bank-form {
            width: 100%;
            align-self: center;
            box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.055), 0px 2px 5px 0px rgba(50, 50, 93, 0.068), 0px 1px 1.5px 0px rgba(0, 0, 0, 0.021);
            border-radius: 7px;
            padding: 40px;
        }

        .hidden {
            display: none;
        }
    </style>
@endsection

@section('content')
    <!-- Page body -->
    <div class="py-10">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-sm-8 col-lg-8">
                    @include('panel.user.finance.coupon.index')
                    <form
                        action="{{ route('dashboard.user.payment.subscription.checkout', ['gateway' => 'tap']) }}"
                        method="post"
                    >
                        @csrf
                        <input
                            type="hidden"
                            name="planID"
                            value="{{ $plan->id }}"
                        >
                        <input
                            type="hidden"
                            name="orderID"
                            value="{{ $order_id }}"
                        >
                        <input
                            type="hidden"
                            name="gateway"
                            value="tap"
                        >
                        <div class="row">
                            <div class="col-md-12 col-xl-12 mt-3">
                                <x-button
                                    class="w-full"
                                    variant="secondary"
                                    type="{{ $app_is_demo ? 'button' : 'submit' }}"
                                    onclick="{{ $app_is_demo ? 'return toastr.info(\'This feature is disabled in Demo version.\')' : '' }}"
                                >
                                    <div
                                        class="spinner hidden"
                                        id="spinner"
                                    ></div>
                                    <span id="button-text">
                                        {{ __('Subscribe') }}
                                    </span>
                                </x-button>
                            </div>
                        </div>
                    </form>

                    <p></p>
                    <p>{{ __('By purchasing you confirm our') }} <a href="{{ url('/') . '/terms' }}">{{ __('Terms and Conditions') }}</a> </p>
                </div>
                <div class="col-sm-4 col-lg-4">
                    @include('panel.user.finance.partials.plan_card')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
    </script>
@endpush
