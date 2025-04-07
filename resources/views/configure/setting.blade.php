@extends('layout.body')
@section('title', $title)
@section('content')
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                @foreach ($breadCumbs as $breadItem)
                                    <li class="breadcrumb-item" {{ $breadItem['page'] }}>
                                        <a href="{{ $breadItem['link'] }}">{{ $breadItem['title'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="card">
                <form action="{{ route('setting.store') }}" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ $pageTitle }}
                        </h4>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label class="form-label" for="institution">
                                Institution/ Lembaga <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="institution" name="institution" required
                                autocomplete="off" placeholder="Institution/ Lembaga..."
                                value="{{ $setting ? $setting->institution : old('institution') }}">
                            @error('institution')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="eselon">
                                Eselon/ Badan Peradilan <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="eselon" name="eselon" required
                                autocomplete="off" placeholder="Eselon/ Badan Peradilan..."
                                value="{{ $setting ? $setting->eselon : old('eselon') }}">
                            @error('eselon')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="jurisdiction">
                                Jurisdiction <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="jurisdiction" name="jurisdiction" required
                                autocomplete="off" placeholder="Jurisdiction/ Pengadilan Tk. Banding..."
                                value="{{ $setting ? $setting->jurisdiction : old('jurisdiction') }}">
                            @error('jurisdiction')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="unit">
                                Unit / Satuan Kerja <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="unit" name="unit" required
                                autocomplete="off" placeholder="Unit/ Pengadilan Tk. Pertama..."
                                value="{{ $setting ? $setting->unit : old('unit') }}">
                            @error('unit')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="address">
                                Address <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="address" name="address" required
                                autocomplete="off" placeholder="Address..."
                                value="{{ $setting ? $setting->address : old('address') }}">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="province">
                                Province <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="province" name="province" required
                                autocomplete="off" placeholder="Province..."
                                value="{{ $setting ? $setting->province : old('province') }}">
                            @error('province')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="city">
                                City / Regency <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="city" name="city" required
                                autocomplete="off" placeholder="City / Regency..."
                                value="{{ $setting ? $setting->city : old('city') }}">
                            @error('city')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="postCode">
                                Postal Code <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="postCode" name="postCode" required
                                autocomplete="off" placeholder="Postal Code..."
                                value="{{ $setting ? $setting->post_code : old('postCode') }}">
                            @error('postCode')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="email">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" required
                                autocomplete="off" placeholder="Postal Code..."
                                value="{{ $setting ? $setting->email : old('email') }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="website">
                                Website <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="website" name="website" required
                                autocomplete="off" placeholder="Website..."
                                value="{{ $setting ? $setting->website : old('website') }}">
                            @error('website')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="contact">
                                Contact <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="contact" name="contact" required
                                autocomplete="off" placeholder="Contact..."
                                value="{{ $setting ? $setting->contact : old('contact') }}">
                            @error('contact')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label" for="logo">
                                Logo <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @if ($setting && $setting->logo)
                            <div>
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo" class="img-fluid"
                                    style="max-width: 200px; max-height: 200px;">
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-database"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
