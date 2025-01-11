@extends("adminFolder.admin_master")

@section("content")


<div class="container my-3">

    <h3>Role: <span class="text-success">{{ $role }}</span></h3>

    <div class="row">

        <div class="col-2">
            <h4>Permissions: </h4>
        </div>

        <div class="col-10">
            <form action="/assign-permission" method="post">
                @csrf

                <input type="hidden" value="{{ $role }}" name="role" id="">
                @foreach ($all_permissions as $perm)
                <input type="checkbox" value="{{ $perm->name }}" name="permissions[]" {{ \Spatie\Permission\Models\Role::where("name", $role)->first()->hasPermissionTo($perm->name) ? 'checked' : '' }} id="">
                {{ $perm->name }} &nbsp;&nbsp;
                @endforeach
                @if($role!="admin")

                <input type="submit" value="Done" name="" id="">
                @endif
            </form>

        </div>
    </div>
</div>

@endsection
