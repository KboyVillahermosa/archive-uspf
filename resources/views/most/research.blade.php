
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
	<div class="p-6">
		<h3 class="text-lg font-semibold mb-4 text-gray-800">Most Viewed Research</h3>
		@if(!empty($mostViewedResearch) && count($mostViewedResearch) > 0)
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				@foreach($mostViewedResearch as $item)
					@php $model = $item['model']; $type = $item['type']; @endphp
					<a href="{{ route($type . '.show', $model->id) }}" class="block bg-blue-50 p-4 rounded-lg border border-blue-200 hover:shadow-lg hover:bg-blue-100 transition duration-300 transform hover:-translate-y-1">
						<div class="flex items-center mb-2">
							<span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded capitalize">{{ $type }}</span>
						</div>
						<h4 class="font-medium text-gray-900 mb-2 hover:text-blue-800">{{ Str::limit($model->title ?? $model->name, 50) }}</h4>
						<p class="text-xs text-gray-500 mb-2">Views: {{ $item['views'] }}</p>
						<p class="text-xs text-gray-500 mb-2">Downloads: {{ $item['downloads'] }}</p>
					</a>
				@endforeach
			</div>
		@else
			<div class="text-center text-gray-500 py-4">No data available.</div>
		@endif
	</div>
</div>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
	<div class="p-6">
		<h3 class="text-lg font-semibold mb-4 text-gray-800">Most Popular Research</h3>
		@if(!empty($mostPopularResearch) && count($mostPopularResearch) > 0)
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				@foreach($mostPopularResearch as $item)
					@php $model = $item['model']; $type = $item['type']; @endphp
					<a href="{{ route($type . '.show', $model->id) }}" class="block bg-yellow-50 p-4 rounded-lg border border-yellow-200 hover:shadow-lg hover:bg-yellow-100 transition duration-300 transform hover:-translate-y-1">
						<div class="flex items-center mb-2">
							<span class="text-xs font-medium text-yellow-700 bg-yellow-100 px-2 py-1 rounded capitalize">{{ $type }}</span>
						</div>
						<h4 class="font-medium text-gray-900 mb-2 hover:text-yellow-800">{{ Str::limit($model->title ?? $model->name, 50) }}</h4>
						<p class="text-xs text-gray-500 mb-2">Popularity Score: {{ number_format($item['score'], 1) }}</p>
						<p class="text-xs text-gray-500 mb-2">Views: {{ $item['views'] }} | Downloads: {{ $item['downloads'] }}</p>
					</a>
				@endforeach
			</div>
		@else
			<div class="text-center text-gray-500 py-4">No data available.</div>
		@endif
	</div>
</div>
