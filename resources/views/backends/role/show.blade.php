@extends('backends.master')
@push('css')

<style>
    /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 40px;
      height: 22px;
    }

    /* Hide default HTML checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 18px;
      width: 18px;
      left: 2px;
      bottom: 2px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked+.slider {
      background-color: #2196F3;
    }

    input:focus+.slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
      -webkit-transform: translateX(18px);
      -ms-transform: translateX(18px);
      transform: translateX(18px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 22px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    .checkIP{
      width: 20px;
    }
    .show-item{
            padding: 10px;
      }
  </style>
  @endpush
  @section('contents')
  <div class="show-item">
      <div class="row">
          <div class="col-12">
            <div class="back-btn">
              <a href="{{route('roles.index')}}" class="float-left" data-value="veiw">
                  <i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;
                  Back to all Roles
              </a><br>
          </div><br>
              <div class="card">
                  <div class="card-body">
                    <form class="form-material form-horizontal" action="{{ route('roles.store') }}" method="POST">
                      @csrf
                      <div class="row">
                          <div class="col-md-12">
                              <div class="form-group">
                                  <label for="name"><b>@lang('Role')</b></label>
                                  <div class="input-group mb-3">
                                     <p>{{$role->name}}</p>
                                  </div>
                              </div>
                          </div>
                          @if($role->description)
                          <div class="col-md-12">
                            <div class="form-group">
                                <label for="description"><b>@lang('Description')</b></label>
                                <div class="input-group mb-3">
                                   <p>{{$role->description}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                      </div>
                      <div class="d-flex">
                        <label for="" class="mr-2">Permissions</label>
                      </div><br>
                      <div class="row">
                        @foreach($permissions as $permission=>$permissionList)
                        <div class="col-md-4">
                          <label for="" class="mr-2"><b>{{ucwords($permission)}}</b></label><br><br>
                          <div class="row">
                            <div class="col-md-12">
                              @foreach($permissionList as $perm)
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <div class="d-flex align-items-center">
                                              <label class="switch">
                                                <input type="checkbox" id="veiw_user" name="permissions[]" @if(in_array($perm->name, $rolePermissions)) checked @endif value="{{$perm->name}}" disabled="disabled">
                                                <span class="slider round"></span>
                                              </label>
                                              <label class="ml-2" for="">{{$perm->display}}</label>
                                            </div>
                                        </div>
                                    </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                          @endforeach
                    </div>
                    </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
  @endsection
