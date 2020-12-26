@section('title', 'My Profile - '.\Auth::user()->name)
@section('parentPageTitle', 'Home')

<div class="row clearfix">

    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <ul class="nav nav-tabs">                                
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Settings">General</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="Settings">
                    <div class="body">
                        <h6>Profile Photo</h6>
                        <form wire:submit.prevent="autoSavePhoto" class="form_upload_photo">
                            <div class="media photo">
                                <div class="media-left m-r-15">
                                    <img src="{{ $profile_photo_path }}" style="width:100px;"  class="user-photo media-object" alt="User">
                                </div>
                                <div class="media-body">
                                    @error('photo')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    <p>Upload your photo.
                                        <br><em>Image should be at least 140px x 140px</em></p>
                                    <button type="button" class="btn btn-default-dark" id="btn-upload-photo"><i class="fa fa-upload"></i> Upload Photo</button>
                                    <input type="file" wire:model="photo" id="filePhoto" class="sr-only">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                        </form>
                    </div>

                    <div class="body">
                        <form wire:submit.prevent="saveBasicInformation">
                            <h6>Basic Information</h6>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">                                                
                                        <input type="text" class="form-control" placeholder="First Name" wire:model="name">
                                    </div>
                                    <div class="form-group">                                                
                                        <input type="text" class="form-control" placeholder="Email" wire:model="email">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label>Birthdate</label>
                                            <input type="date" class="form-control" placeholder="Birthdate">
                                        </div>
                                        <div class="form-group col-6">
                                            <div class="mt-4">
                                                <label class="fancy-radio">
                                                    <input name="gender2" value="male" type="radio" checked>
                                                    <span><i></i>Male</span>
                                                </label>
                                                <label class="fancy-radio">
                                                    <input name="gender2" value="female" type="radio">
                                                    <span><i></i>Female</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="http://">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">                                                
                                        <textarea class="form-control" wire:model="address" placeholder="Address" style="height:100px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                        </form>
                    </div>
                    <hr />
                    <div class="body">
                        <form  wire:submit.prevent="saveChangePassword">
                            @if(session()->has('message-password'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-check-circle"></i> {{session('message-password')}}
                                </div>
                            @endif
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <h6>Change Password</h6>
                                    <div class="form-group">
                                        <input type="password" class="form-control" wire:model="current_password" placeholder="Current Password">
                                        @error('current_password')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" wire:model="new_password" placeholder="New Password">
                                        @error('new_password')
                                        <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" wire:model="confirm_new_password" placeholder="Confirm New Password">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                        </form>
                    </div>
                    <hr />
                    <div class="body">
                        <h6>General Information</h6>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Phone Number">
                                </div>
                                <div class="form-group">
                                   
                                </div>
                                <div class="form-group">
                                    <label>Date Format</label>
                                    <div class="fancy-radio">
                                        <label><input name="dateFormat" value="" type="radio"><span><i></i>May 18, 2018</span></label>&nbsp;&nbsp;
                                        <label><input name="dateFormat" value="" type="radio"><span><i></i>2018, May, 18</span></label>&nbsp;&nbsp;
                                        <label><input name="dateFormat" value="" type="radio" checked><span><i></i>2018-03-10</span></label>&nbsp;&nbsp;
                                        <label><input name="dateFormat" value="" type="radio"><span><i></i>02/09/2018</span></label>&nbsp;&nbsp;
                                        <label><input name="dateFormat" value="" type="radio"><span><i></i>10/05/2018</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <h6>Email from Lucid</h6>
                                <p>I'd like to receive the following emails:</p>
                                <ul class="list-unstyled list-email-received">
                                    <li>
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" checked><span>Weekly account summary</span></label>
                                    </li>
                                    <li>
                                        <label class="fancy-checkbox">
                                            <input type="checkbox"><span>Campaign reports</span></label>
                                    </li>
                                    <li>
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" checked><span>Promotional news such as offers or discounts</span></label>
                                    </li>
                                    <li>
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" checked><span>Tips for campaign setup, growth and client success stories</span></label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary">Update</button> &nbsp;&nbsp;
                        <button class="btn btn-default">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('page-script')
    $(function() {
        // photo upload
        $('#btn-upload-photo').on('click', function() {
            $(this).siblings('#filePhoto').trigger('click');
        });

        // plans
        $('.btn-choose-plan').on('click', function() {
            $('.plan').removeClass('selected-plan');
            $('.plan-title span').find('i').remove();

            $(this).parent().addClass('selected-plan');
            $(this).parent().find('.plan-title').append('<span><i class="fa fa-check-circle"></i></span>');
        });
    });

@stop
