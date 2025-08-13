@extends('layouts.adminLayout.index')

@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Edit Certification Footer</h3>
    </div>
    <div class="panel-body">
        <form action="{{ route('certification-footer.update', $footer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="picture1">Picture 1</label>
                        @if($footer->picture1)
                            <div>
                                <img src="{{ asset('storage/'.$footer->picture1) }}" class="img-thumbnail" style="max-height: 100px;">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remove_picture1"> Remove this image
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="picture1" name="picture1">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo1">Logo 1</label>
                        @if($footer->logo1)
                            <div>
                                <img src="{{ asset('storage/'.$footer->logo1) }}" class="img-thumbnail" style="max-height: 100px;">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remove_logo1"> Remove this image
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="logo1" name="logo1">
                    </div>
                    <div class="form-group">
                        <label for="logo1description">Logo 1 Description</label>
                        <textarea class="form-control" id="logo1description" name="logo1description" rows="2">{{ $footer->logo1description }}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo2">Logo 2</label>
                        @if($footer->logo2)
                            <div>
                                <img src="{{ asset('storage/'.$footer->logo2) }}" class="img-thumbnail" style="max-height: 100px;">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remove_logo2"> Remove this image
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="logo2" name="logo2">
                    </div>
                    <div class="form-group">
                        <label for="logo2description">Logo 2 Description</label>
                        <textarea class="form-control" id="logo2description" name="logo2description" rows="2">{{ $footer->logo2description }}</textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo3">Logo 3</label>
                        @if($footer->logo3)
                            <div>
                                <img src="{{ asset('storage/'.$footer->logo3) }}" class="img-thumbnail" style="max-height: 100px;">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remove_logo3"> Remove this image
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="logo3" name="logo3">
                    </div>
                    <div class="form-group">
                        <label for="logo3description">Logo 3 Description</label>
                        <textarea class="form-control" id="logo3description" name="logo3description" rows="2">{{ $footer->logo3description }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection