<!-- registration.blade.php -->
<body style="background-color: #3f8ceb ;">
@extends('master')

@section('content')
<div class="container mt-3">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 m-auto">
            <form method="post" action=" {{ url('store_users') }} " enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="card shadow mb-4">
                    <div class="car-header bg-success pt-2">
                        <div class="card-title font-weight-bold text-white text-center"> User Registration </div>
                    </div>

                    <div class="card-body">

                            <label for="firstname"><b>First Name</b></label>
                            <input type="text" class="form-control"  name="firstname" placeholder="Enter First Name" required/>
            
                            
                            <label for="lastname"><b>Last Name</b></label>
                            <input type="text" class="form-control"  name="lastname" placeholder="Enter Last Name" required/>
            
                            <label for="phonenumber"><b>Phone Number</b></label>
                            <input type="number" class="form-control"  name="phonenumber" placeholder="Enter Phone" required/>
            
        
                        
                            <label for="password"><b>Password</b></label>
                            <input type="text" class="form-control"  name="password" placeholder="Enter Password" required/>
            


                    </div>

                    <div class="card-footer d-inline-block">
                        <button type="submit" class="btn btn-success"> Register </button>
                    <p class="float-right mt-2"> Already have an account?  <a href="{{ url('/')}}" class="text-success"> Login </a> </p>
                    </div>
                    @csrf
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
</body>