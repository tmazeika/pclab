A new order has been submitted:

@foreach($selection as $item)
{{ $item->parent->name }} [{{ $item->parent->asin }}] @ ${{ $item->parent->price / 100 }}

@endforeach