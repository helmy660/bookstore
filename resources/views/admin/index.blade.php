@extends('layouts.admin.nav')


@section('content')
<div class="col-sm-12">

<div class="row">
<div class="col-sm-12">
    <h1 style="margin-left:40%;margin-bottom:2%;margin-top:2%">Profit per Week</h1>   
</div>

</div>
<div class="app">

{!! $chart->html() !!}

</div>
</div>

{!! Charts::scripts() !!}

{!! $chart->script() !!}
@endsection