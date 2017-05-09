<div class="panel panel-default">
    <div class="panel-heading">Avatar Settings</div>
    <div class="panel-body">
    	<img class="img-thumbnail" src="{{ url('avatar/128') }}" alt="Current Avatar"> 
    	<h3>Change Avatar</h3>
        <form role="form" method="POST" action="{{ url('/settings/avatar') }}" enctype="multipart/form-data">
            {!! csrf_field() !!}

            <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                <input type="file" class="form-control" name="file">

                @if ($errors->has('file'))
                    <span class="help-block">
                        <strong>{{ $errors->first('file') }}</strong>
                    </span>
                @else
                	<span class="help-block">
						The avatar should be atleast 180x180.
                	</span>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>