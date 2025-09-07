@extends('layout.app')

@section('title_page')
    Shop 
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Категории</div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($categories as $category)
                            <li class="list-group-item">
                                <a href="{{ route('category.show', $category->id) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">Сортировка</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('home') }}">
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>По названию (А-Я)</option>
                            <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>По названию (Я-А)</option>
                            <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>По цене (↑)</option>
                            <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>По цене (↓)</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h1>Магазин</h1>
            
            <div class="row">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection