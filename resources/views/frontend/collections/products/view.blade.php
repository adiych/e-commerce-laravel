@extends('layouts.app')

@section('title')
{{ $product->meta_title }}
@endsection

@section('meta_description')
{{ $product->meta_description }}
@endsection

@section('meta_keyword')
{{ $product->meta_keyword }}
@endsection

<livewire:frontend.product.view :category="$category" :product="$product">