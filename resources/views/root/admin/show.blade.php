@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header py-2 d-flex align-items-center justify-content-between mb-3">
                    <h2 class="card-title m-0">{{ __('Setup') }} {{ $user->name }} {{ __('Permissions') }}</h2>
                    <div class="d-flex justify-content-end" >
                        <a href="{{ route('admin.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                    </div>
                </div>
                <div class="row px-4 pb-4">
                    {{-- ===================== Service ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Services') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('service.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Create') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('service.create', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('service.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Edit') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('service.edit', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('service.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Status Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('service.status.toggle', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#serviceModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="serviceModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Service Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="service_index" permission="service.index" />

                                                <x-permission-input title="Create" :user="$user" name="service_create" permission="service.create" />

                                                <x-permission-input title="Store" :user="$user" name="service_store" permission="service.store" />

                                                <x-permission-input title="Edit" :user="$user" name="service_edit" permission="service.edit" />

                                                <x-permission-input title="Update" :user="$user" name="service_update" permission="service.update" />

                                                <x-permission-input title="Status Update" :user="$user" name="service_status_toggle" permission="service.status.toggle" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Additional Service ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Additional_Services') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('additional.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Create') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('additional.create', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('additional.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Edit') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('additional.edit', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('additional.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Status Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('additional.status.toggle', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#additionalModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="additionalModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Additional Service Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="additional_index" permission="additional.index" />

                                                <x-permission-input title="Create" :user="$user" name="additional_create" permission="additional.create" />

                                                <x-permission-input title="Store" :user="$user" name="additional_store" permission="additional.store" />

                                                <x-permission-input title="Edit" :user="$user" name="additional_edit" permission="additional.edit" />

                                                <x-permission-input title="Update" :user="$user" name="additional_update" permission="additional.update" />

                                                <x-permission-input title="Status Update" :user="$user" name="additional_status_toggle" permission="additional.status.toggle" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Variant Service ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Variants') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('variant.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('variant.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('variant.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Show Products') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('variant.products', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#variantModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="variantModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Variant Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="variant_index" permission="variant.index" />

                                                <x-permission-input title="Store" :user="$user" name="variant_store" permission="variant.store" />

                                                <x-permission-input title="Update" :user="$user" name="variant_update" permission="variant.update" />

                                                <x-permission-input title="Show Product" :user="$user" name="variant_products" permission="variant.products" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Notifications ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Notifications') }}</h2>
                            <div class="row">
                                <div class="col-12 mb-2">{{ __('Notification Panel') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('notification.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-2">{{ __('Send Notification') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('notification.send', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#notificationModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="notificationModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Notifications Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="Notification Panel" :user="$user" name="notification_index" permission="notification.index" />

                                                <x-permission-input title="Send Notification" :user="$user" name="notification_send" permission="notification.send" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Customer ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Customers') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('customer.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Create') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('customer.create', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('customer.show', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('customer.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Edit') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('customer.edit', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('customer.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#customerModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="customerModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Customer Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="customer_index" permission="customer.index" />

                                                <x-permission-input title="Create" :user="$user" name="customer_create" permission="customer.create" />

                                                <x-permission-input title="Show" :user="$user" name="customer_show" permission="customer.show" />

                                                <x-permission-input title="Store" :user="$user" name="customer_store" permission="customer.store" />

                                                <x-permission-input title="Edit" :user="$user" name="customer_edit" permission="customer.edit" />

                                                <x-permission-input title="Update" :user="$user" name="customer_update" permission="customer.update" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Products ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Products') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('product.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Create') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('product.create', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('product.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Edit') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('product.edit', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('product.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Status Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('product.status.toggle', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#productModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="productModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Products Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="product_index" permission="product.index" />

                                                <x-permission-input title="Create" :user="$user" name="product_create" permission="product.create" />

                                                <x-permission-input title="Store" :user="$user" name="product_store" permission="product.store" />

                                                <x-permission-input title="Edit" :user="$user" name="product_edit" permission="product.edit" />

                                                <x-permission-input title="Update" :user="$user" name="product_update" permission="product.update" />

                                                <x-permission-input title="Status Update" :user="$user" name="product_status_toggle" permission="product.status.toggle" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Banner ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Banners') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('banner.promotional', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('banner.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Edit') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('banner.edit', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('banner.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Delete') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('banner.destroy', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Status Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('banner.status.toggle', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#bannerModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="bannerModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Banner Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="banner_promotional" permission="banner.promotional" />

                                                <x-permission-input title="Store" :user="$user" name="banner_store" permission="banner.store" />

                                                <x-permission-input title="Edit" :user="$user" name="banner_edit" permission="banner.edit" />

                                                <x-permission-input title="Update" :user="$user" name="banner_update" permission="banner.update" />

                                                <x-permission-input title="Delete" :user="$user" name="banner_destroy" permission="banner.destroy" />

                                                <x-permission-input title="Status Update" :user="$user" name="banner_status_toggle" permission="banner.status.toggle" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Order ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Orders') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('All Orders') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('order.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Order Details') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('order.show', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-2">{{ __('Change Order Status') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('order.status.change', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Print Labels') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('order.print.labels', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Prtint Invoice') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('order.print.invioce', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#orderModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="orderModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit order Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="All Orders" :user="$user" name="order_index" permission="order.index" />

                                                <x-permission-input title="Order Details" :user="$user" name="order_show" permission="order.show" />

                                                <x-permission-input title="Order Status Change" :user="$user" name="order_status_change" permission="order.status.change" />

                                                <x-permission-input title="Print Labels" :user="$user" name="order_print_labels" permission="order.print.labels" />

                                                <x-permission-input title="Print invoice" :user="$user" name="order_print_invioce" permission="order.print.invioce" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Order Schedule ===================== --}}
                    {{-- <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>Order Schedules</h2>
                            <div class="row">
                                <div class="col-12 mb-2">Schedule List:
                                    <div class="text-right float-right">
                                        @if (in_array('schedule.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mb-2">{{ __('Status Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('toggole.status.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('schedule.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#orderScheduleModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="orderScheduleModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">Edit Order Schedule Permissions</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="Schedule List" :user="$user" name="schedule_index" permission="schedule.index" />

                                                <x-permission-input title="Status Update" :user="$user" name="toggole_status_update" permission="toggole.status.update" />

                                                <x-permission-input title="Update" :user="$user" name="schedule_update" permission="schedule.update" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- ===================== Revenue ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Revenue') }}</h2>
                            <div class="row">
                                <div class="col-12 mb-2">{{ __('Ravenue panel') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('revenue.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-2">{{ __('Generate Revenue PDF') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('revenue.generate.pdf', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-12 mb-2">{{ __('Generate Report PDF') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('report.generate.pdf', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#revenueModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="revenueModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Revenue Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="Ravenue panel" :user="$user" name="revenue_index" permission="revenue.index" />

                                                <x-permission-input title="Generate Revenue PDF" :user="$user" name="revenue_generate_pdf" permission="revenue.generate.pdf" />

                                                <x-permission-input title="Generate Report PDF" :user="$user" name="report_generate_pdf" permission="report.generate.pdf" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Coupon ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Coupons') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('coupon.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Create') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('coupon.create', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('coupon.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Edit') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('coupon.edit', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('coupon.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#couponModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="couponModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Coupons Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="coupon_index" permission="coupon.index" />

                                                <x-permission-input title="Create" :user="$user" name="coupon_create" permission="coupon.create" />

                                                <x-permission-input title="Store" :user="$user" name="coupon_store" permission="coupon.store" />

                                                <x-permission-input title="Edit" :user="$user" name="coupon_edit" permission="coupon.edit" />

                                                <x-permission-input title="Update" :user="$user" name="coupon_update" permission="coupon.update" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Driver ===================== --}}
                    {{-- <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>Drivers</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('List Show') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('driver.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Create') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('driver.create', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Store') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('driver.store', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">Assign Driver:
                                    <div class="text-right float-right">
                                        @if (in_array('driverAssign', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-6 mb-2">Driver Details:
                                    <div class="text-right float-right">
                                        @if (in_array('driver.details', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#driverModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="driverModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">Edit Drivers Permissions</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="List Show" :user="$user" name="driver_index" permission="driver.index" />

                                                <x-permission-input title="Create" :user="$user" name="driver_create" permission="driver.create" />

                                                <x-permission-input title="Store" :user="$user" name="driver_store" permission="driver.store" />

                                                <x-permission-input title="Assiign Driver" :user="$user" name="driverAssign" permission="driverAssign" />

                                                <x-permission-input title="Show Details" :user="$user" name="driver_details" permission="driver.details" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- ===================== Profile ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Profile') }}</h2>
                            <div class="row">
                                <div class="col-6 mb-2">{{ __('View Profile') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('profile.index', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Edit') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('profile.edit', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 mb-2">{{ __('Update') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('profile.update', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mb-2">{{ __('Change_Password') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('profile.change-password', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#profileModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="profileModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Profile Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="View Profile" :user="$user" name="profile_index" permission="profile.index" />

                                                <x-permission-input title="Edit" :user="$user" name="profile_edit" permission="profile.edit" />

                                                <x-permission-input title="Update" :user="$user" name="profile_update" permission="profile.update" />

                                                <x-permission-input title="Change Password" :user="$user" name="profile_change-password" permission="profile.change-password" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===================== Dashboard ===================== --}}
                    <div class="col-12 col-sm-6 col-lg-6 col-xl-4 mb-4">
                        <div class="card p-2" style="min-height: 12em;">
                            <h2>{{ __('Dashboard') }}</h2>
                            <div class="row">
                                <div class="col-12 mb-2">{{ __('Calculations') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('dashboard.calculation', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mb-2">{{ __('Show Revenue') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('dashboard.revenue', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 mb-2">{{ __('Show Overview') }}:
                                    <div class="text-right float-right">
                                        @if (in_array('dashboard.overview', $permissions))
                                        <span class="badge py-1 badge-success ml-2">{{ __('Yes') }}</span>
                                        @else
                                        <span class="badge py-1 badge-danger ml-2">{{ __('No') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="submit">
                                <button class="btn btn-danger px-2 py-1" data-toggle="modal" data-target="#dashboardModal">{{ __('Edit Permission') }}</button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="dashboardModal">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h3 class="modal-title">{{ __('Edit Dashboard Permissions') }}</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <div class="modal-body pt-0">
                                            <form @role('root') action="{{ route('admin.set-permission', $user->id) }}" @endrole method="POST"> @csrf
                                                <x-permission-input title="Calculations" :user="$user" name="dashboard_calculation" permission="dashboard.calculation" />

                                                <x-permission-input title="Show Revenue" :user="$user" name="dashboard_revenue" permission="dashboard.revenue" />

                                                <x-permission-input title="Show Overview" :user="$user" name="dashboard_overview" permission="dashboard.overview" />

                                                <div class="text-right mt-3">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                    <button class="btn btn-danger @role('visitor') visitorMessage @endrole" type="submit">{{ __('Save Permissions') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .submit{
        position: absolute;
        right: 10px;
        bottom: 10px;
    }
</style>
@endsection
