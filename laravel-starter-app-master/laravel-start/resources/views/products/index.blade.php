<h1> All Products </h1>

<ul>
@foreach($products as $product)
<li> 
<a href="/products/{{ $product['id'] }}">   
     {{ $product['name'] }} -- {{ $product['category'] }} -- {{ $product['price'] }} 
</a>
</li>
@endforeach

</ul>