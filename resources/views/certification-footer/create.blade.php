@extends('layouts.adminLayout.index')

@section('content')
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Create Certification Footer</h3>
    </div>
    <div class="panel-body">
        <form action="{{ route('certification-footer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="picture1">Picture 1</label>
                        <input type="file" class="form-control" id="picture1" name="picture1">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo1">Logo 1</label>
                        <input type="file" class="form-control" id="logo1" name="logo1">
                    </div>
                    <div class="form-group">
                        <label for="logo1description">Logo 1 Description</label>
                        <textarea class="form-control" id="logo1description" name="logo1description" rows="2"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo2">Logo 2</label>
                        <input type="file" class="form-control" id="logo2" name="logo2">
                    </div>
                    <div class="form-group">
                        <label for="logo2description">Logo 2 Description</label>
                        <textarea class="form-control" id="logo2description" name="logo2description" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="logo3">Logo 3</label>
                        <input type="file" class="form-control" id="logo3" name="logo3">
                    </div>
                    <div class="form-group">
                        <label for="logo3description">Logo 3 Description</label>
                        <textarea class="form-control" id="logo3description" name="logo3description" rows="2"></textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection