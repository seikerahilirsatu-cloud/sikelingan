<div class="flex items-center gap-3 min-w-0 overflow-hidden">
	@php
		// allow callers to override sizing by passing a style attribute; otherwise use a safe default
		$imgStyle = $attributes->get('style') ?? 'height:40px; width:auto; max-height:40px;';
	@endphp

	{{-- Logo image: use inline style fallback to guarantee a constrained display size when utility classes are unavailable. --}}
	<img src="{{ asset('images/kelurahan-logo.png') }}" style="{{ $imgStyle }}" {{ $attributes->except('style')->merge(['class' => 'w-auto object-contain flex-shrink-0']) }} alt="Logo Kelurahan" />

	{{-- Stacked title + subtitle. Title is more prominent to match the screenshot. --}}
	<div class="min-w-0 text-left">
		<div class="font-semibold text-sm sm:text-base uppercase tracking-wide text-gray-900 truncate">SIKELINGAN</div>
		<div class="text-xs sm:text-sm text-gray-500 truncate">Sistem Informasi Kelurahan &amp; Lingkungan</div>
	</div>
</div>
