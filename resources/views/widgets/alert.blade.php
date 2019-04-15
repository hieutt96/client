@if(session('success'))
    <div class="alert alert-success">
        <button class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        @if(is_array(json_decode(Session::get('success'), true)))
            {!! implode('', Session::get('success')->all(':message<br/>')) !!}
        @else
            {!! Session::get('success') !!}
        @endif
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        <button class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        @if(is_array(json_decode(Session::get('error'), true)))
            {!! implode('', Session::get('error')->all(':message<br/>')) !!}
        @else
            {!! Session::get('error') !!}
        @endif
    </div>
@endif
@if(session('errorValidator'))
    <div class="alert alert-danger">
        <button class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        @if(is_array(json_decode(Session::get('errorValidator'), true)))
            {!! implode('', Session::get('errorValidator')->all(':message<br/>')) !!}
        @else
            {!! Session::get('errorValidator') !!}
        @endif
    </div>
@endif